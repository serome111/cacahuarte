<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReques;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('detail');
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|integer|min:1',
            'state' => 'nullable|in:0,1',
        ]);

        $products = Products::select('id', 'name', 'code', 'stock', 'picture', 'state')
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $search = '%'.$filters['search'].'%';
                $query->where(fn ($query) => $query->where('name', 'like', $search)->orWhere('code', 'like', $search));
            })
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('categorie_id', $category))
            ->when(isset($filters['state']), fn ($query) => $query->where('state', $filters['state']))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.products', [
            'categories' => Categories::select('id', 'name')->orderBy('name')->get(),
            'products' => $products,
        ]);
    }

    public function detail($id)
    {
        return view('public.detailProduc', [
            'global_phone' => config('site.phone'),
            'product' => Products::published()->findOrFail($id),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create',[
            'categories' => Categories::select('id','name')->get(),
            'products' => new Products

       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReques $request)
    {
        $this->saveProduct($request, new Products);

        return redirect()->route('products.index')->with('status', 'Producto creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.products.show',[
            'categories' => Categories::select('id','name')->get(),
            'product' =>  Products::findOrFail($id)

       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.products.edit',[
            'categories' => Categories::select('id','name')->get(),
            'products' =>  Products::findOrFail($id)
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductReques $request, Products $product)
    {
        $this->saveProduct($request, $product);

        return redirect()->route('products.index')->with('status', 'Producto actualizado con éxito');
    }

    public function destroy(Products $product)
    {
        $picture = DB::transaction(function () use ($product) {
            $current = Products::lockForUpdate()->findOrFail($product->getKey());
            if (!$current->delete()) {
                throw new RuntimeException('No se pudo eliminar el producto.');
            }

            return $current->picture;
        });

        $this->deletePicture($picture);

        return redirect()->route('products.index')->with('status', 'Producto eliminado con éxito');
    }

    private function saveProduct(ProductReques $request, Products $product): void
    {
        $data = $request->safe()->except('picture');
        $newPath = null;

        try {
            if ($request->hasFile('picture')) {
                $newPath = $request->file('picture')->store('products', 'public');
                if (!$newPath) {
                    throw ValidationException::withMessages(['picture' => 'No se pudo guardar la imagen.']);
                }
                $data['picture'] = '/storage/'.$newPath;
            }

            $previousPicture = DB::transaction(function () use ($product, $data) {
                $current = $product->exists ? Products::lockForUpdate()->findOrFail($product->getKey()) : $product;
                $previousPicture = $current->picture;
                if (!$current->fill($data)->save()) {
                    throw new RuntimeException('No se pudo guardar el producto.');
                }

                return $previousPicture;
            });
        } catch (Throwable $exception) {
            if ($newPath) {
                $this->deletePicture('/storage/'.$newPath);
            }
            if ($exception instanceof UniqueConstraintViolationException) {
                throw ValidationException::withMessages(['code' => 'Ya existe un producto con ese código.']);
            }
            throw $exception;
        }

        if ($newPath) {
            $this->deletePicture($previousPicture);
        }
    }

    private function deletePicture(?string $url): void
    {
        $path = parse_url($url ?? '', PHP_URL_PATH);
        if (!is_string($path) || !preg_match('~^/storage/(products/[^/]+)$~iD', $path, $matches)) {
            return;
        }

        try {
            if (!Storage::disk('public')->delete($matches[1])) {
                report(new RuntimeException('No se pudo limpiar una imagen de producto.'));
            }
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}

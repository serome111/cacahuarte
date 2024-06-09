<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReques;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('detail');
    }

    public function index()
    {
       return view('admin.products.products',[
            'categories' => Categories::select('id','name')->get(),
            'products' => Products::select('id','name','code','stock','picture','state')->paginate(10)
       ]);
    }
    public function detail($id)
    {
        return view('public.detailProduc',[
            'global_phone' => env('global_phone', ''),
            'product' =>  Products::findOrFail($id)
        ]);
    }

    public function filter(Request $request)
    {
        return "hola fetch";
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
        $codePro = Products::select('code')->where('code', $request->code )->get();
        if($codePro->count() === 0){
            $link = $request->file('picture')->store('public/products');
            $link = Storage::url($link);
            $data = $request->all();
            $data['picture'] = $link;
            Products::create($data);
            return redirect()->route('products.index')->with('status', 'Producto creado con exito');
        }else{
            return redirect()->route('products.create')->with('status', 'No se pudo crear el Producto el codigo ya existe');
        }
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
    public function update(ProductReques $request,Products $product)
    {
        if (empty($request->picture)) {
            $product->update($request->validated());
            return redirect()->route('products.index')->with('status', 'Producto actualizado con exito');
        }else{
            $remplazar = array("storage","Storage");
            $link = str_replace($remplazar, "public", $product->picture);
            $product->picture = $link;
            if(Storage::delete($product->picture)){
                $link = $request->file('picture')->store('public/products');
                $link = Storage::url($link);
                $data = $request->all();
                $data['picture'] = $link;
                $product->update($data);
                return redirect()->route('products.index')->with('status', 'Producto actualizado con exito');
            }else{
                return redirect()->route('values.index')->with('status', 'error al actualizar imagen del producto');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        $remplazar = array("storage","Storage");
        $link = str_replace($remplazar, "public", $product->picture);
        $product->picture = $link;
        if(Storage::delete($product->picture)){
            $product->delete();
            return redirect()->route('products.index')->with('status', 'Producto Eliminado con exito');
        }else{
            return redirect()->route('banner.index')->with('status', 'Hubo un error al eliminar el Producto');
        }
    }
}

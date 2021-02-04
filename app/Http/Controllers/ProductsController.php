<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReques;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.products.products',[
            'categories' => Categories::select('id','name')->get(),
            'products' => Products::select('id','name','code','stock','picture')->get()
       ]);
    }

    public function filter($request)
    {
        return $request;
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
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

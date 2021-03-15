<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesReques;
use App\Models\Categories;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.categories',[
            'categories' => Categories::latest('updated_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('categories.index')->with('status', 'error codido 404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesReques $request)
    {
        Categories::create($request->validated());
        return redirect()->route('categories.index')->with('status', 'categoría creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('categories.index')->with('status', 'error codido 404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('categories.index')->with('status', 'error codido 404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesReques $request, $id)
    {
        Categories::where('id',$id)->update($request->validated());
        return redirect()->route('categories.index')->with('status', 'Categoria Actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        categories::where('id', $id)->delete();
        return redirect()->route('categories.index')->with('status', 'Categoria Eliminada con exito');
    }
}

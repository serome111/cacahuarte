<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValueReques;
use App\Models\Values;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.values.values',[
            'values' => Values::latest('updated_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Values $value)
    {
        return view('admin.values.edit',[
            'values' => Values::findOrFail( $value->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValueReques $request, Values $value)
    {
        if (empty($request->picture)) {
            $value->update($request->validated());
            return redirect()->route('values.index')->with('status', 'banner actualizado con exito');
        }else{
            $remplazar = array("storage","Storage");
            $link = str_replace($remplazar, "public", $value->picture);
            $value->picture = $link;
            if (Storage::exists($value->picture)) {
                if(Storage::delete($value->picture)){
                    $link = $request->file('picture')->store('public/values');
                    $link = Storage::url($link);
                    $data = $request->all();
                    $data['picture'] = $link;
                    $value->update($data);
                    return redirect()->route('values.index')->with('status', 'banner actualizado con exito');
                }else{
                    return redirect()->route('values.index')->with('status', 'error al eliminar el banner!');
                }
            }else{
                $link = $request->file('picture')->store('public/values');
                $link = Storage::url($link);
                $data = $request->all();
                $data['picture'] = $link;
                $value->update($data);
                return redirect()->route('values.index')->with('status', 'banner actualizado con exito');
            }
        }
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

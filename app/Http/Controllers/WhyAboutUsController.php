<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// se importa el modelo
use App\Models\WhyAboutUs;
use Carbon\Carbon;
use App\Models\Icon;

//validacion
use App\Http\Requests\CreateTarjetasRequest;

class WhyAboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cardCompleta = WhyAboutUs::select('why_about_us.*','icons.icon_class')
                ->join('icons', 'why_about_us.icon_id', '=', 'icons.id')
                ->get();
        return view('admin.why-about-us.why-about-us',compact('cardCompleta'));

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
    public function store(CreateTarjetasRequest $request)
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$iconos = Icon::all();
        $tarjetas = WhyAboutUs::select('why_about_us.*','icons.icon_hex_code', 'icons.icon_name')
                ->join('icons', 'why_about_us.icon_id', '=', 'icons.id')
                ->where('why_about_us.id','=',$id)
                ->get();
        return view('admin.why-about-us.edit',compact('tarjetas','iconos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTarjetasRequest $request, $id)
    {
        // WhyAboutUs::where('id',$id)->update($request->all());
        $tarjeta = WhyAboutUs::findOrFail($id);
        $tarjeta->update($request->all());
        return redirect('why-about-us')->with('status','Tarjeta actualizada con éxito');
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

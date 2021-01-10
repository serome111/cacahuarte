<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

//para hacer consultas join
use Illuminate\Support\Facades\DB;
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
        // $tarjetas=WhyAboutUs::all();
        // $iconos=Icon::all();
        $cardCompleta = DB::table('why_about_us')
            ->join('icons', 'why_about_us.icon_id', '=', 'icons.id')
            ->select('why_about_us.*','icons.icon_class')
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
    	$tarjeta = new WhyAboutUs; 
    	$iconos = Icon::all();
       return view('admin.why-about-us.create',compact('tarjeta','iconos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTarjetasRequest $request)
    {
        $datos = $request->all();
        WhyAboutUs::create($datos);
        return redirect('why-about-us')->with('status','Tarjeta creada con éxito');
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
    	$tarjetas = DB::table('why_about_us')
            ->join('icons', 'why_about_us.icon_id', '=', 'icons.id')
            ->select('why_about_us.*','icons.icon_hex_code', 'icons.icon_name')
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
        $tarjeta = WhyAboutUs::findOrFail($id);
		
		$tarjeta->delete();
		
		return redirect("why-about-us")->with('status','Tarjeta eliminada con éxito');
    }
}

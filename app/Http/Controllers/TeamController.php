<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
// validación
use App\Http\Requests\TeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Team::all();
        return view('admin/team/team',compact('team'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.team.create',[
            'team' => new Team
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        // return $request;
        $entrada=$request->all();
        if($archivo=$request->file('imagen')){
           
           $nombre=$archivo->getClientOriginalName();
           
           $archivo->move('images/team', $nombre);
           
           $entrada['imagen']=$nombre;
           
        }
       
        try {
            Team::create($entrada);
            //redireccionamos al index
            return redirect("team")->with('status','Integrante creado con éxito');
        } catch (Exception $e) {
            return redirect("team")->with('status','Error al crear el integrante');
            // return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
       return view('admin.team.edit',[
            'team' => Team::findOrFail( $team->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, Team $team)
    {
        $integrante = Team::findOrFail($team->id);
        //usamos fill para llenar los campos del modelo pero aún no se guardan porque hay operaciones por realizar
        $imagen = $integrante->fill($request->all());
        
        if($archivo=$request->file('imagen')){
            
            //verificamos si hay una imagen 
            if($request->hasFile('imagen')){
                //borramos la imagen de la carpeta public   
                File::delete(public_path('images/team/'.Team::findOrFail($team->id)->imagen));
                
            }
           
           $nombre=$archivo->getClientOriginalName();
           
           $archivo->move('images/team', $nombre);
           
           $imagen['imagen']=$nombre; 
       }

       try {
            $integrante->update($request->all($imagen['imagen']));
            //redireccionamos al index
             return redirect("team")->with('status','Integrante actualizado con éxito');
       } catch (Exception $e) {
            return redirect("team")->with('status','Error al crear el integrante');
            // return false;
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {   
        $integrante = Team::findOrFail($team->id);
        $rutaimagen = public_path('images/team/'.$integrante->imagen);
        
        try 
        {
            File::delete($rutaimagen);
            $integrante->delete();
            return redirect("team")->with('status','Integrante eliminado con éxito');

        } catch (Throwable $e) {
            report($e);
            return redirect("team")->with('status','Error al eliminar el integrante');
            // return false;
        }
    }
}

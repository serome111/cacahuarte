<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
// Modelos
use App\Models\Clients;
// validaciones
use App\Http\Requests\ClientRequest;


class ClientsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clients.clients',[
            'clientes' => Clients::latest('updated_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.clients.create',[
            'cliente' => new Clients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {

        $entrada=$request->all();
	   if($archivo=$request->file('imagen')){

		   $nombre=$archivo->getClientOriginalName();

		   $archivo->move('images/clients', $nombre);

		   $entrada['imagen']=$nombre;

	   }
	   try {
	   		Clients::create($entrada);
	   		//redireccionamos al index
	    	return redirect("clients")->with('status','Cliente creado con éxito');
	   } catch (Exception $e) {
	   		return redirect("clients")->with('status','Error al crear el cliente');
	        // return false;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$cliente = Clients::findOrFail($id);
    	return view('admin.clients.edit', compact('cliente'));
        //  return view('admin.clients.edit',[
        //     'cliente' => Clients::findOrFail($id)
        // ])->with('status', 'usuario editado con exito');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
    	// return $request->all();
    	$cliente = Clients::findOrFail($id);
		//usamos fill para llenar los campos del modelo pero aún no se guardan porque hay operaciones por realizar
    	$imagen = $cliente->fill($request->all());

    	if($archivo=$request->file('imagen')){

			//verificamos si hay una imagen
			if($request->hasFile('imagen')){
				//borramos la imagen de la carpeta public
				File::delete(public_path('images/clients/'.Clients::findOrFail($id)->imagen));
			}

		   $nombre=$archivo->getClientOriginalName();
		   $archivo->move('images/clients', $nombre);
		   $imagen['imagen']=$nombre;
	   }

	   try {
	  		$cliente->update($request->all($imagen['imagen']));
	   		//redireccionamos al index
	  		 return redirect("clients")->with('status','Cliente actualizado con éxito');
	   } catch (Exception $e) {
	   		return redirect("clients")->with('status','Error al crear el cliente');
	        // return false;
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
    	$cliente = Clients::findOrFail($id);
    	$rutaimagen = public_path('images/clients/'.$cliente->imagen);

    	try
    	{
    		File::delete($rutaimagen);
       		$cliente->delete();
    		return redirect("clients")->with('status','Cliente eliminado con éxito');

	    } catch (Throwable $e) {
	        report($e);
    		return redirect("clients")->with('status','Error al eliminar el cliente');
	        // return false;
	    }
    }
}

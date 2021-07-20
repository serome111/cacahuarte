<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index',[
            'users' => User::latest('updated_at')->get(),
            'roles' => Role::latest('updated_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $userExist = User::select('email')->where('email', $request->email )->get();
        if($userExist->count() === 0){
            $data['role_id']=$request['rol'];
            $data['name'] = $request['name'];
            $data['email'] = $request['email'];
            $data['password'] = Hash::make($request['password']);
            ;
            User::create($data);
            return redirect()->route('users.index')->with('status', 'Usuario creado con exito');
        }else{
            return redirect()->route('users.index')->with('status', 'No se pudo crear el usuario pues ya existe');
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
        return "Mostrar usuario";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return "editando usuario";
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
        return "actualizando usuario";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        // User::where('id', $id)->where('')->get();
        return redirect()->route('users.index')->with('status', 'Usuario eliminado con exito');
    }
}

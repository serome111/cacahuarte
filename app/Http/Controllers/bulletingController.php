<?php

namespace App\Http\Controllers;

use App\Http\Requests\bulletingRequest;
use App\Models\bulleting;
use Illuminate\Http\Request;

class bulletingController extends Controller
{
    public function store(bulletingRequest $request)
    {
    	$email = bulleting::select('email')->where('email', $request->email )->get();
        if($email->count() > 0){
        	return redirect()->route('index');
        }else{
        	bulleting::create($request->validated());
     		return redirect()->route('index')->with('status', 'Suscrito exitosamente');
        }
    }
}

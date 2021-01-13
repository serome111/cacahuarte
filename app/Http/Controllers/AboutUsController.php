<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Icon;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('admin.about_us.about_us',[
            'about_us' => AboutUs::where('id',1)->get(),
            'icons' => Icon::latest('created_at')->get()
        ]);
    }

    public function edit($id)
    {
        return 'hola';
    }

    public function update(AboutUsRequest $request, AboutUs $AboutUs)
    {
        return 'actualizando';
    }
}

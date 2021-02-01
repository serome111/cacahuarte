<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;




class AboutUsController extends Controller
{
    public function index()
    {
        return view('admin.about_us.about_us',[
            'about_us' => AboutUs::findOrFail(1),

            'icons' => Icon::latest('created_at')->get()
        ]);
    }

    public function edit($id)
    {
        return 'hola';
    }

    public function update(AboutUsRequest $request, $id)
    {
        $about = AboutUs::findOrFail($id);
        // return $request->validated();
        if (empty($request->photo)) {
            // AboutUs::create($request->validated());

                $about->update($request->validated());
                return redirect()->route('about_us.index')->with('status', 'se actualizo con exito');
            }else{
                // return "llego foto";
                $remplazar = array("storage","Storage");
                $link = str_replace($remplazar, "public",  $about->photo);
                $request->photo = $link;
                if(Storage::delete($request->photo)){
                    $link = $request->file('photo')->store('public/about_us');
                    $link = Storage::url($link);
                    $data = $request->all();
                    $data['photo'] = $link;
                    $about->update($data);
                    return redirect()->route('about_us.index')->with('status', 'se actualizo con exito');
                }else{
                    return redirect()->route('about_us.index')->with('status', 'error al eliminar la foto!');
                }
            }
    }

    public function show($id)
    {
        return 'show';
    }
}

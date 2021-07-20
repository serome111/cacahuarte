<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBannerRequest;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class bannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banner.banner',[
            'banners' => Banners::latest('updated_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $banner = DB::table('')->get();
        // Flight::where('state', 1)->update(['state' => 0]);

        return view('admin.banner.create',[
            'banners' => new Banners
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBannerRequest $request)
    {
        $link = $request->file('photo')->store('public/banners');
        $link = Storage::url($link);
        $request->photo = 1;
        $data = $request->all();
        $data['photo'] = $link;
        $count = Banners::count();
        if ($request->state == 1) {
            if($count <= 10){
                Banners::where('state',1)->update(['state' => 0]);
                Banners::create($data);
                return redirect()->route('banner.index')->with('status', 'banner creado con exito');
            }else{
                return redirect()->route('banner.index')->with('status', 'No se ha podido crear banner');
            }
        }else if($count >= 10){
             return redirect()->route('banner.index')->with('status', 'No se ha podido crear banner');
        }else{
            Banners::create($data);
            return redirect()->route('banner.index')->with('status', 'banner creado con exito');
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
    public function edit(Banners $banner)
    {
        return view('admin.banner.edit',[
            'banners' => Banners::findOrFail( $banner->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateBannerRequest $request, Banners $banner)
    {
        if ($request->state == 1) {

            Banners::where('state',1)->update(['state' => 0]);
            if (empty($request->photo)) {
                $banner->update($request->validated());
                return redirect()->route('banner.index')->with('status', 'banner actualizado con exito');
            }else{
                $remplazar = array("storage","Storage");
                $link = str_replace($remplazar, "public", $banner->photo);
                $banner->photo = $link;
                if(Storage::delete($banner->photo)){
                    $link = $request->file('photo')->store('public/banners');
                    $link = Storage::url($link);
                    $data = $request->all();
                    $data['photo'] = $link;
                    $banner->update($data);
                    return redirect()->route('banner.index')->with('status', 'banner actualizado con exito');
                }else{
                    return redirect()->route('banner.index')->with('status', 'error al eliminar el banner!');
                }
            }
        }
        if (empty($request->photo)) {
            $banner->update($request->validated());
            return redirect()->route('banner.index')->with('status', 'banner actualizado con exito');
        }else{
            $link = $request->file('photo')->store('public/banners');
            $link = Storage::url($link);
            $data = $request->all();
            $data['photo'] = $link;
            $banner->update($data);
            return redirect()->route('banner.index')->with('status', 'banner actualizado con exito');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banners $banner)
    {
        $remplazar = array("storage","Storage");
        $link = str_replace($remplazar, "public", $banner->photo);
        $banner->photo = $link;
        if(Storage::delete($banner->photo)){
            $banner->delete();
            return redirect()->route('banner.index')->with('status', 'banner Eliminado con exito');
        }else{
            return redirect()->route('banner.index')->with('status', 'Hubo un error al eliminar el banner');
        }
    }
}

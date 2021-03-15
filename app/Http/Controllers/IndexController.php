<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Banners;
use App\Models\Clients;
use App\Models\Faq;
use App\Models\Products;
use App\Models\Team;
use App\Models\Values;
use App\Models\WhyAboutUs;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return view('welcome');
        return view('index',[
            'banners' => Banners::where('state', 1)->get(),
            'tarjetas' => WhyAboutUs::select('why_about_us.*','icons.icon_class')
                ->join('icons', 'why_about_us.icon_id', '=', 'icons.id')
                ->get(),
            'clientes' => Clients::where('estado', 1)->get(),
            'about_us' => AboutUs::select('about_us.*','ic.icon_class AS icon1','ic2.icon_class AS icon2','ic3.icon_class AS icon3')
            ->join('icons as ic',  'about_us.favicon1', '=', 'ic.id')
            ->join('icons as ic2', 'about_us.favicon2', '=', 'ic2.id')
            ->join('icons as ic3', 'about_us.favicon3', '=', 'ic3.id')
            ->get(),
            'values' => Values::where('state', 1)->get(),
            'team' => Team::where('state', 1)->get(),
            'products' => Products::select('id','name','code','stock','picture')->where('state', 1)->take(10)->get(),
            'faqs' => Faq::latest('updated_at')->get()
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

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

    public function edit($id)
    {
        //
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
        //
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

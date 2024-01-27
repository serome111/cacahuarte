<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contact_us.contact_us',[
            'global_phone' => env('global_phone', ''),
            'contact' => ContactUs::latest('updated_at')->get(),
            'cantidad' => ContactUs::latest('updated_at')->get()->count()
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

    public function filter(Request $request)
    {   
        try {
            $request->validate([
                'text' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Valor no valido o en 0'], 422);
        }
        $text = $request->input('text');
        $contacts = ContactUs::where('email', 'LIKE', "%$text%")->get();
        if ($contacts->isEmpty()) {
            return response()->json(["error"]);
        }
        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ContactUs::create($request->all());
        return "OK";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mensaje = ContactUs::findOrFail($id);
        $mensaje->delete();
        return redirect("contact_us")->with('status','Mensaje eliminado con éxito');
    }
}

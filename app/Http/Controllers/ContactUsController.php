<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\EmailSpam;
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
        if ($request->input('text') == '') {
            $contacts = ContactUs::get();
            return response()->json($contacts);
        }
        try {
            $request->validate([
                'text' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Valor no valido o en 0'], 422);
        }
        $text = $request->input('text');
        $contacts = ContactUs::where('email', 'LIKE', "%$text%")->orWhere('subject', 'LIKE', "%$text%")->orWhere('name', 'LIKE', "%$text%")->get();
        if ($contacts->isEmpty()) {
            return response()->json([]);
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
        $is_spam = EmailSpam::where('email', $request->input('email'))->first();
        if (!$is_spam) {
            ContactUs::create($request->all());
        }
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

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        $spam = ContactUs::whereIn('id', $ids)->pluck('email');
        // Crear un array de datos a insertar
        $data = $spam->map(function ($email) {
            return ['email' => $email, 'created_at' => now(), 'updated_at' => now()];
        })->toArray();

        // Insertar los datos en la tabla email_spam
        EmailSpam::insert($data);
        // Eliminar lo mensajes
        ContactUs::whereIn('id', $ids)->delete();
        return response()->json(['success' => 'Mensajes eliminados correctamente']);
    }
}

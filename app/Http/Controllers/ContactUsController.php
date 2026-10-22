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
        $data = $request->validate(['text' => 'nullable|string|max:255']);
        $text = $data['text'] ?? '';
        if ($text === '') {
            return response()->json(ContactUs::get());
        }
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);
        $is_spam = EmailSpam::where('email', $request->input('email'))->first();
        if (!$is_spam) {
            ContactUs::create($data);
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
        $data = $request->validate([
            'ids' => 'required|array|min:1|max:500',
            'ids.*' => 'required|integer|min:1|distinct',
        ]);
        $ids = $data['ids'];
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

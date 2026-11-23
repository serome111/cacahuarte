<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\EmailSpam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contact = $this->filteredMessages($request)->withQueryString();

        return view('admin.contact_us.contact_us', [
            'global_phone' => config('site.phone'),
            'contact' => $contact,
            'cantidad' => $contact->total(),
        ]);
    }

    public function filter(Request $request)
    {
        return response()->json($this->filteredMessages($request));
    }

    private function filteredMessages(Request $request)
    {
        $data = $request->validate(['text' => 'nullable|string|max:255']);

        return $this->messageQuery($data['text'] ?? null)
            ->latest('updated_at')
            ->orderByDesc('id')
            ->paginate(20);
    }

    private function messageQuery(?string $search)
    {
        return ContactUs::query()
            ->when($search !== null, function ($query) use ($search) {
                $text = '%'.$search.'%';
                $query->where(fn ($query) => $query->where('email', 'like', $text)
                    ->orWhere('subject', 'like', $text)
                    ->orWhere('name', 'like', $text));
            });
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
            'ids' => 'required_without:text|prohibits:text|array|min:1|max:500',
            'text' => 'required_without:ids|string|max:255',
            'ids.*' => 'required|integer|min:1|distinct',
        ]);
        DB::transaction(function () use ($data) {
            $query = isset($data['ids'])
                ? ContactUs::whereIn('id', $data['ids'])
                : $this->messageQuery($data['text'])->limit(501);
            $messages = $query->orderBy('id')->lockForUpdate()->get(['id', 'email']);

            if ($messages->count() > 500) {
                throw ValidationException::withMessages(['text' => 'Limita la búsqueda a 500 mensajes o menos.']);
            }

            foreach ($messages->pluck('email')->unique() as $email) {
                EmailSpam::firstOrCreate(['email' => $email]);
            }

            ContactUs::whereIn('id', $messages->modelKeys())->delete();
        });

        return response()->json(['success' => 'Mensajes eliminados correctamente']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\bulletingRequest;
use App\Models\bulleting;

class bulletingController extends Controller
{
    public function store(bulletingRequest $request)
    {
        $subscription = bulleting::firstOrCreate($request->validated());
        $response = redirect()->route('index');

        return $subscription->wasRecentlyCreated
            ? $response->with('status', 'Suscrito exitosamente')
            : $response;
    }
}

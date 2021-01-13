<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\WhyAboutUsController;
use App\Http\Controllers\bannerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/','App\Http\Controllers\IndexController');
Route::get('/base', function () {
    return view('admin/dashboard');
})->name('dashboard');

// Route::get('/banner','App\Http\Controllers\bannerController@index')->name('banner');
Route::resource('banner', bannerController::class);
Route::resource('about_as',AboutUsController::class);

//tarjetas why-about-us
Route::resource('why-about-us', WhyAboutUsController::class);
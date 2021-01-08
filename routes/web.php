<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bannerController;
use App\Http\Controllers\WhyAboutUsController;

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

//tarjetas why-about-us
Route::resource('why-about-us', WhyAboutUsController::class);
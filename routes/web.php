<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ValuesController;
use App\Http\Controllers\WhyAboutUsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\bannerController;
use App\Http\Controllers\TeamController;
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

Route::resource('/','App\Http\Controllers\IndexController', ['only' => ['index']]);
Route::get('/base', function () {
    return view('admin/dashboard');
})->name('dashboard');


// Route::get('/banner','App\Http\Controllers\bannerController@index')->name('banner');
Route::resource('banner', bannerController::class,['except' => ['show']]);
Route::resource('about_us',AboutUsController::class,['except' => ['show']]);
Route::resource('values',ValuesController::class,['except' => ['show']]);

//productos
Route::resource('categories',CategoriesController::class,['except' => ['show']]);

//tarjetas why-about-us
Route::resource('why-about-us', WhyAboutUsController::class,['only' => ['index', 'edit', 'update']]);

//clients
Route::resource('clients', ClientsController::class)->except(['show']);

// Team
Route::resource('team', TeamController::class)->except(['show']);

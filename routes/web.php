<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValuesController;
use App\Http\Controllers\WhyAboutUsController;
use App\Http\Controllers\bannerController;
use App\Http\Controllers\bulleting;
use App\Http\Controllers\bulletingController;
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
})->name('dashboard')->middleware('auth');

Route::get('/qr', function () {
    return header('Location: '.'https://drive.google.com/file/d/1O5CQeHiII_opGDC4R1X_mWLKGOUJftYY/view?usp=sharing');
});

Route::get('/mision', function () {
    return view('public/blog/mision');
})->name('mision');

Route::get('/vision', function () {
    return view('public/blog/vision');
})->name('vision');
Route::get('/reseña', function () {
    return view('public/blog/reseña');
})->name('reseña');
Route::get('/objetivos', function () {
    return view('public/blog/objetivos');
})->name('objetivos');
Route::get('/metas', function () {
    return view('public/blog/metas');
})->name('metas');
Route::get('/valores', function () {
    return view('public/blog/valores');
})->name('valores');

#voleting
Route::post('bulleting',[bulletingController::class, 'store'])->name('bulleting');

// Route::get('/banner','App\Http\Controllers\bannerController@index')->name('banner');
Route::resource('banner', bannerController::class,['except' => ['show']])->middleware('auth');
Route::resource('about_us',AboutUsController::class,['except' => ['show']])->middleware('auth');
Route::resource('values',ValuesController::class,['except' => ['show','destroy','store','create']])->middleware('auth');

//Categorias
Route::resource('categories',CategoriesController::class)->middleware('auth');
//Productos
Route::resource('products',ProductsController::class);
Route::post('/products/filter','App\Http\Controllers\ProductsController@filter')->name('filter');
Route::get('/detalles/{product}','App\Http\Controllers\ProductsController@detail')->name('detail');
//tarjetas why-about-us
Route::resource('why-about-us', WhyAboutUsController::class,['only' => ['index', 'edit', 'update']])->middleware('auth');

//clients
Route::resource('clients', ClientsController::class)->except(['show'])->middleware('auth');
//F.A.Q
Route::resource('faq', FaqController::class)->except(['show'])->middleware('auth');
// Team
Route::resource('team', TeamController::class)->except(['show'])->middleware('auth');
// Contact us
Route::resource('contact_us', ContactUsController::class)->only(['index','destroy'])->middleware('auth');

Route::resource('contact_us', ContactUsController::class)->only(['store']);


Route::resource('users', UserController::class)->only(['index','store','destroy'])->middleware('auth');

Auth::routes(['register' => true]);



<?php

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

Route::get('/', function () {
    return view('customers.index');
});

Route::get('/main', function () {
    // VALIDAR LOGIN
    return view('main');
});

Route::get('/faq', function () {
    return view('customers.faq');
});

Route::get('/catalogo', function () {
    return view('customers.catalogo');
});

Route::get('/about', function () {
    return view('customers.about');
});

Route::get('/sucursales', function () {
    return view('customers.sucursales');
});




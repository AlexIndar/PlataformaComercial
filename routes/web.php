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





// COMMON -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

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

Route::get('/postventa', function () {
    return view('customers.postventa');
});

Route::get('/contacto', function () {
    return view('customers.contacto');
});


// CUSTOMERS -------------------------------------------------------------------------------------------------------------------------------------------------------------------------






// INTRANET --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::get('/Intranet', function(){
    return view('intranet.main');
});

Route::get('/MisSolicitudes', function(){
    return view('intranet.ventas.misSolicitudes');
});

Route::get('/SolicitudesPendientes', function(){
    return view('intranet.cyc.solicitudesPendientes');
});


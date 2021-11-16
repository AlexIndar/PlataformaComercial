<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Customer\ItemsController;
use App\Http\Middleware\ValidateSession;
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
    $token = Config::get('token');
    return view('customers.index', ['token' => $token]);
})->name('/');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/main', function () {
    // VALIDAR LOGIN
    $token = Config::get('token');
    return view('main', ['token' => $token]);
});

Route::get('/faq', function () {
     $token = Config::get('token');
    return view('customers.faq', ['token' => $token]);
});

Route::get('/catalogo', function () {
     $token = Config::get('token');
    return view('customers.catalogo', ['token' => $token]);
});

Route::get('/about', function () {
     $token = Config::get('token');
    return view('customers.about', ['token' => $token]);
});

Route::get('/sucursales', function () {
     $token = Config::get('token');
    return view('customers.sucursales', ['token' => $token]);
});

Route::get('/postventa', function () {
     $token = Config::get('token');
    return view('customers.postventa', ['token' => $token]);
});

Route::get('/contacto', function () {
     $token = Config::get('token');
    return view('customers.contacto', ['token' => $token]);
});

Route::get('/descontinuados', function () {
     $token = Config::get('token');
    return view('customers.descontinuados', ['token' => $token]);
});


Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/detallesProducto/{id}', [ItemsController::class, 'getProduct']);


Route::middleware([ValidateSession::class])->group(function(){ // COMMON -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

   
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


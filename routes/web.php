<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Customer\ItemsController;
use App\Http\Controllers\Customer\TokenController;
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
    $token = TokenController::getToken();
    if($token && $token != 'error'){
        $bestSellers = ItemsController::getBestSellers($token);
    }
    else{
        $bestSellers = ItemsController::getBestSellers("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VyTmFtZSI6ImFsZWphbmRyby5qaW1lbmV6IiwiUm9sZSI6IkFETUlOIiwianRpIjoiYTg5NmEzYTUtMDI3ZC00N2M5LWEwNWEtNmI1YTBmOGFhMGFjIiwiZXhwIjoxOTUyOTA5NjY4LCJpc3MiOiJodHRwczovL2xvY2FsaG9zdDo0NDMzNi8iLCJhdWQiOiJodHRwczovL2xvY2FsaG9zdDo0NDMzNi8ifQ.aqSmiV9BjVZAPl7QYLYihLuI_unW0DTT3ucTE5DBwfM");
    }
    // dd($bestSellers);
    return view('customers.index', ['token' => $token, 'bestSellers' => $bestSellers]);

})->name('/');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/main', function () {
    // VALIDAR LOGIN
    $token = TokenController::getToken();
    return view('main', ['token' => $token]);
});

Route::get('/faq', function () {
    $token = TokenController::getToken();
    return view('customers.faq', ['token' => $token]);
});



Route::get('/about', function () {
    $token = TokenController::getToken();
    return view('customers.about', ['token' => $token]);
});

Route::get('/centros', function () {
    $token = TokenController::getToken();
    return view('customers.centros', ['token' => $token]);
});

Route::get('/postventa', function () {
    $token = TokenController::getToken();
    return view('customers.postventa', ['token' => $token]);
});

Route::get('/contacto', function () {
    $token = TokenController::getToken();
    return view('customers.contacto', ['token' => $token]);
});

Route::get('/descontinuados', function () {
    $token = TokenController::getToken();
    return view('customers.descontinuados', ['token' => $token]);
});


Route::get('/logout', [LoginController::class, 'logout']);


//---------------------------------------------------------------------------------------------------------------- PROTECTED VIEWS - ONLY CUSTOMERS -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware([ValidateSession::class])->group(function(){ 
    
    Route::get('/catalogo', function () {
        $token = TokenController::getToken();
        return view('customers.catalogo', ['token' => $token]);
    });


    Route::get('/detallesProducto/{id}',function ($id) {
        $token = TokenController::getToken();
        $item = ItemsController::getProduct($id, $token);
    });


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


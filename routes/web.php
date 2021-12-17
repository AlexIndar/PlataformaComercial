<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Customer\ItemsController;
use App\Http\Controllers\Customer\RamasController;
use App\Http\Controllers\Customer\TokenController;
use App\Http\Controllers\Customer\InvoicesController;
use App\Http\Controllers\Customer\SaleOrdersController;
use App\Http\Middleware\ValidateSession;
use Illuminate\Http\Request;

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

    $rama1 = RamasController::getRama1(); 
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();


    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.index', ['token' => $token, 'bestSellers' => $bestSellers, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);

})->name('/');


Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/main', function () {
    // VALIDAR LOGIN
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    return view('main', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3]);
});

Route::get('/faq', function () {
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.faq', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/downloadInvoice', function () {
    $data = [
        'customer' => 'Grupo Ferretero de Alba',
        'total' => 168.99
    ];

    $pdf = PDF::loadView('customers.invoice', $data);

    return $pdf->stream('invoice.pdf'); 
});

Route::get('/bladeInvoice', function () {
    $customer = "Grupo Ferretero de Alba";
    $total = 168.99;
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.invoice', ['customer' => $customer, 'total' => $total, 'level' => $level]);
});


Route::get('/about', function () {
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.about', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/centros', function () {
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.centros', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/postventa', function () {
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.postventa', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/contacto', function () {
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.contacto', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/descontinuados', function () {
    $token = TokenController::getToken();
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE["level"])){
        $level = $_COOKIE["level"];
    }
    
    return view('customers.descontinuados', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});


Route::get('/logout', [LoginController::class, 'logout']);


//---------------------------------------------------------------------------------------------------------------- PROTECTED VIEWS - ONLY CUSTOMERS -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware([ValidateSession::class])->group(function(){ 


                // GENERAL ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
                                Route::get('/catalogo', function () {
                                    $token = TokenController::getToken();
                                    $rama1 = RamasController::getRama1();
                                    $rama2 = RamasController::getRama2();
                                    $rama3 = RamasController::getRama3();
                                    $level = "C";
                                    if(isset($_COOKIE["level"])){

                                    $level = $_COOKIE["level"];     }
                                    
                                    return view('customers.catalogo', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
                                });


                                Route::get('/detallesProducto/{id}',function ($id) {
                                    $token = TokenController::getToken();
                                    $rama1 = RamasController::getRama1();
                                    $rama2 = RamasController::getRama2();
                                    $rama3 = RamasController::getRama3();
                                    $item = ItemsController::getProduct($id, $token);
                                });


            
                // PEDIDOS --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


                            Route::get('/pedidosAnteriores/{customer}', function ($customer){
                                $token = TokenController::getToken();
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                $saleOrders = SaleOrdersController::getSaleOrders($token, $customer);
                                return view('customers.pedidos.pedidosAnteriores', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'saleOrders' => $saleOrders, 'customer' => $customer]);
                            });
                            
                            Route::get('pedidosAnteriores/getSaleOrders/{customer}', function ($customer){
                                $token = TokenController::getToken();
                                $saleOrders = SaleOrdersController::getSaleOrders($token, $customer);
                                
                                return $saleOrders;
                            });

                            Route::get('pedido/nuevo/{entity}', function ($entity){
                                $token = TokenController::getToken();
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = $entity[0];
                                $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                                return view('customers.pedidos.addPedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'entity' => $entity, 'level' => $level, 'data' => $data]);

                            });

                            Route::get('pedido/nuevo/getInfoHeatWeb/{customer}', function ($customer){
                                $token = TokenController::getToken();
                                $entity = $customer;
                                $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                                return  $data;
                            });

                            Route::post('pedido/nuevo/getItems/all', function (Request $request){
                                $token = TokenController::getToken();
                                $entity = $request->entity;
                                $data = SaleOrdersController::getItems($token, $entity);
                                return  $data;
                            });

                            Route::post('pedido/nuevo/getItemByID', function (Request $request){
                                $token = TokenController::getToken();
                                $id = (string)$request->id;
                                $entity = (string)$request->entity;
                                $data = SaleOrdersController::getItemByID($token, $id, $entity);
                                return  $data;
                            });

                // PROMOCIONES ------------------------------------------------------------------------------------------------------------------------------------------------


                Route::get('/promociones', function (){
                    $token = TokenController::getToken();
                    $rama1 = RamasController::getRama1();
                    $rama2 = RamasController::getRama2();
                    $rama3 = RamasController::getRama3();
                    $level = "C";
                    if(isset($_COOKIE["level"])){
                        $level = $_COOKIE["level"];
                    } 
                    return view('customers.promociones.promociones', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
                });

                Route::get('/promociones/nueva', function (){
                    $token = TokenController::getToken();
                    $rama1 = RamasController::getRama1();
                    $rama2 = RamasController::getRama2();
                    $rama3 = RamasController::getRama3();
                    $level = "C";
                    if(isset($_COOKIE["level"])){
                        $level = $_COOKIE["level"];
                    }
                    return view('customers.promociones.addPromocion', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
                });


                // INTRANET ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                                Route::get('/Intranet', function(){
                                    return view('intranet.main');
                                });

                                Route::get('/MisSolicitudes', function(){
                                    return view('intranet.ventas.misSolicitudes');
                                });

                                Route::get('/SolicitudesPendientes', function(){
                                    return view('intranet.cyc.solicitudesPendientes');
                                });


    
});





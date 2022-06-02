<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\LoginController;
// CUSTOMERS -------------------------------------------------------------------------------
use App\Http\Controllers\Customer\ItemsController;
use App\Http\Controllers\Customer\RamasController;
use App\Http\Controllers\Customer\TokenController;
use App\Http\Controllers\Customer\InvoicesController;
use App\Http\Controllers\Customer\SaleOrdersController;
use App\Http\Controllers\Customer\PromoController;
use App\Http\Controllers\Customer\CotizacionController;
use App\Http\Controllers\Logistica\LogisticaController;
use App\Mail\ConfirmarPedido;
use App\Mail\ConfirmarPedidoDesneg;
use App\Mail\ErrorNetsuite;
use Barryvdh\DomPDF\Facade as PDF;
// -----------------------------------------------------------------------------------------

// INTRANET --------------------------------------------------------------------------------

use App\Http\Controllers\Intranet\MisSolicitudesController;
use App\Http\Controllers\Intranet\EstadisticasClientesController;

// ------------------------------------------------------------------------------------------

//SAI----------------------------------------------------------------
use App\Http\Controllers\Sai\AplicarPagoController;

//COMISIONES----------------------------------------------------------------
use App\Http\Controllers\Comisiones\ComisionesController;

//-------------------------------------------------------------------
use App\Http\Middleware\ValidateSession;
use Illuminate\Http\Request;
use App\Exports\TemplateCategories;
use App\Exports\TemplateGiros;
use App\Exports\TemplateClientes;
use App\Exports\TemplateClientesCuotas;
use App\Exports\TemplateMarcas;
use App\Exports\TemplateProveedores;
use App\Exports\TemplateArticulos;
use App\Exports\TemplatePedido;
use App\Http\Controllers\Clientes\ClientesController;
use App\Http\Controllers\Intranet\SolicitudesPendientesController;
use App\Mail\SolicitudClienteMail;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Constraint\Count;

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
    if($token && $token != 'error' && $token != 'expired'){
        $bestSellers = ItemsController::getBestSellers($token);
    }
    else{
        $bestSellers = ItemsController::getBestSellers("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJVc2VyTmFtZSI6ImFsZWphbmRyby5qaW1lbmV6IiwiUm9sZSI6IkFETUlOIiwianRpIjoiYTg5NmEzYTUtMDI3ZC00N2M5LWEwNWEtNmI1YTBmOGFhMGFjIiwiZXhwIjoxOTUyOTA5NjY4LCJpc3MiOiJodHRwczovL2xvY2FsaG9zdDo0NDMzNi8iLCJhdWQiOiJodHRwczovL2xvY2FsaG9zdDo0NDMzNi8ifQ.aqSmiV9BjVZAPl7QYLYihLuI_unW0DTT3ucTE5DBwfM");
    }

    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.index', ['token' => $token, 'bestSellers' => $bestSellers, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);

})->name('/');


Route::get('/login', [LoginController::class, 'authenticate']);

Route::get('/main', function () {
    // VALIDAR LOGIN
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    return view('main', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3]);
});

Route::get('/faq', function () {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
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
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.invoice', ['customer' => $customer, 'total' => $total, 'level' => $level]);
});


Route::get('/about', function () {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.about', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/centros', function () {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.centros', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/postventa', function () {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.postventa', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/contacto', function () {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.contacto', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});

Route::get('/descontinuados', function () {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    return view('customers.descontinuados', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
});


Route::get('/logout', [LoginController::class, 'logout']);

//---------------------------------------------------------------------------------------------------------------- PROTECTED VIEWS - ONLY CUSTOMERS -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::middleware([ValidateSession::class])->group(function(){

    // ALEJANDRO JIMÉNEZ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                // GENERAL ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                                Route::get('/catalogo', function () {
                                    $token = TokenController::getToken();
                                    if($token == 'error'){
                                        return redirect('/logout');
                                    }
                                    $rama1 = RamasController::getRama1();
                                    $rama2 = RamasController::getRama2();
                                    $rama3 = RamasController::getRama3();
                                    $level = "C";
                                    if(isset($_COOKIE['_lv'])){
                                        $level = $_COOKIE['_lv'];
                                    }
                                    return view('customers.catalogo', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
                                });

                                Route::get('/detallesProducto',function () {
                                    $token = TokenController::getToken();
                                    if($token == 'error'){
                                        return redirect('/logout');
                                    }
                                    $rama1 = RamasController::getRama1();
                                    $rama2 = RamasController::getRama2();
                                    $rama3 = RamasController::getRama3();
                                    $level = "C";
                                    if(isset($_COOKIE['_lv'])){
                                        $level = $_COOKIE['_lv'];
                                    }
                                    return view('customers.detallesProducto', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
                                });

                // PEDIDOS --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                            Route::get('/pedidos', function (){
                                $token = TokenController::getToken();
                                if($token == 'error' || $token == 'expired'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $directores = ['rvelasco', 'alejandro.jimenez'];
                                in_array($username, $directores) ? $entity = 'ALL' : $entity = $username;
                                if($userRol == "VENDEDOR" || $userRol == "VENDEDOR TEL"){
                                    $zone = MisSolicitudesController::getZone($token, $username);
                                    if($zone->getStatusCode()== 400){
                                        return redirect('/Intranet');
                                    }
                                    else{
                                        $entity = json_decode($zone->body())->description;
                                    }

                                }
                                if($userRol == "APOYOVENTA"){
                                    $entity = 'ALL';
                                }
                                $permissions = LoginController::getPermissions($token);
                                return view('customers.pedidos.pedidos', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'permissions' => $permissions, 'username' => $username, 'userRol' => $userRol, 'entity' => $entity]);
                            });

                            Route::get('/getPedidos', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $entity = '';
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $directores = ['rvelasco', 'alejandro.jimenez'];
                                in_array($username, $directores) ? $entity = 'ALL' : $entity = $username;
                                $entity == 'ALL' ? $pedidos = CotizacionController::getCotizaciones($token, $entity) : $pedidos = CotizacionController::getCotizacionesByUser($token, $entity);
                                return $pedidos;
                            });

                            Route::get('/getZonasApoyo', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $zonas = CotizacionController::getZonasApoyo($token, $username);
                                return $zonas;
                            });

                            Route::get('/getCotizacionesZonas', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $cotizaciones = CotizacionController::getCotizaciones($token, $entity);
                                return $cotizaciones;
                            });

                            Route::get('/pedidosAnteriores/{customer}', function ($customer){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                $saleOrders = SaleOrdersController::getSaleOrders($token, $customer);
                                return view('customers.pedidos.pedidosAnteriores', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'saleOrders' => $saleOrders, 'customer' => $customer]);
                            });

                            Route::get('pedidosAnteriores/getSaleOrders/{customer}', function ($customer){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $saleOrders = SaleOrdersController::getSaleOrders($token, $customer);
                                return $saleOrders;
                            });

                            // Route::get('/pedido/nuevo/{entity}', function ($entity){
                            //     $token = TokenController::getToken();
                            //     if($token == 'error'){
                            //         return redirect('/logout');
                            //     }
                            //     $rama1 = RamasController::getRama1();
                            //     $rama2 = RamasController::getRama2();
                            //     $rama3 = RamasController::getRama3();
                            //     $level = $entity[0];
                            //     if($level == 'A'){ $level = "E"; } // si entity inicia con A = All es apoyo de ventas = empleado = E
                            //     if(str_starts_with($entity, 'Z1')){
                            //         $entity = 'ALL';
                            //     }
                            //     $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                            //     // dd($data);
                            //     return view('customers.pedidos.addPedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'entity' => $entity, 'level' => $level, 'data' => $data]);

                            // });

                            Route::post('/pedido/nuevo', function (Request $request){
                                ini_set('memory_limit', '-1');
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $entity = $request->entity;
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $directores = ['rvelasco', 'alejandro.jimenez'];
                                $zonaInfo = MisSolicitudesController::getZone($token,$username);
                                if(isset(json_decode($zonaInfo->body())->status) || $userRol == 'APOYOVENTA' || in_array($username, $directores) ){
                                    $entity = 'ALL';
                                    $zona = 'ALL';
                                }
                                else{
                                    $entity = json_decode($zonaInfo->body())->description;
                                    $zona = json_decode($zonaInfo->body())->description;
                                }
                                $level = $entity[0];
                                if($level == 'A'){ $level = "E"; } // si entity inicia con A = All es apoyo de ventas = empleado = E
                                if(str_starts_with($entity, 'Z1')){
                                    $entity = 'ALL';
                                    $zona = 'ALL';
                                }
                                $data = SaleOrdersController::getInfoHeatWeb($token, $zona);
                                return view('customers.pedidos.addPedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'entity' => $entity, 'level' => $level, 'data' => $data, 'username' => $username, 'userRol' => $userRol]);
                            });

                            Route::post('/pedido/eliminar', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $response = CotizacionController::deletePedido($token, $request->idCotizacion);
                                return redirect('/pedidos');
                            });

                            Route::post('/pedido/editar', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $entity = $request->companyId;
                                $level = $entity[0];
                                if($level == 'A'){ $level = "E"; } // si entity inicia con A = All es apoyo de ventas = empleado = E
                                if(str_starts_with($entity, 'Z1')){
                                    $entity = 'ALL';
                                }
                                $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                                $cotizacion = CotizacionController::getCotizacionIdWeb($token, $request->id);
                                return view('customers.pedidos.updatePedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'entity' => $entity, 'level' => $level, 'cotizacion' => $cotizacion, 'data' => $data]);
                            });

                            Route::get('pedido/getCotizacionIdWeb/{id}', function ($id){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $cotizacion = CotizacionController::getCotizacionIdWeb($token, $id);
                                return $cotizacion;
                            });

                            Route::post('/pedido/storePedido', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $response = CotizacionController::storePedido($token, json_encode($request->all()), $username);
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                return $response;
                            });

                            Route::post('/pedido/storePedidoGetID', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $response = CotizacionController::storePedido($token, json_encode($request->all()), $username);
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                return $response;
                            });

                            Route::post('/pedido/updatePedido', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $response = CotizacionController::storePedido($token, json_encode($request->all()), $username);
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                return $response;
                            });

                            Route::post('/pedido/storePedidoNS', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $json = $request->json; //json para guardar pedido en netsuite
                                $response = SaleOrdersController::storePedidoNS($token, $json, $username);
                                return $response;
                            });

                            Route::get('pedido/nuevo/getInfoHeatWeb/{customer}', function ($customer){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $entity = $customer;
                                $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                                return  $data;
                            });

                            Route::post('/pedido/nuevo/getItems/all', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $entity = $request->entity;
                                $data = SaleOrdersController::getItems($token, $entity);
                                return  $data;
                            });

                            Route::post('/pedido/getEventosCliente', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $entity = $request->entity;
                                $data = SaleOrdersController::getEventosCliente($token, $entity);
                                return  $data;
                            });

                            Route::get('/pedido/getformaEnvioFletera', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $data = SaleOrdersController::getformaEnvioFletera($token);
                                return  $data;
                            });

                            Route::post('/pedido/nuevo/getItemByID', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $id = (string)$request->id;
                                $entity = (string)$request->entity;
                                $data = SaleOrdersController::getItemByID($token, $id, $entity);
                                return  $data;
                            });

                            Route::post('/pedido/nuevo/SepararPedidosPromo', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $json = $request->key;
                                $data = SaleOrdersController::separarPedidosPromo($token, $json);
                                return  $data;
                            });

                            Route::post('/pedido/nuevo/SepararPedidosPaquete', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $json = $request->key;
                                $data = SaleOrdersController::separarPedidosPaquete($token, $json);
                                return  $data;
                            });

                            Route::get('/getPedidosPendientesCTE', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $data = SaleOrdersController::getPedidosPendientesCTE($token);
                                return  $data;
                            });

                            Route::post('/pedidosAnteriores/RegresaEstadoPedido', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $data = SaleOrdersController::regresaEstadoPedido($token, $request->id);
                                return  $data;
                            });

                            Route::post('/pedidosAnteriores/getDetalleFacturado', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $data = SaleOrdersController::getDetalleFacturado($token, $request->id);
                                return  $data;
                            });

                            Route::get('/downloadTemplatePedido', function (){
                                return Excel::download(new TemplatePedido,'Pedido.xlsx');
                            });

                            Route::post('/sendmail', function (Request $request) {
                                ini_set('max_input_vars','100000' );
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $pedido = $request->pedido;
                                $idCotizacion = $request->idCotizacion;
                                $correo = $request->email;
                                $ordenCompra = $request->ordenCompra;
                                $cliente = $request->cliente;
                                $comentarios = $request->comentarios;
                                $formaEnvio = $request->formaEnvio;
                                $fletera = $request->fletera;
                                $tranIds = $request->tranIds;
                                $idCotizacion == 0 ? $asunto = "Nueva Cotización INDAR" : $asunto = "Nuevo Pedido INDAR";
                                $detallesPedido = [
                                    "subtotal" => 0,
                                    "iva" => 0,
                                    "total" => 0,
                                ];

                                for($x = 0; $x < count($pedido); $x++){
                                    $subtotal = 0;
                                    for($y = 0; $y < count($pedido[$x]['items']); $y++){
                                        $precioUnitario = round(((100 - $pedido[$x]['items'][$y]['promo']) * $pedido[$x]['items'][$y]['price']) / 100, 2);
                                        $importe = (round(((100 - $pedido[$x]['items'][$y]['promo']) * $pedido[$x]['items'][$y]['price']) / 100, 2)) * $pedido[$x]['items'][$y]['cantidad'];
                                        $subtotal = $subtotal + $importe;
                                        $precioUnitario = number_format($precioUnitario, 2, '.', ',');
                                        $importe = number_format($importe, 2, '.', ',');
                                        $pedido[$x]['items'][$y]['precioUnitario'] = $precioUnitario;
                                        $pedido[$x]['items'][$y]['importe'] = $importe;
                                    }
                                    $detallesPedido['subtotal'] = $detallesPedido['subtotal'] + $subtotal;
                                    $subtotal = number_format($subtotal, 2, '.', ',');
                                    $pedido[$x]['subtotal'] = $subtotal;
                                }
                                $detallesPedido['iva'] = $detallesPedido['subtotal'] * 0.16;
                                $detallesPedido['total'] = $detallesPedido['subtotal'] + $detallesPedido['iva'];
                                $detallesPedido['subtotal'] = number_format($detallesPedido['subtotal'], 2, '.', ',');
                                $detallesPedido['iva'] = number_format($detallesPedido['iva'], 2, '.', ',');
                                $detallesPedido['total'] = number_format($detallesPedido['total'], 2, '.', ',');

                                $emails = [];
                                $correoUsuarioLevanta = $username."@indar.com.mx";
                                $codCliente = substr((explode("]", $cliente)[0]), 1);
                                $listaCorreos = SaleOrdersController::getListaEmailPedido($token, $codCliente);
                                $fullName = LoginController::getFullName();
                                if($fullName == null) { $fullName = 'JIMÉNEZ MORENO RAMÓN ALEJANDRO';}
                                if( $listaCorreos->vendedor != "") array_push($emails, $listaCorreos->vendedor);
                                if( $listaCorreos->apoyo != "") array_push($emails, $listaCorreos->apoyo);
                                if( $listaCorreos->cliente != "") array_push($emails, $listaCorreos->cliente);
                                if( $listaCorreos->gerente != "") array_push($emails, $listaCorreos->gerente);
                                if( $correo != "" && $correo != $listaCorreos->cliente ) array_push($emails, $correo);
                                if( $correoUsuarioLevanta != $listaCorreos->vendedor && $correoUsuarioLevanta != $listaCorreos->apoyo && $correoUsuarioLevanta != $listaCorreos->gerente && $correoUsuarioLevanta != $listaCorreos->cliente && $correoUsuarioLevanta != $correo ) array_push($emails, $correoUsuarioLevanta);
                                if($correoUsuarioLevanta == 'alejandro.jimenez@indar.com.mx'){
                                    $emailsTest = ["alejandro.jimenez@indar.com.mx", "ing.alejandrodv@gmail.com"];
                                    Mail::to($emailsTest)->send(new ConfirmarPedido($pedido, $detallesPedido, $idCotizacion, $cliente, $comentarios, $ordenCompra, $formaEnvio, $fletera, $asunto, $tranIds, $fullName));
                                }
                                else{
                                    Mail::to($emails)->send(new ConfirmarPedido($pedido, $detallesPedido, $idCotizacion, $cliente, $comentarios, $ordenCompra, $formaEnvio, $fletera, $asunto, $tranIds, $fullName));
                                }
                                 // check for failures
                                if (Mail::failures()) {
                                    return response()->json(['error' => 'Error al enviar cotización'], 404);
                                }
                                else{
                                    if($idCotizacion == 0)
                                        return response()->json(['success' => 'Cotización enviada correctamente'], 200);
                                    else
                                        return response()->json(['success' => 'Pedido enviado por correo correctamente'], 200);
                                }
                             });

                             Route::post('/sendmailErrorNS', function (Request $request) {
                                ini_set('max_input_vars','100000' );
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $responseNS = $request->responseNS;
                                $correo = $request->email;
                                $emails = ['alejandro.jimenez@indar.com.mx', 'rvelasco@indar.com.mx'];
                                Mail::to($emails)->send(new ErrorNetsuite($responseNS));
                                if (Mail::failures()) {
                                    return response()->json(['error' => 'Se detectaron errores al enviar pedidos. No pudimos notificar al equipo de soporte para forzar los pedidos con error.'], 404);
                                }
                                else{
                                    return response()->json(['success' => 'Se detectaron errores al enviar pedidos. Hemos notificado al equipo de soporte para forzar los pedidos con error.'], 200);
                                }
                             });

                             Route::post('/sendmailDesneg', function (Request $request) {
                                ini_set('max_input_vars','100000' );
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $pedido = $request->pedido;
                                $idCotizacion = $request->idCotizacion;
                                $correo = $request->email;
                                $ordenCompra = $request->ordenCompra;
                                $cliente = $request->cliente;
                                $comentarios = $request->comentarios;
                                $formaEnvio = $request->formaEnvio;
                                $fletera = $request->fletera;
                                $autoriza = $request->autoriza;
                                $descuento = $request->descuento;
                                $tipoDescuento = $request->tipoDescuento;
                                $indexPedido = $request->indexPedido;
                                $fecha = $request->fecha;
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $asunto = "Nuevo pedido con ".$tipoDescuento;
                                $detallesPedido = [
                                    "subtotal" => 0,
                                    "iva" => 0,
                                    "total" => 0,
                                ];
                                $pedidoDesneg = [];
                                array_push($pedidoDesneg, $pedido[$indexPedido]);

                                for($x = 0; $x < count($pedidoDesneg); $x++){
                                    $subtotal = 0;
                                    for($y = 0; $y < count($pedidoDesneg[$x]['items']); $y++){
                                        $precioUnitario = round(((100 - $pedidoDesneg[$x]['items'][$y]['promo']) * $pedidoDesneg[$x]['items'][$y]['price']) / 100, 2);
                                        $importe = (round(((100 - $pedidoDesneg[$x]['items'][$y]['promo']) * $pedidoDesneg[$x]['items'][$y]['price']) / 100, 2)) * $pedidoDesneg[$x]['items'][$y]['cantidad'];
                                        $subtotal = $subtotal + $importe;
                                        $precioUnitario = number_format($precioUnitario, 2, '.', ',');
                                        $importe = number_format($importe, 2, '.', ',');
                                        $pedidoDesneg[$x]['items'][$y]['precioUnitario'] = $precioUnitario;
                                        $pedidoDesneg[$x]['items'][$y]['importe'] = $importe;
                                    }
                                    $detallesPedido['subtotal'] = $detallesPedido['subtotal'] + $subtotal;
                                    $subtotal = number_format($subtotal, 2, '.', ',');
                                    $pedidoDesneg[$x]['subtotal'] = $subtotal;
                                }
                                $detallesPedido['iva'] = $detallesPedido['subtotal'] * 0.16;
                                $detallesPedido['total'] = $detallesPedido['subtotal'] + $detallesPedido['iva'];
                                $detallesPedido['subtotal'] = number_format($detallesPedido['subtotal'], 2, '.', ',');
                                $detallesPedido['iva'] = number_format($detallesPedido['iva'], 2, '.', ',');
                                $detallesPedido['total'] = number_format($detallesPedido['total'], 2, '.', ',');

                                $emails = [];

                                if ($autoriza == 'JMGA') {array_push($emails, 'juanmgomez@indar.com.mx');}
                                if ($autoriza == 'EOEGA') {array_push($emails, 'eortiz@indar.com.mx');}
                                if ($autoriza == 'JSB') {array_push($emails, 'jsamaue@indar.com.mx');}

                                Mail::to($emails)->send(new ConfirmarPedidoDesneg($pedidoDesneg, $detallesPedido, $idCotizacion, $cliente, $comentarios, $ordenCompra, $formaEnvio, $fletera, $asunto, $autoriza, $tipoDescuento, $descuento, $username, $fecha));
                                 // check for failures
                                if (Mail::failures()) {
                                    return response()->json(['error' => 'Error al enviar correo desneg'], 404);
                                }
                                else{
                                    return response()->json(['success' => 'Correo enviado correctamente a '.$autoriza], 200);
                                }
                             });

                             Route::get('forzarPedido', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                $permissions = LoginController::getPermissions($token);
                                return view('customers.pedidos.forzarPedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'permissions' => $permissions]);
                            });

                            Route::post('/pedido/forzarPedido', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $idCotizacion = explode('-', $request->cotizacion);
                                $index = explode('/', $idCotizacion[1]);
                                $idCotizacion = $idCotizacion[0];
                                $cantidad = $index[1];
                                $index = $index[0];
                                $cotizacion = CotizacionController::getCotizacionIdWeb($token, $idCotizacion);
                                $response = SaleOrdersController::forzarPedido($token, $cotizacion, $idCotizacion, $index, $cantidad, $username);
                                return $response;
                            });

                // PROMOCIONES ------------------------------------------------------------------------------------------------------------------------------------------------

                            Route::get('/promociones', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();

                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }

                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;

                                $promociones = PromoController::getAllEvents($token);
                                $permissions = LoginController::getPermissions($token);
                                return view('customers.promociones.promociones', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'promociones' => $promociones, 'permissions' => $permissions, 'username' => $username, 'userRol' => $userRol]);
                            });

                            Route::post('/promociones/editar', function (Request $request){
                                $idPromo = $request->id;
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                $promocion = PromoController::getEventById($token, $idPromo);
                                $promocion = $promocion[0];
                                $datePromo = PromoController::formatDate($promocion);
                                $startTime = PromoController::getStartTime($promocion);
                                $endTime = PromoController::getEndTime($promocion);

                                $permissions = LoginController::getPermissions($token);

                                if($promocion->paquete){
                                    $cuotas = PromoController::getCuotasPersonalizadas($token, $idPromo);
                                    return view('customers.promociones.updatePaquete', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level,'permissions' => $permissions, 'promo' => $promocion, 'cuotas' => $cuotas, 'datePromo' => $datePromo, 'startTime' => $startTime, 'endTime' => $endTime]);
                                }
                                else{
                                    return view('customers.promociones.updatePromocion', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level,'permissions' => $permissions, 'promo' => $promocion, 'datePromo' => $datePromo, 'startTime' => $startTime, 'endTime' => $endTime]);

                                }
                            });

                            Route::post('/promociones/eliminar', function (Request $request){
                                $token = TokenController::getToken();

                                if($token == 'error'){
                                    return redirect('/logout');
                                }

                                $response = PromoController::deletePromo($token, $request->idPromo);

                                return redirect('/promociones');
                            });

                            Route::get('promociones/getEventById/{id}', function ($id){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $promo = PromoController::getEventById($token, $id);
                                return $promo[0];
                            });

                            Route::get('promociones/getCuotasPersonalizadas/{idPaquete}', function ($id){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $cuotas = PromoController::getCuotasPersonalizadas($token, $id);
                                return $cuotas;
                            });

                            Route::get('promociones/getReglasPaquete/{idPaquete}', function ($id){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $cuotas = PromoController::getReglasPaquete($token, $id);
                                return $cuotas;
                            });


                            Route::get('/promociones/nueva', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $permissions = LoginController::getPermissions($token);
                                return view('customers.promociones.addPromocion', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level,'permissions' => $permissions, 'username' => $username, 'userRol' => $userRol]);
                            });

                            Route::get('/promociones/paquete', function (){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                $userData = json_decode(MisSolicitudesController::getUserRol($token));
                                $username = $userData->typeUser;
                                $userRol = $userData->permissions;
                                $permissions = LoginController::getPermissions($token);
                                return view('customers.promociones.addPaquete', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level,'permissions' => $permissions, 'username' => $username, 'userRol' => $userRol]);
                            });

                            Route::get('promociones/getPromocionesInfo', function (){
                                $token = TokenController::getToken();
                                ini_set('max_execution_time', 300); //300 segundos = 5 minutos
                                $dataCustomers = PromoController::getCustomersInfo($token);
                                $customersInfo = $dataCustomers['customersInfo'];
                                $categories = $dataCustomers['categories'];
                                $giros = $dataCustomers['giros'];
                                $customers = $dataCustomers['customers'];
                                $dataArticulos = PromoController::getItems($token);
                                $infoArticulos = $dataArticulos['items'];
                                $proveedores = $dataArticulos['proveedores'];
                                $marcas = $dataArticulos['marcas'];
                                $articulos = $dataArticulos['articulos'];
                                $promociones = PromoController::getAllEvents($token);
                                $info = array($customersInfo, $categories, $giros, $customers, $infoArticulos, $proveedores, $marcas, $articulos, $promociones);
                                return $info;
                            });

                            Route::get('/downloadTemplateCategorias', function (){
                                return Excel::download(new TemplateCategories,'Categorias.xlsx');
                            });

                            Route::get('/downloadTemplateGiros', function (){
                                return Excel::download(new TemplateGiros,'Giros.xlsx');
                            });

                            Route::get('/downloadTemplateClientes', function (){
                                return Excel::download(new TemplateClientes,'Clientes.xlsx');
                            });

                            Route::get('/downloadTemplateClientesCuotas', function (){
                                return Excel::download(new TemplateClientesCuotas,'ClientesCuotas.xlsx');
                            });

                            Route::get('/downloadTemplateMarcas', function (){
                                return Excel::download(new TemplateMarcas,'Marcas.xlsx');
                            });

                            Route::get('/downloadTemplateProveedores', function (){
                                return Excel::download(new TemplateProveedores,'Proveedores.xlsx');
                            });

                            Route::get('/downloadTemplateArticulos', function (){
                                return Excel::download(new TemplateArticulos,'Articulos.xlsx');
                            });

                            Route::post('/promociones/storePromo', function (Request $request){
                                ini_set('max_input_vars','100000' );
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $response = PromoController::storePromo($token, json_encode($request->all()));
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE['_lv'])){
                                    $level = $_COOKIE['_lv'];
                                }
                                return $response;
                            });

// FIN ALEJANDRO JIMÉNEZ ----------------------------------------------------------------------------------------------------------------------------------------------------------

                /* ********************************************* INDARNET ************************************************ */

                 Route::get('/Intranet', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    $userData = json_decode(MisSolicitudesController::getUserRol($token));
                    $username = $userData->typeUser;
                    $userRol = $userData->permissions;
                    $directores = ['rvelasco', 'alejandro.jimenez'];
                    in_array($username, $directores) ? $entity = 'ALL' : $entity = $username;
                    return view('intranet.main', ['entity' => $entity, 'permissions' => $permissions,  'username' => $username, 'userRol' => $userRol]);
                });

                //////// MIS SOLICITUDES /////
                Route::get('/MisSolicitudes', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = MisSolicitudesController::getUser($token);
                    $zone = MisSolicitudesController::getZone($token,$user->body());
                    // dd($zone->body());
                    if($zone->getStatusCode()== 400){
                        // return redirect('/Intranet');
                        return redirect('/MisSolicitudesAdmin');
                    }
                    $listSol = MisSolicitudesController::getTableView($token, json_decode($zone->body()));
                    function getStatus($id){
                        return MisSolicitudesController::getStatus($id);
                    }
                    return view('intranet.ventas.misSolicitudes',['token' => $token, 'permissions' => $permissions, 'zone' => $zone, 'listSol' => $listSol]);
                    /*return view('intranet.ventas.misSolicitudes');*/
                });

                Route::post('/MisSolicitudes/storeSolicitud', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $response = MisSolicitudesController::storeSolicitud($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/MisSolicitudes/saveSolicitud', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $response = MisSolicitudesController::saveSolicitud($token, json_encode($request->all()));
                    return $response;
                });

                Route::get('/MisSolicitudes/getBusinessLines', function (){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $data = MisSolicitudesController::getBusinessLines($token);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getInfoSol', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getInfoSol($token, $fol);
                    return  $data;
                });

                Route::get('/MisSolicitudes/getCPData', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $cp = $request->cp;
                    $data = MisSolicitudesController::getCPData($token, $cp);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getTransactionHistory', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getTransactionHistory($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getValidacionContactos', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidacionContactos($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getValidationRequest', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidationRequest($token, $fol);
                    return $data;
                });

                Route::post('/MisSolicitudes/getValidacionActConst', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidacionActConst($token, $fol);
                    return $data;
                });

                Route::post('/MisSolicitudes/GetValidacionFacturas', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidacionFacturas($token, $fol);
                    return $data;
                });

                Route::post('/MisSolicitudes/GetValidacionReferencias', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidacionReferencias($token, $fol);
                    return $data;
                });

                Route::post('/MisSolicitudes/getFiles', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getFiles($token, $fol);
                    return  $data;
                });

                Route::post('/SolicitudesPendientes/getFile', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Folio;
                    $type = $request->Type;
                    $data = SolicitudesPendientesController::getFile($token, $fol, $type);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getBills', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getBills($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/reSendForm', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::reSendForm($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/Update', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $response = MisSolicitudesController::Update($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/MisSolicitudes/UpdateFile', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    // dd($request->all());
                    $response = MisSolicitudesController::UpdateFile($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/MisSolicitudes/UpdateReferences', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $response = MisSolicitudesController::UpdateReferences($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/MisSolicitudes/UpdateConstAct', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $response = MisSolicitudesController::UpdateConstAct($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/MisSolicitudes/GetEmails', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $zona = $request->zona;
                    $data = MisSolicitudesController::GetEmails($token, $zona);
                    return  $data;
                });

                Route::post('/sendmailSolicitud', function (Request $request) {
                    $folio = $request->folio;
                    $tipoSol = $request->tipoSol;
                    $cliente = $request->cliente;
                    $razonSocial = $request->razonSocial;
                    $rfc = $request->rfc;
                    $zona = $request->zona;
                    $status = $request->status;
                    Mail::to($request->emails)->send(new SolicitudClienteMail($folio, $tipoSol, $cliente, $razonSocial, $rfc, $zona, $status));
                     // check for failures
                    if (Mail::failures()) {
                        return response()->json(['error' => 'Error al enviar email de Solicitud'], 404);
                    }
                    else{
                        return response()->json(['success' => 'Emails Enviados'], 200);
                    }
                });

                //////// ESTADISTICA SOLICITUDES CLIENTES /////
                Route::get('/EstadisticaSolicitudesClientes', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = MisSolicitudesController::getUser($token);
                    return view('intranet.ventas.estadisticaCliente',['token' => $token, 'permissions' => $permissions, 'user' => $user]);
                });

                Route::post('/Indarnet/getMyZone', function(Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = $request->User;
                    $zona = MisSolicitudesController::getZone($token,$user);
                    return $zona;
                });

                Route::post('/EstadisticaCliente/getEmployeeReport', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $typeR = $request->TypeR;
                    $ini = $request->Ini;
                    $fin = $request->Fin;
                    $zone = $request->Zona;
                    $data = EstadisticasClientesController::getEmployeeReport($token, $zone, $typeR, $ini, $fin);
                    return  $data;
                });

                Route::post('/EstadisticaCliente/getGeneralReport', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $typeS = $request->TypeS;
                    $ini = $request->Ini;
                    $end = $request->End;
                    $data = EstadisticasClientesController::getGeneralReport($token, $typeS, $ini, $end);
                    return  $data;
                });

                Route::post('/EstadisticaCliente/getGeneralReportByManagement', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $typeS = $request->TypeS;
                    $ini = $request->Ini;
                    $end = $request->End;
                    $data = EstadisticasClientesController::getGeneralReportByManagement($token, $typeS, $ini, $end);
                    return  $data;
                });

                Route::post('/EstadisticaCliente/getManagementReport', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $idGerencia = $request->IdGerencia;
                    $typeS = $request->TypeS;
                    $ini = $request->Ini;
                    $end = $request->End;
                    $data = EstadisticasClientesController::getManagementReport($token, $idGerencia, $typeS, $ini, $end);
                    return  $data;
                });

                Route::post('/EstadisticaCliente/getManagementReportByEmployee', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $idGerencia = $request->IdGerencia;
                    $typeS = $request->TypeS;
                    $ini = $request->Ini;
                    $end = $request->End;
                    $data = EstadisticasClientesController::getManagementReportByEmployee($token, $idGerencia, $typeS, $ini, $end);
                    return  $data;
                });

                //////// SOLICITUDES PENDIENTES/////
                Route::get('/SolicitudesPendientes', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = MisSolicitudesController::getUserRol($token);
                    $auxUser = json_decode($user->body());
                    $userRol = [$auxUser->typeUser, $auxUser->permissions];
                    if($userRol[1] == "CYC" || $userRol[1] == "GERENTECYC" || $userRol[1] == "ADMIN"){
                        return view('intranet.cyc.solicitudesPendientes',['token' => $token, 'permissions' => $permissions, 'user' => $user]);    
                    }else{
                        return redirect('/Intranet');
                    }
                    //$userRol = [$auxUser->typeUser, $auxUser->permissions];
                    //$testUSer = "bgaribay";
                    //$listSol = SolicitudesPendientesController::getCycTableView($token, $testUSer);
                    //function getTime($time){
                    //    return $time;
                    //}
                    // dd($user->body());
                    
                });

                Route::post('/SolicitudesPendientes/GetCycTableView', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $listSol = SolicitudesPendientesController::getCycTableView($token, $request->User);
                    return $listSol;
                });

                Route::get('/SolicitudesPendientes/GetCobUsernames', function (){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $data = SolicitudesPendientesController::getCobUsernames($token);
                    return  $data;
                });

                Route::get('/SolicitudesPendientes/GetCustomerCatalogs', function (){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $data = SolicitudesPendientesController::getCustomerCatalogs($token);
                    return $data;
                });

                Route::post('/SolicitudesPendientes/SaveValidation', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    // dd($request);
                    $response = SolicitudesPendientesController::saveValidation($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/SolicitudesPendientes/RollBackRequest', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = SolicitudesPendientesController::rollBackRequest($token, $fol);
                    return  $data;
                });

                Route::post('/SolicitudesPendientes/AcceptRequest', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    // dd($request);
                    $response = SolicitudesPendientesController::acceptRequest($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/SolicitudesPendientes/SetReference', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $folio = $request->Folio;
                    $noC = $request->CustomerID;
                    $reference = $request->Reference;
                    $data = SolicitudesPendientesController::setReference($token, $noC, $reference, $folio);
                    return  $data;
                });

                Route::post('/SolicitudesPendientes/ReactiveClient', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $folio = $request->Folio;
                    $noC = $request->NoC;
                    $isCredit = $request->IsCredit;
                    $data = SolicitudesPendientesController::reactiveClient($token, $noC, $folio, $isCredit);
                    return  $data;
                });

                //////////Prueba MisSolicitudes Admin-Gerente ////
                Route::get('/MisSolicitudesAdmin', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = MisSolicitudesController::getUserRol($token);
                    $auxUser = json_decode($user->body());
                    function getStatusM($id){
                        return MisSolicitudesController::getStatus($id);
                    }
                    $userRol = [$auxUser->typeUser, $auxUser->permissions];
                    if($userRol[1] == "VENDEDOR" || $userRol[1] == "APOYOVENTA"){
                        $zone = MisSolicitudesController::getZone($token,$userRol[0]);
                        if($zone->getStatusCode()== 400){
                            return redirect('/Intranet');
                        }
                        $listSol = MisSolicitudesController::getTableView($token, json_decode($zone->body()));
                    }else if($userRol[1] == "ADMIN" || $userRol[1] == "GERENTEVENTA" || $userRol[1] == "CYC" || $userRol[1] == "GERENTECYC"){
                        $zone = "";
                        $listSol = MisSolicitudesController::getTableViewManager($token, $userRol[0]);
                    }else{
                        return redirect('/Intranet');
                    }
                    // dd($listSol);
                    return view('intranet.ventas.misSolicitudesAdmin',['token' => $token, 'permissions' => $permissions, 'zone' => $zone, 'listSol' => $listSol]);
                });

                Route::post('/GetTableView', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $zona = $request->zona;
                    $listSol = MisSolicitudesController::getTableViewManager($token, $zona);
                    return  $listSol;
                });

                /* ********************************************* END INDARNET ************************************************ */

                //CXC
                Route::get('/AplicarPagos', function(){
                    $token = TokenController::getToken();

                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $zonas = AplicarPagoController::getZonas($token);
                    $clientes = AplicarPagoController::getCargaListaClientes($token);
                    return view('intranet.sai.aplicarPagos',['token' => $token, 'permissions' => $permissions,'zonas'=>$zonas,'clientes' => $clientes]);
                });

                Route::get('/AplicarPagos/getRegresaPrimerosDatos', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $id = $request->Id;
                   $data=AplicarPagoController::getRegresaPrimerosDatos($token,$id);
                   $data= $data->resultados->documentos;
                    return $data;

                });

                //******************************************* Comisiones ********************************************************

                Route::get('/comisionesPorCliente', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $zonas = AplicarPagoController::getZonas($token);
                    //$user = MisSolicitudesController::getUser($token);
                    //$zone = MisSolicitudesController::getZone($token,$user->body());
                    return view('intranet.comisiones.comisionesPorCliente',['token' => $token, 'permissions' => $permissions, 'zonas' => $zonas]);
                });

                Route::get('/comisionesVendedor', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $zonas = AplicarPagoController::getZonas($token);
                    $userData = json_decode(MisSolicitudesController::getUserRol($token));
                    //$username = 'jramirez';
                    $username = $userData->typeUser;
                    $zonaInfo = MisSolicitudesController::getZone($token,$username);
                    $zonasgtes = ComisionesController::GetZonasGerente($token,$username);
                    $zona = $zonaInfo->body();
                    //dd($userData->permissions);
                    if(str_contains($zona, 'Bad Request')  && $userData->permissions != 'ADMIN' && $userData->permissions != 'GERENTEVENTA'){
                        $zona = 0;
                    }elseif($userData->permissions == 'ADMIN'){
                        $zona = 'todo';
                         //dd('entraaqui');
                    }elseif(count($zonasgtes) != 0){
                        $zona = $zonasgtes;
                         //dd('entraaqui');
                    }else{

                        $zona = json_decode($zonaInfo->body())->description;

                    }
                    //dd($zona);
                    //dd($zonas,$zona);
                    //$user = MisSolicitudesController::getUser($token);
                    //$zone = MisSolicitudesController::getZone($token,$user->body());
                    return view('intranet.comisiones.comisionesVendedor',['token' => $token, 'permissions' => $permissions, 'zonas' => $zonas, 'zona'=> $zona]);

                });

                Route::get('/comisionesResumen', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    //$user = MisSolicitudesController::getUser($token);
                    //$zone = MisSolicitudesController::getZone($token,$user->body());
                    return view('intranet.comisiones.comisionesResumen',['token' => $token, 'permissions' => $permissions]);
                });


                //Get primera informacion detalle
                Route::get('/comisiones/getInfoCobranzaZonaWeb', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $referencia = $request->referencia;
                   $fecha = $request->fecha;
                   //dd($referencia);
                   $data=ComisionesController::getInfoCobranzaZonaWeb($token,$referencia,$fecha);
                    return $data;

                });

                Route::get('/comisiones/getDiasNoHabiles', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $zona = $request->zona;
                   $fecha = $request->fecha;

                   $data=ComisionesController::getDiasNoHabiles($token,$zona,$fecha);
                   $dataBonos=ComisionesController::getCtesActivosMes($token,$zona,$fecha);
                   $dataVentas =ComisionesController::getTotalVentasZona($token,$zona,$fecha);

                    return array($data, $dataBonos, $dataVentas);

                });

                Route::post('/comisiones/postParametroCtesZona', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $referencia = $request->referencia;
                   $parametroCte = $request->parametroCte ;

                   $data=ComisionesController::postParametroCtesZona($token,$referencia,$parametroCte);


                    return $data;

                });


                Route::get('/comisiones/getDetalle', function (Request $request){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $referencia = $request->referencia;
                   $fecha = $request->fecha;
                   //dd($referencia);
                   $data=ComisionesController::getInfoCobranzaZonaWeb($token,$referencia,$fecha);
                   return view('intranet.comisiones.comisionesDetalle',['token' => $token, 'permissions' => $permissions, 'data' => $data[0]]);

                });

                Route::get('/comisionesCierreMes', function(){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    //$user = MisSolicitudesController::getUser($token);
                    //$zone = MisSolicitudesController::getZone($token,$user->body());
                    return view('intranet.comisiones.comisionesCierreMes',['token' => $token, 'permissions' => $permissions]);
                });

                Route::get('/comisiones/getHistoricoCobranzaZonaList', function (Request $request){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $fecha = $request->fecha;
                   //dd($referencia);
                   $data=ComisionesController::getHistoricoCobranzaZonaList($token,$fecha);
                   return $data;
 
                });

                Route::get('/comisiones/getExistePeriodoEjercicio', function (Request $request){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $fecha = $request->fecha;
                   $data=ComisionesController::getExistePeriodoEjercicio($token,$fecha);
                   return $data;

                });

                Route::get('/comisiones/getCierreMesCobranzaZona', function (Request $request){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $fecha = $request->fecha;
                   $data=ComisionesController::getCierreMesCobranzaZona($token,$fecha);
                   //dd($data);
                   return $data;

                });

                Route::get('/comisionesEspeciales', function (Request $request){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    return view('intranet.comisiones.comisionesEspeciales',['token' => $token, 'permissions' => $permissions]);

                });

                Route::post('/comisiones/postActualizarArticulosEspeciales', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $json = $request->ArtEspeciales;
                   $data=ComisionesController::postActualizarArticulosEspeciales($token,$json);
                    //dd($data);
                    return $data;
                });

                Route::post('/comisiones/postActualizarEspeciales', function (Request $request){
                    $token = TokenController::getToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }

                   $json = $request->EspecialesModel;
                    //dd($json);
                   $data=ComisionesController::postActualizarEspeciales($token,$json);
                    return $data;
                });

                Route::get('/comisiones/getEspecialesPorPeriodo', function (Request $request){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                   $year = $request->year;
                   $month = $request->month;
                   $data=ComisionesController::getEspecialesPorPeriodo($token, $year, $month);
                   return $data;

                });


                // ************************************************  Pago en Linea ***************************************************

                Route::get('/clientes/info', function(){
                    $token = TokenController::getToken();

                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $cliente= 'C004955';
                    $general = ClientesController::getInfoEdoCtaWeb($token, $cliente);
                    //dd($general)
                    $general = $general[0];
                    //dd($general);
                    return view('intranet.clientes.info',['token' => $token, 'permissions' => $permissions,'general' => $general]);
                });

                Route::get('/clientes/pagoEnLinea/{cte}/{fechaini}/{fechafin}', function($cliente, $fechaini, $fechafin){
                    $token = TokenController::getToken();
                    $permissions = LoginController::getPermissions($token);
                    if($token == 'error'){
                        return redirect('/logout');
                    }

                    $data = ClientesController::getFacturasCtesOpen($token, $cliente, $fechaini, $fechafin);
                    $notas = ClientesController::getNotasCreditoCtesOpen($token, $cliente);

                    //dd($notas);
                    return view('intranet.clientes.pagoEnLinea',['token' => $token, 'permissions' => $permissions,'data' => $data,'notas' => $notas]);
                });


});
// ********************* LOGISTICA ******************** \\
// ********************* MESA CONTROL ******************* \\
Route::get('/logistica/mesaControl/planeador',function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.mesaControl.planeador',compact('token','rama1','rama2','rama3','level','permissions','username','userRol'));
})->name('logistica.mesaControl.planeador');

Route::get('/logistica/mesaControl/planeador/getPlaneador', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $planeador = LogisticaController::getPlaneador($token);
    return $planeador;
});

Route::get('/logistica/mesaControl/planeador/getArrayPlaneador',function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $arrayPlaneador = LogisticaController::getArrayPlaneador($token);
    return $arrayPlaneador;
});
Route::get('/logistica/mesaControl/planeador/getCajasPendientes', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $cajasPendientes = LogisticaController::getCajasPendientes($token);
    return $cajasPendientes;
});
// *************************** DISTRIBUCION ***************************** \\
Route::get('/logistica/distribucion',function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.distribucion.index',compact('token','permissions','username','userRol'));
})->name('logistica.distribucion');
// ************************* NUMERO GUIA ************************************** \\
Route::get('/logistica/distribucion/numeroGuia', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }
    $freighters = LogisticaController::getFreighters($token);
    $drivers = LogisticaController::getDrivers($token);
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.distribucion.numeroGuia', compact('token','permissions','username','userRol','freighters','drivers'));
})->name('logistica.distribucion.numeroGuia');
Route::get('/logistica/distribucion/numeroGuia/existShipment', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::existShipment($token,json_encode($request->all()));
    return $response;
});
Route::post('/logistica/distribucion/numeroGuia/captureInvoice', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::captureInvoice($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/distribucion/numeroGuia/existAnyBillsInAnyShipment', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::existAnyBillsInAnyShipment($token,json_encode($request->all()));
    return $response;
});
Route::post('/logistica/distribucion/numeroGuia/saveGuiaNumber', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::saveGuiaNumber($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/distribucion/numeroGuia/costFletera', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::costFletera($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/distribucion/numeroGuia/cuentaBultosWMSManager', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::cuentaBultosWMSManager($token,json_encode($request->all()));
    return $response;
});
// ************************* VALIDAR SAD *************************************** \\
Route::get('/logistica/distribucion/validarSad', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }
    $freighters = LogisticaController::getFreighters($token);
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.distribucion.validarSad', compact('token','permissions','username','userRol','freighters'));
})->name('logistica.distribucion.validarSad');
Route::get('/logistica/distribucion/validarSad/consultValidateSAD', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::consultValidateSAD($token);
    return $response;
});
Route::post('/logistica/distribucion/validarSad/authoriceSad', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::authoriceSad($token,json_encode($request->all()));
    return $response;
});
// ************************* REPORTE SAD *************************************** \\
Route::get('/logistica/distribucion/reporteSad', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }
    $freighters = LogisticaController::getFreighters($token);
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.distribucion.reporteSad', compact('token','permissions','username','userRol','freighters'));
})->name('logistica.distribucion.reporteSad');
Route::get('/logistica/distribucion/getReportSad', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::getReportSad($token);
    return $response;
});
// ************************* REPORTE EMBARQUE ********************************** \\
Route::get('/logistica/distribucion/reporteEmbarque', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();

    $level = "C";
    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }
    $freighters = LogisticaController::getFreighters($token);
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.distribucion.reporteEmbarque', compact('token','permissions','username','userRol','freighters'));
})->name('logistica.distribucion.reporteEmbarque');
Route::get('/logistica/distribucion/reportShipment', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::reportShipment($token);
    return $response;
});
// ************************* CAPTURA GASTO FLETERA ***************************** \\
Route::get('/logistica/distribucion/capturaGastoFletera',function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }

    if(isset($_COOKIE['_lv'])){
        $level = $_COOKIE['_lv'];
    }

    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    $vendors = LogisticaController::getVendors($token);
    $departments = LogisticaController::getDepartments($token);
    $municipios = LogisticaController::getMunicipios($token);
    $clasificadores = LogisticaController::getClasificadores($token);
    return view('intranet.logistica.distribucion.capturaGastoFletera',compact('token','permissions','username','userRol','vendors','departments','municipios','clasificadores'));
})->name('logistica.distribucion.capturaGastoFletera');
Route::get('/logistica/distribucion/capturaGastoFletera/getGuias', function (Request $request) {
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::getGuias($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/distribucion/capturaGastoFletera/getGuia', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::getGuia($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/distribucion/capturaGastoFletera/guiaSelected',function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::guiaSelected($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/distribucion/capturaGastoFletera/getAutorizacion',function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::getAutorizacion($token,json_encode($request->all()));
    return $response;
});
Route::post('/logistica/distribucion/capturaGastoFletera/registroGuia', function (Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::registroGuia($token, json_encode($request->all()));
    return $response;
});
Route::post('/logistica/distribucion/capturaGastoFletera/readFileXML', function (Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    if ($files = $request->file('file')) {
        $file = $request->file('file')->store('public/documents');
        $response = LogisticaController::readFileXML($token,$file);
        return $response;
    }
});
Route::post('/logistica/distribucion/capturaGastoFletera/registerNet', function (Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::registerNet($token,$request->all());
});
//****************************** REPORTES  ************************************\\
Route::get('/logistica/reportes', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }

    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.reportes.index',compact('token','permissions','username','userRol'));
})->name('logistica.reportes');
//***************************** FACTURAS X EMBARCAR **************************\\
Route::get('/logistica/reportes/facturasXEmbarque', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.reportes.facturasxEmbarcar',compact('token','permissions','username','userRol'));
})->name('logistica.reportes.facturasXEmbarcar');
Route::get('/logistica/reportes/facturasXEmbarque/consultBillsXShipments', function (Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::consultBillsXShipments($token,json_encode($request->all()));
    return $response;
});
Route::get('/logistica/reportes/facturasXEmbarque/exportExcelBillsXShipments', function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::exportExcelBillsXShipments($token,json_encode($request->all()));
    return $response;
});
//**************************** GASTO FLETERAS ******************************\\
Route::get('/logistica/reportes/gastoFleteras', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.reportes.gastoFleteras',compact('token','permissions','username','userRol'));
})->name('logistica.reportes.gastoFleteras');
Route::get('/logistica/reportes/gastoFleteras/consultFreightExpense', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::consultFreightExpense($token);
    return $response;
});
//******************************* INTERFAZ RECIBO ****************************\\
Route::get('/logistica/reportes/interfazRecibo', function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;
    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.reportes.interfazRecibo',compact('token','permissions','username','userRol'));
})->name('logistica.reportes.interfazRecibo');
//***************************** INTERFAZ FACTURACION *******************************\\
Route::get('/logistica/reportes/interfazFacturacion',function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    $userData = json_decode(MisSolicitudesController::getUserRol($token));
    $username = $userData->typeUser;
    $userRol = $userData->permissions;

    $permissions = LoginController::getPermissions($token);
    return view('intranet.logistica.reportes.interfazFacturacion',compact('token','permissions','username','userRol'));
})->name('logistica.reportes.interfazFacturacion');
Route::get('/logistica/reportes/interfazFacturacion/consultBillingInterface',function(Request $request){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $response = LogisticaController::consultBillingInterface($token,json_encode($request->all()));
    return $response;
});

//******************************* EXPORTA  ************************************\\
Route::get('/pedidos-exporta',function(){
    $token = TokenController::getToken();
    if($token == 'error'){
        return redirect('/logout');
    }else if(empty($token)){
        return redirect('/logout');
    }
    return view('exporta.pedidos');
})->name('pedidos-exporta');

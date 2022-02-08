<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;

// CUSTOMERS -------------------------------------------------------------------------------
use App\Http\Controllers\Customer\ItemsController;
use App\Http\Controllers\Customer\RamasController;
use App\Http\Controllers\Customer\TokenController;
use App\Http\Controllers\Customer\InvoicesController;
use App\Http\Controllers\Customer\SaleOrdersController;
use App\Http\Controllers\Customer\PromoController;
use App\Http\Controllers\Customer\CotizacionController;
// -----------------------------------------------------------------------------------------

// INTRANET --------------------------------------------------------------------------------

use App\Http\Controllers\Intranet\MisSolicitudesController;
use App\Http\Controllers\Intranet\EstadisticasClientesController;

// ------------------------------------------------------------------------------------------


use App\Http\Middleware\ValidateSession;
use Illuminate\Http\Request;
use App\Exports\TemplateCategories;
use App\Exports\TemplateGiros;
use App\Exports\TemplateClientes;
use App\Exports\TemplateMarcas;
use App\Exports\TemplateProveedores;
use App\Exports\TemplateArticulos;
use App\Exports\TemplatePedido;
use Maatwebsite\Excel\Facades\Excel;

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
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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


Route::get('/login', [LoginController::class, 'authenticate']);

Route::get('/main', function () {
    // VALIDAR LOGIN
    $token = TokenController::refreshToken();
    if($token == 'error'){
        return redirect('/logout');
    }
    $rama1 = RamasController::getRama1();
    $rama2 = RamasController::getRama2();
    $rama3 = RamasController::getRama3();
    return view('main', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3]);
});

Route::get('/faq', function () {
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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
    $token = TokenController::refreshToken();
    if($token == 'error'){
                                    return redirect('/logout');
                                }
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
                                    $token = TokenController::refreshToken();
                                    if($token == 'error'){
                                    return redirect('/logout');
                                }
                                    $rama1 = RamasController::getRama1();
                                    $rama2 = RamasController::getRama2();
                                    $rama3 = RamasController::getRama3();
                                    $level = "C";
                                    if(isset($_COOKIE["level"])){

                                    $level = $_COOKIE["level"];     }

                                    return view('customers.catalogo', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level]);
                                });


                                Route::get('/detallesProducto/{id}',function ($id) {
                                    $token = TokenController::refreshToken();
                                    if($token == 'error'){
                                    return redirect('/logout');
                                }
                                    $rama1 = RamasController::getRama1();
                                    $rama2 = RamasController::getRama2();
                                    $rama3 = RamasController::getRama3();
                                    $item = ItemsController::getProduct($id, $token);
                                });



                // PEDIDOS --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                            Route::get('/pedidos', function (){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                $entity = 'ALL';
                                $pedidos = CotizacionController::getCotizaciones($token, $entity);
                                $permissions = LoginController::getPermissions();

                                return view('customers.pedidos.pedidos', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'pedidos' => $pedidos, 'permissions' => $permissions]);
                            });

                            Route::get('/pedidosAnteriores/{customer}', function ($customer){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
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
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $saleOrders = SaleOrdersController::getSaleOrders($token, $customer);

                                return $saleOrders;
                            });

                            Route::get('pedido/nuevo/{entity}', function ($entity){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = $entity[0];
                                if($level == 'A'){ $level = "E"; } // si entity inicia con A = All es apoyo de ventas = empleado = E
                                if(str_starts_with($entity, 'Z1')){
                                    $entity = 'ALL';
                                }
                                $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                                // dd($data);
                                return view('customers.pedidos.addPedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'entity' => $entity, 'level' => $level, 'data' => $data]);

                            });

                            Route::get('pedido/nuevo', function (){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $entity = 'ALL';
                                $level = $entity[0];
                                if($level == 'A'){ $level = "E"; } // si entity inicia con A = All es apoyo de ventas = empleado = E
                                if(str_starts_with($entity, 'Z1')){
                                    $entity = 'ALL';
                                }


                                $data = SaleOrdersController::getInfoHeatWeb($token, $entity);
                                // dd($data);
                                return view('customers.pedidos.addPedido', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'entity' => $entity, 'level' => $level, 'data' => $data]);

                            });

                            Route::post('/pedido/editar', function (Request $request){
                                $token = TokenController::refreshToken();
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
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $response = CotizacionController::storePedido($token, json_encode($request->all()));
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                return $response;

                            });

                            Route::post('/pedido/updatePedido', function (Request $request){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $response = CotizacionController::updatePedido($token, json_encode($request->all()));
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                return $response;

                            });

                            Route::post('/pedido/storePedidoNS', function (Request $request){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }

                                $getUser = MisSolicitudesController::getUser($token);
                                $user = $getUser->body();
                                $json = $request->json;

                                foreach($json as $key => $field){
                                    $json[$key]['user'] = $user;
                                }

                                dd($json);

                                $response = CotizacionController::storePedido($token, json_encode($request->all()));
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
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
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $entity = $request->entity;
                                $data = SaleOrdersController::getItems($token, $entity);
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

                            Route::post('/pedidosAnteriores/RegresaEstadoPedido', function (Request $request){
                                $token = TokenController::getToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $data = SaleOrdersController::regresaEstadoPedido($token, $request->id);
                                return  $data;
                            });

                            Route::get('/downloadTemplatePedido', function (){
                                return Excel::download(new TemplatePedido,'Pedido.xlsx');
                            });

                // PROMOCIONES ------------------------------------------------------------------------------------------------------------------------------------------------


                            Route::get('/promociones', function (){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                $promociones = PromoController::getAllEvents($token);
                                $permissions = LoginController::getPermissions();
                                return view('customers.promociones.promociones', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'promociones' => $promociones, 'permissions' => $permissions]);
                            });

                            Route::post('/promociones/editar', function (Request $request){
                                $idPromo = $request->id;
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                $promociones = PromoController::getAllEvents($token);
                                $promocion = [];
                                foreach($promociones as $key => $value){
                                    if($value->id == $idPromo){
                                        $promocion = $value;
                                    }
                                }

                                $customersInfo = PromoController::getCustomersInfo($token);
                                $categories = PromoController::getCategories($customersInfo);
                                $giros = PromoController::getGiros($customersInfo);
                                $customers = PromoController::getCustomers($customersInfo);

                                $infoArticulos = SaleOrdersController::getItems($token, 'C002620');
                                $proveedores = PromoController::getProveedores($infoArticulos);
                                $marcas = PromoController::getMarcas($infoArticulos);
                                $articulos = PromoController::getArticulos($infoArticulos);

                                $permissions = LoginController::getPermissions();
                                return view('customers.promociones.editPromocion', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'promocion' => $promocion, 'customersInfo' => $customersInfo, 'categories' => $categories, 'giros' => $giros, 'customers' => $customers, 'proveedores' => $proveedores, 'marcas' => $marcas, 'articulos' => $articulos, 'permissions' => $permissions]);
                            });

                            Route::get('/promociones/nueva', function (){
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                $customersInfo = PromoController::getCustomersInfo($token);

                                $categories = PromoController::getCategories($customersInfo);
                                $giros = PromoController::getGiros($customersInfo);
                                $customers = PromoController::getCustomers($customersInfo);

                                $infoArticulos = SaleOrdersController::getItems($token, 'C002620');
                                dd($infoArticulos);
                                $proveedores = PromoController::getProveedores($infoArticulos);
                                $marcas = PromoController::getMarcas($infoArticulos);
                                $articulos = PromoController::getArticulos($infoArticulos);

                                $permissions = LoginController::getPermissions();

                                return view('customers.promociones.addPromocion', ['token' => $token, 'rama1' => $rama1, 'rama2' => $rama2, 'rama3' => $rama3, 'level' => $level, 'customersInfo' => $customersInfo, 'categories' => $categories, 'giros' => $giros, 'customers' => $customers, 'proveedores' => $proveedores, 'marcas' => $marcas, 'articulos' => $articulos, 'permissions' => $permissions]);
                            });

                            Route::get('promociones/getPromocionesInfo', function (){
                                $token = TokenController::getToken();
                                $customersInfo = PromoController::getCustomersInfo($token);
                                $categories = PromoController::getCategories($customersInfo);
                                $giros = PromoController::getGiros($customersInfo);
                                $customers = PromoController::getCustomers($customersInfo);

                                $infoArticulos = SaleOrdersController::getItems($token, 'C002620');
                                $proveedores = PromoController::getProveedores($infoArticulos);
                                $marcas = PromoController::getMarcas($infoArticulos);
                                $articulos = PromoController::getArticulos($infoArticulos);

                                $info = array($customersInfo, $categories, $giros, $customers, $infoArticulos, $proveedores, $marcas, $articulos);
                                dd($info);
                                return $customersInfo;
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
                                $token = TokenController::refreshToken();
                                if($token == 'error'){
                                    return redirect('/logout');
                                }
                                $response = PromoController::storePromo($token, json_encode($request->all()));
                                $rama1 = RamasController::getRama1();
                                $rama2 = RamasController::getRama2();
                                $rama3 = RamasController::getRama3();
                                $level = "C";
                                if(isset($_COOKIE["level"])){
                                    $level = $_COOKIE["level"];
                                }
                                return $response;

                            });


                 // INTRANET ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                 Route::get('/Intranet', function(){
                    $entity = "C002620";
                    $permissions = LoginController::getPermissions();
                    return view('intranet.main', ['entity' => $entity, 'permissions' => $permissions]);
                });

                Route::get('/MisSolicitudes', function(){
                    $token = TokenController::refreshToken();
                    $permissions = LoginController::getPermissions();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = MisSolicitudesController::getUser($token);
                    $zone = MisSolicitudesController::getZone($token,$user->body());
                    if($zone->getStatusCode()== 400){
                        return redirect('/Intranet');
                    }
                    $listSol = MisSolicitudesController::getTableView($token, json_decode($zone->body()));
                    function getStatus($id){
                        return MisSolicitudesController::getStatus($id);
                    }
                    return view('intranet.ventas.misSolicitudes',['token' => $token, 'permissions' => $permissions, 'zone' => $zone, 'listSol' => $listSol]);
                    /*return view('intranet.ventas.misSolicitudes');*/
                });

                Route::post('/MisSolicitudes/storeSolicitud', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    // dd($request->all());
                    $response = MisSolicitudesController::storeSolicitud($token, json_encode($request->all()));
                    return $response;
                });

                Route::post('/MisSolicitudes/saveSolicitud', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    // dd($request->all());
                    $response = MisSolicitudesController::saveSolicitud($token, json_encode($request->all()));
                    return $response;
                });

                Route::get('/MisSolicitudes/getBusinessLines', function (){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $data = MisSolicitudesController::getBusinessLines($token);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getInfoSol', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getInfoSol($token, $fol);
                    return  $data;
                });

                Route::get('/MisSolicitudes/getCPData', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $cp = $request->cp;
                    $data = MisSolicitudesController::getCPData($token, $cp);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getTransactionHistory', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getTransactionHistory($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getValidacionContactos', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidacionContactos($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getValidationRequest', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getValidationRequest($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getFiles', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getFiles($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/getBills', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::getBills($token, $fol);
                    return  $data;
                });

                Route::post('/MisSolicitudes/reSendForm', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $fol = $request->Item;
                    $data = MisSolicitudesController::reSendForm($token, $fol);
                    return  $data;
                });

                Route::get('/SolicitudesPendientes', function(){
                    return view('intranet.cyc.solicitudesPendientes');
                });

                Route::get('/EstadisticaSolicitudesClientes', function(){
                    $token = TokenController::refreshToken();
                    $permissions = LoginController::getPermissions();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $user = MisSolicitudesController::getUser($token);
                    $zone = MisSolicitudesController::getZone($token,$user->body());
                    return view('intranet.ventas.estadisticaCliente',['token' => $token, 'permissions' => $permissions, 'zone' => $zone]);
                });

                Route::post('/EstadisticaCliente/getEmployeeReport', function (Request $request){
                    $token = TokenController::refreshToken();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    $typeR = $request->TypeR;
                    $ini = $request->Ini;
                    $fin = $request->Fin;
                    $zoneObj = json_decode($request->Zona);
                    $zone = $zoneObj->description;
                    $data = EstadisticasClientesController::getEmployeeReport($token, $zone, $typeR, $ini, $fin);
                    return  $data;

                });

                //CXC
                Route::get('/AplicarPagos', function(){
                    $token = TokenController::refreshToken();
                    $permissions = LoginController::getPermissions();
                    if($token == 'error'){
                        return redirect('/logout');
                    }
                    //$user = MisSolicitudesController::getUser($token);
                    //$zone = MisSolicitudesController::getZone($token,$user->body());

                    return view('intranet.sai.aplicarPagos',['token' => $token, 'permissions' => $permissions]);
                });



});





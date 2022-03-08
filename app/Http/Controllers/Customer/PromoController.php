<?php

namespace App\Http\Controllers\Customer;


use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\TemplateCategories;
use Maatwebsite\Excel\Facades\Excel;
use Config;
 

class PromoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    { 
        // 
    }

    public static function getCustomersInfo($token){
        $getCustomers = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/GetCustomers');
        $customers = json_decode($getCustomers->body());

        $categories = [];
        $giros = [];
        $customersArray = [];
        $ids = [];

        for($x = 0; $x < count($customers); $x++){
            if(count($categories)==0){
                array_push($categories, $customers[$x]->category);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($categories); $y++){
                    if($categories[$y]==$customers[$x]->category){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($categories, $customers[$x]->category);
                }
            }

            if(count($giros)==0){
                array_push($giros, $customers[$x]->groupC);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($giros); $y++){
                    if($giros[$y]==$customers[$x]->groupC){
                        $insert = false;
                        break;
                    } 
                }
                if($insert){
                    array_push($giros, $customers[$x]->groupC);
                }
            }

            if(count($customersArray)==0){
                array_push($customersArray, "[".$customers[$x]->companyID."] ".$customers[$x]->company);
                array_push($ids, $customers[$x]->companyID);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($customersArray); $y++){
                    if($ids[$y]==$customers[$x]->companyID){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($customersArray, "[".$customers[$x]->companyID."] ".$customers[$x]->company);
                    array_push($ids, $customers[$x]->companyID);
                }
            }

        }

        $info = ["customersInfo" => $customers, "categories" => $categories, "giros" => $giros, "customers" => $customersArray];
        return $info;
    } 

    public static function getCategories($customers){
        $categories = [];
        for($x = 0; $x < count($customers); $x++){
            if(count($categories)==0){
                array_push($categories, $customers[$x]->category);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($categories); $y++){
                    if($categories[$y]==$customers[$x]->category){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($categories, $customers[$x]->category);
                }
            }
        }

        return $categories;
    }

    public static function getGiros($customers){
        $giros = [];
        for($x = 0; $x < count($customers); $x++){
            if(count($giros)==0){
                array_push($giros, $customers[$x]->groupC);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($giros); $y++){
                    if($giros[$y]==$customers[$x]->groupC){
                        $insert = false;
                        break;
                    } 
                }
                if($insert){
                    array_push($giros, $customers[$x]->groupC);
                }
            }
        }
        return $giros;
    }

    public static function getCustomers($info){
        $customers = [];
        $ids = [];
        for($x = 0; $x < count($info); $x++){
            if(count($customers)==0){
                array_push($customers, "[".$info[$x]->companyID."] ".$info[$x]->company);
                array_push($ids, $info[$x]->companyID);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($customers); $y++){
                    if($ids[$y]==$info[$x]->companyID){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($customers, "[".$info[$x]->companyID."] ".$info[$x]->company);
                    array_push($ids, $info[$x]->companyID);
                }
            }
        }
        return $customers;
    }

    public static function getItems($token){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/GetItemsForEvents');
        $info = json_decode($response->body());
        
        $proveedores = [];
        $marcas = [];
        $articulos = [];
        $ids = [];

        for($x = 0; $x < count($info); $x++){
            if(count($proveedores)==0){
                array_push($proveedores, $info[$x]->clavefabricante);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($proveedores); $y++){
                    if($proveedores[$y]==$info[$x]->clavefabricante){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($proveedores, $info[$x]->clavefabricante);
                }
            }

            if(count($marcas)==0){
                array_push($marcas, $info[$x]->familia);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($marcas); $y++){
                    if($marcas[$y]==$info[$x]->familia){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($marcas, $info[$x]->familia);
                }
            }

            if(count($articulos)==0){
                array_push($articulos, "[".$info[$x]->itemid."] ".$info[$x]->purchasedescription);
                array_push($ids, $info[$x]->itemid);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($articulos); $y++){
                    if($ids[$y]==$info[$x]->itemid){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($articulos, "[".$info[$x]->itemid."] ".$info[$x]->purchasedescription);
                    array_push($ids, $info[$x]->itemid);
                }
            }
        }

        $response = ["items" => $info, "proveedores" => $proveedores, "marcas" => $marcas, "articulos" => $articulos];
        return $response;
    } 

    public static function getProveedores($info){
        $proveedores = [];
        for($x = 0; $x < count($info); $x++){
            if(count($proveedores)==0){
                array_push($proveedores, $info[$x]->clavefabricante);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($proveedores); $y++){
                    if($proveedores[$y]==$info[$x]->clavefabricante){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($proveedores, $info[$x]->clavefabricante);
                }
            }
        }

        return $proveedores;
    }

    public static function getMarcas($info){
        $marcas = [];
        for($x = 0; $x < count($info); $x++){
            if(count($marcas)==0){
                array_push($marcas, $info[$x]->familia);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($marcas); $y++){
                    if($marcas[$y]==$info[$x]->familia){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($marcas, $info[$x]->familia);
                }
            }
        }

        return $marcas;
    }


    public static function getArticulos($info){
        $articulos = [];
        $ids = [];
        for($x = 0; $x < count($info); $x++){
            if(count($articulos)==0){
                array_push($articulos, "[".$info[$x]->itemid."] ".$info[$x]->purchasedescription);
                array_push($ids, $info[$x]->itemid);
            }
            else{
                $insert = true;
                for($y = 0; $y < count($articulos); $y++){
                    if($ids[$y]==$info[$x]->itemid){
                        $insert = false;
                        break;
                    }
                }
                if($insert){
                    array_push($articulos, "[".$info[$x]->itemid."] ".$info[$x]->purchasedescription);
                    array_push($ids, $info[$x]->itemid);
                }
            }
        }
        return $articulos;
    }

    public static function downloadTemplateCategories() {
        return Excel::download(new TemplateCategories,'invoices.xlsx');
    }

    public static function storePromo($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Eventos/EventADDNewEdit', [
            "id" => $json->id,
            "nombrePromo" => $json->nombrePromo, 
            "descuento" => $json->descuento,
            "descuentoWeb" => $json->descuentoWeb,
            "puntosIndar" => $json->puntosIndar,
            "plazosIndar" => $json->plazosIndar,
            "regalosIndar" => $json->regalosIndar,
            "categoriaClientes" => $json->categoriaClientes,
            "categoriaClientesIncluye" => $json->categoriaClientesIncluye,
            "gruposclientesIds" => $json->gruposclientesIds,
            "gruposclientesIncluye" => $json->gruposclientesIncluye,
            "clientesId" => $json->clientesId,
            "clientesIncluye" => $json->clientesIncluye,
            "plazo" => $json->plazo,
            "montoMinCash" => $json->montoMinCash,
            "montoMinQty" => $json->montoMinQty,
            "fechaInicio" => $json->fechaInicio,
            "fechaFin" => $json->fechaFin,
            "paquete" => $json->paquete,
            "idPaquete" => $json->idPaquete,
            "pedidoPromoRulesD" => $json->pedidoPromoRulesD,
        ]);

        return $response;
    }

    public static function getAllEvents($token){
        $events = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/getAllEvents');
        return json_decode($events->body());
    }

    public static function getEventById($token, $id){
        $event = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/getIdEvents?IdPromo='.$id);
        return json_decode($event->body());
    }
    
    public static function formatDate($promocion){
        $startTime = explode('T', $promocion->fechaInicio)[0];
        $endTime = explode('T', $promocion->fechaFin)[0];

        $splitStartTime = explode('-', $startTime);
        $splitEndTime = explode('-', $endTime);

        $startYear = $splitStartTime[0];
        $startMonth = $splitStartTime[1];
        $startDay = $splitStartTime[2];

        $endYear = $splitEndTime[0];
        $endMonth = $splitEndTime[1];
        $endDay = $splitEndTime[2];

        $datePromo = $startMonth."/".$startDay."/".$startYear." - ".$endMonth."/".$endDay."/".$endYear;

        return $datePromo;
    }

    public static function getStartTime($promocion){
        $startTime = explode('T', $promocion->fechaInicio)[1];

        $splitStartTime = explode(':', $startTime);

        $startHours = $splitStartTime[0];
        $startMinutes = $splitStartTime[1];

        $startTime = $startHours.":".$startMinutes;

        return $startTime;
    }

    public static function getEndTime($promocion){
        $endTime = explode('T', $promocion->fechaFin)[1];

        $splitEndTime = explode(':', $endTime);

        $endHours = $splitEndTime[0];
        $endMinutes = $splitEndTime[1];

        $endTime = $endHours.":".$endMinutes;

        return $endTime;
    }

}

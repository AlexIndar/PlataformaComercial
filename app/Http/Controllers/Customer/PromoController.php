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
            if(!in_array($customers[$x]->category, $categories)){
                array_push($categories, $customers[$x]->category);
            }

            if(!in_array($customers[$x]->groupC, $giros)){
                array_push($giros, $customers[$x]->groupC);
            }

            if(!in_array("[".$customers[$x]->companyID."] ".$customers[$x]->company, $customersArray)){
                array_push($customersArray, "[".$customers[$x]->companyID."] ".$customers[$x]->company);
            }

        }

        $info = ["customersInfo" => $customers, "categories" => $categories, "giros" => $giros, "customers" => $customersArray];
        return $info;
    } 

    public static function getItems($token){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/GetItemsForEvents');
        $info = json_decode($response->body());
        
        $proveedores = [];
        $marcas = [];
        $articulos = [];
        $ids = [];

        for($x = 0; $x < count($info); $x++){
            if(!in_array($info[$x]->clavefabricante, $proveedores)){
                array_push($proveedores, $info[$x]->clavefabricante);
            }

            if(!in_array($info[$x]->familia, $marcas)){
                array_push($marcas, $info[$x]->familia);
            }

            if(!in_array("[".$info[$x]->itemid."] ".$info[$x]->purchasedescription, $articulos)){
                array_push($articulos, "[".$info[$x]->itemid."] ".$info[$x]->purchasedescription);
            }
        }

        $response = ["items" => $info, "proveedores" => $proveedores, "marcas" => $marcas, "articulos" => $articulos];
        return $response;
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
            "reemplazaRegalo" => $json->reemplazaRegalo,
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
            "cuotasPersonalizadas" => $json->cuotasPersonalizadas,
        ]);

        return $response;
    }

    public static function deletePromo($token, $id){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/getDeleteEvents?IdDelete='.$id);
        $promo = json_decode($response->body());
        return $promo;
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

    public static function getCuotasPersonalizadas($token, $id){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/getCuotaPersonalizada?Id='.$id);
        return json_decode($response->body());
    }

    public static function getReglasPaquete($token, $id){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/Eventos/getIdPaquete?IdPaquete='.$id);
        return json_decode($response->body());
    }
}

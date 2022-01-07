<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MisSolicitudesController extends Controller
{
     /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       
    }


    public static function getUser($token){
        $getUSer = Http::withToken($token)->get('http://192.168.70.107:64444/Login/getUserby?token='.$token);
        return $getUSer;
    }
    
    public static function getZone($token, $user){
        $getZone = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getZone?userName='.$user);
        return $getZone;
    }

    public static function getTableView($token, $zone){
        $zDescription = $zone->description;
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getTableView?zona='.$zDescription);
        return json_decode($solicitudes->body());
    }

    public static function getBusinessLines($token){
        $businessLines = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetBusinessLines');
        return json_decode($businessLines->body());
    }

    public static function getInfoSol($token, $folio){
        $solicitud = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getRequestDetail?fol='.$folio);
        return json_decode($solicitud->body());
    }

    public static function getCPData($token, $cp){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getCPData?cp='.$cp);
        return json_decode($data->body());
    }

    public static function getTransactionHistory($token, $folio){
        $history = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getTransactionHistory?fol='.$folio);
        return json_decode($history->body());
    }

    public static function getValidacionContactos($token, $folio){
        $history = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetValidacionContactos?id='.$folio);
        return json_decode($history->body());
    }

    public static function getValidationRequest($token, $folio){
        $valSol = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetValidacionSolicitud?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getFiles($token, $folio){
        $valSol = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getFiles?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getStatus($id)
    {
        switch ($id) {
            case '1':
                $descripcion = 'Solicitud Guardada';
                break;
            case '2':
                $descripcion = 'Solicitud Guardada';
                break;
            case '3':
                $descripcion = 'Solicitud Guardada';
                break;
            case '4':
                $descripcion = 'Aceptada Contado';
                break;
            case '5':
                $descripcion = 'Solicitud Guardada';
                break;
            case '6':
                $descripcion = 'Aceptada Credito';
                break;
            case '7':
                $descripcion = 'Solicitud Guardada';
                break;
            case '8':
                $descripcion = 'Rechazada Credito (Aceptada Contado)';
                break;
            case '9':
                $descripcion = 'Solicitud Guardada';
                break;
            case '10':
                $descripcion = 'Solicitud Guardada';
                break;
            case '11':
                $descripcion = 'Solicitud Guardada';
                break;
            case '12':
                $descripcion = 'Solicitud Guardada';
                break;
            default:
                $descripcion = 'Sin estado';
        }
        return $descripcion;
    }

    public static function storeSolicitud($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/CyC/Create', [
            "folio" => $json->folio,
            "fecha" => $json->fecha,
            "tipo" => $json->tipo,
            "credito" => $json->credito,
            "zona" => $json->zona,
            "cliente" => $json->cliente,
            "referencias" => $json->referencias,
            // "historyForm" => $json->historyForm,
            "archivos" => $json->archivos,
            "factura" => $json->factura,
            "observations" => $json->observations,
        ]);


        return $response;
    }

}

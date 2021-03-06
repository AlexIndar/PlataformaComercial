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
        $getUSer = Http::withToken($token)->get(config('global.api_url').'/Login/getUserby?token='.$token);
        return $getUSer;
    }

    public static function getUserRol($token){
        $getUserRol = Http::withToken($token)->get(config('global.api_url').'/Login/getUserRol?token='.$token);
        return $getUserRol;
    }
    
    public static function getZone($token, $user){
        $getZone = Http::withToken($token)->get(config('global.api_url').'/Cyc/getZone?userName='.$user);
        return $getZone;
    }

    public static function getTableView($token, $zone){
        $zDescription = $zone->description;
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/getTableView?zona='.$zDescription);
        return json_decode($solicitudes->body());
    }

    public static function getTableViewA($token, $zone){        
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/getTableView?zona='.$zone);
        return json_decode($solicitudes->body());
    }

    public static function getTableViewManager($token, $user){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetTableViewManager?username='.$user);
        return json_decode($solicitudes->body());
    }

    public static function getBusinessLines($token){
        $businessLines = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetBusinessLines');
        return json_decode($businessLines->body());
    }

    public static function getInfoSol($token, $folio){
        $solicitud = Http::withToken($token)->get(config('global.api_url').'/Cyc/getRequestDetail?fol='.$folio);
        return json_decode($solicitud->body());
    }

    public static function getCPData($token, $cp){
        $data = Http::withToken($token)->get(config('global.api_url').'/Cyc/getCPData?cp='.$cp);
        return json_decode($data->body());
    }

    public static function getTransactionHistory($token, $folio){
        $history = Http::withToken($token)->get(config('global.api_url').'/Cyc/getTransactionHistory?fol='.$folio);
        return json_decode($history->body());
    }

    public static function reSendForm($token, $folio){
        $history = Http::withToken($token)->get(config('global.api_url').'/Cyc/resendRequest?fol='.$folio);
        return json_decode($history->body());
    }

    public static function getValidacionContactos($token, $folio){
        $history = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetValidacionContactos?id='.$folio);
        return json_decode($history->body());
    }

    public static function getValidationRequest($token, $folio){
        $valSol = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetValidacionSolicitud?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getValidacionActConst($token, $folio){
        $valSol = Http::withToken($token)->get(config('global.api_url').'/Cyc/getValidacionActConst?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getValidacionFacturas($token, $folio){
        $valSol = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetValidacionFacturas?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getValidacionReferencias($token, $folio){
        $valSol = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetValidacionReferencias?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getFiles($token, $folio){
        $valSol = Http::withToken($token)->get(config('global.api_url').'/Cyc/getFiles?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function getBills($token, $folio){
        $valSol = Http::withToken($token)->get(config('global.api_url').'/Cyc/getBills?id='.$folio);
        return json_decode($valSol->body());
    }

    public static function GetCYCTableShow($token, $username){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetCYCTableShow?username='.$username);
        return json_decode($solicitudes->body());
    }

    public static function Update($token, $data){
        $json = json_decode($data);        
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/Update', [
            "Folio" => $json->Folio,
            "TypeForm" => $json->TypeForm,
            "Cliente" => $json->Cliente,
            "DatosF" => $json->DatosF,
            "DomF" => $json->DomF,
            "DomE" => $json->DomE,
            "ClienteFlag" => $json->ClienteFlag,
            "DatosFFlag" => $json->DatosFFlag,
            "DomFFlag" => $json->DomFFlag,
            "DomEFlag" => $json->DomEFlag,
        ]);
        return $response;
    }

    public static function UpdateFile($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/UpdateFile', [
            "Folio" => $json->Folio,
            "File" => $json->File,
        ]);
        return $response;
    }

    public static function UpdateReferences($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/UpdateReferences', [
            "Folio" => $json->Folio,
            "Referencias" => $json->Referencias,
            "Facturas" => $json->Facturas,
            "Caratula" => $json->Caratula
        ]);
        return $response;
    }

    public static function UpdateConstAct($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/UpdateConstAct', [
            "Folio" => $json->Folio,
            "ConsActs" => $json->ConsActs,
        ]);
        return $response;
    }

    public static function GetEmails($token, $zona){
        $response = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetEmails?zona='.$zona);
        return json_decode($response->body());
    }
    
    public static function getStatus($id)
    {
        switch ($id) {
            case '1':
                $descripcion = 'Solicitud Guardada';
                break;
            case '2':
                $descripcion = 'Solicitud Enviada';
                break;
            case '3':
                $descripcion = 'Validacion Guardada';
                break;
            case '4':
                $descripcion = 'Aceptada Contado';
                break;
            case '5':
                $descripcion = 'Aceptada Contado (Pendiente Credito)';
                break;
            case '6':
                $descripcion = 'Aceptada Credito';
                break;
            case '7':
                $descripcion = 'Rechazada';
                break;
            case '8':
                $descripcion = 'Rechazada Credito (Aceptada Contado)';
                break;
            case '9':
                $descripcion = 'Solicitud Reenviada';
                break;
            case '10':
                $descripcion = 'Solicitud Cancelada';
                break;
            case '11':
                $descripcion = 'Revision Referencias';
                break;
            case '12':
                $descripcion = 'Proceso Autorizacion';
                break;
            default:
                $descripcion = 'Sin estado';
        }
        return $descripcion;
    }

    public static function storeSolicitud($token, $data){
        
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/Create', [
            "folio" => $json->folio,
            "fecha" => $json->fecha,
            "tipo" => $json->tipo,
            "credito" => $json->credito,
            "zona" => $json->zona,
            "cliente" => $json->cliente,
            "referencias" => $json->referencias,
            "archivos" => $json->archivos,
            "factura" => $json->factura,
            "observations" => $json->observations,
        ]);
        return $response;
    }

    public static function saveSolicitud($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/Save', [
            "folio" => $json->folio,
            "fecha" => $json->fecha,
            "tipo" => $json->tipo,
            "credito" => $json->credito,
            "zona" => $json->zona,
            "cliente" => $json->cliente,
            "referencias" => $json->referencias,
            "archivos" => $json->archivos,
            "factura" => $json->factura,
            "observations" => $json->observations,
        ]);
        return $response;
    }

}

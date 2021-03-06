<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SolicitudesPendientesController extends Controller
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

    public static function getCobUsernames($token){
        $cobUsernames = Http::withToken($token)->get(config('global.api_url').'/Cyc/getCobUsernames');
        return json_decode($cobUsernames->body());
    }

    public static function getCustomerCatalogs($token){
        $customerCatalogs = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetCustomerCatalogs');        
        return json_decode($customerCatalogs->body());
    }

    public static function getCycTableView($token, $username){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/getCYCTableView?username='.$username);
        return json_decode($solicitudes->body());
    }

    public static function getFile($token, $folio, $type){
        $file = Http::withToken($token)->get(config('global.api_url').'/Cyc/getFile?id='.$folio.'&type='.$type);
        return json_decode($file->body());
    }

    public static function rollBackRequest($token, $folio){
        $history = Http::withToken($token)->get(config('global.api_url').'/Cyc/RollBackRequest?folio='.$folio);
        return json_decode($history->body());
    }

    public static function setReference($token, $noC, $reference, $folio){
        $file = Http::withToken($token)->get(config('global.api_url').'/Cyc/SetReference?noC='.$noC.'&reference='.$reference.'&folio='.$folio);
        return json_decode($file->body());
    }

    public static function reactiveClient($token, $noC, $folio, $isCredit){
        $file = Http::withToken($token)->get(config('global.api_url').'/Cyc/ReactiveClient?noC='.$noC.'&folio='.$folio.'&isCredit='.$isCredit);
        return json_decode($file->body());
    }

    public static function saveValidation($token, $data){
        $json = json_decode($data);        
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/SaveValidation', [
            "Solicitud" => $json->Solicitud,
            "Referencias" => $json->Referencias,
            "ActasConst" => $json->ActasConst,
            "Contacto" => $json->Contacto,
            "Facturas" => $json->Facturas,
            "Status" => $json->Status,
            "Observaciones" => $json->Observaciones,
        ]);
        return $response;
    }

    public static function acceptRequest($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/AcceptRequest', [
            "folioSolicitud" => $json->folioSolicitud,
            "referenciaBancaria" => $json->referenciaBancaria,
            "condicionesComerciales" => $json->condicionesComerciales,
            "listaPrecios" => $json->listaPrecios,
            "condicionPago" => $json->condicionPago,
            "formaEnvio" => $json->formaEnvio,
            "limiteSaldo" => $json->limiteSaldo,
            "diasMaximos" => $json->diasMaximos,
            "indarBonoCteNvo" => $json->indarBonoCteNvo,
            "indarRutaVenta" => $json->indarRutaVenta,
            "indarRuta" => $json->indarRuta,
            "pagareMonto" => $json->pagareMonto,
            "pagareNuevo" => $json->pagareNuevo,
            "usuario" => $json->usuario,
            "ineValidacion" => $json->ineValidacion,
            "status" => $json->status,
            "categoryId" => $json->categoryId,
            "indarFormaEnvioFiscal" => $json->indarFormaEnvioFiscal,
            "indarPaqueteriaFiscal" => $json->indarPaqueteriaFiscal,
            "indarFormaEnvio" => $json->indarFormaEnvio,
            "indarPaqueteriaEnvio" => $json->indarPaqueteriaEnvio,
        ]);
        return $response;
    }
}

<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;

class CotizacionController extends Controller
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

    public static function getCotizaciones($token, $entity){
        $getCotizaciones = Http::withToken($token)->get(config('global.api_url').'/Cotizacion/getInfoCotizacionWeb?entity='.$entity);
        $cotizaciones = json_decode($getCotizaciones->body());
        return $cotizaciones;
    } 

    public static function getCotizacionesByUser($token, $entity){
        $getCotizaciones = Http::withToken($token)->get(config('global.api_url').'/Cotizacion/getInfoUsuarioCotizacionWeb?entity='.$entity);
        $cotizaciones = json_decode($getCotizaciones->body());
        return $cotizaciones;
    } 

    public static function getCotizacionIdWeb($token, $id){
        $getCotizacion = Http::withToken($token)->get(config('global.api_url').'/Cotizacion/getInfoCotizacionIdWeb?id='.$id);
        $cotizacion = json_decode($getCotizacion->body());
        return $cotizacion;
    }

    public static function storePedido($token, $data, $username){
        date_default_timezone_set('America/Mexico_City');
        $json = json_decode($data);
        $dateTime = date("Y-m-d H:i:s");
        $dateTime = str_replace(" ", "T", $dateTime);
        $response = Http::withToken($token)->post(config('global.api_url').'/Cotizacion/CotizacionInsertLWS', [
            "idCotizacion" => $json->idCotizacion,
            "companyId" => $json->companyId,
            "orderC" => $json->orderC,
            "email" => $json->email,
            "addressId" => $json->addressId,
            "shippingWay" => $json->shippingWay,
            "packageDelivery" => $json->packageDelivery,
            "divide" => $json->divide,
            "pickUp" => $json->pickUp,
            "order" => $json->order,
            "comments" => $json->comments,
            "enviado" => $json->enviado,
            "usuario" => $username,
            "fecha" => $dateTime,
        ]);
        return $response;
    }

    public static function deletePedido($token, $id){
        $response = Http::withToken($token)->post(config('global.api_url').'/Cotizacion/getBorrarCotizacionIdWeb?Id='.$id);
        $cotizacion = json_decode($response->body());
        return $cotizacion;     
    }

    public static function getZonasApoyo($token, $username){
        $response = Http::withToken($token)->get(config('global.api_url').'/Cotizacion/getInfoZonasCotizacionIdWeb?usuario='.$username);
        $zonas = json_decode($response->body());
        return $zonas;     
    }
}

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
        $getCotizaciones = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoCotizacionWeb?entity='.$entity);
        $cotizaciones = json_decode($getCotizaciones->body());
        return $cotizaciones;
    } 

    public static function getCotizacionIdWeb($token, $id){
        $getCotizacion = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoCotizacionIdWeb?id='.$id);
        $cotizacion = json_decode($getCotizacion->body());
        return $cotizacion;
    }

    public static function storePedido($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Cotizacion/CotizacionInsertLWS', [
            "idCotizacion" => 0,
            "companyId" => $json->companyId,
            "orderC" => $json->orderC,
            "email" => $json->email,
            "addressId" => $json->addressId,
            "shippingWay" => $json->shippingWay,
            "packageDelivery" => $json->packageDelivery,
            "divide" => $json->divide,
            "pickUp" => $json->pickUp,
            "order" => $json->order,
            "comments" => $json->comments
        ]);
    }

    public static function updatePedido($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Cotizacion/CotizacionInsertLWS', [
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
            "comments" => $json->comments
        ]);
    }

}

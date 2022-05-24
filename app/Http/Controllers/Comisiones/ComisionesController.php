<?php

namespace App\Http\Controllers\Comisiones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Customer\TokenController;

class ComisionesController extends Controller
{
    public static function getInfoCobranzaZonaWeb($token, $referencia,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getInfoCobranzaZonaWeb?referencia='.$referencia.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getDiasNoHabiles($token, $zona,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getDiasNoHabiles?zona='.$zona.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function postParametroCtesZona($token, $referencia,$parametroCte){
        $data = Http::withToken($token)->post('http://192.168.70.107:64444/CobranzaZona/postParametroCtesZona?referencia='.$referencia.'&parametroCte='.$parametroCte);
        return json_decode($data->body());
    }

    public static function  postActualizarArticulosEspeciales($token, $json){
        //dd(json_encode($json));
        $data = Http::withToken($token)->post('http://192.168.70.107:64444/Especiales/postActualizarArticulosEspeciales',[
            "ArtEspeciales" => $json
        ]);

        return $data->body();
    }

    public static function  postActualizarEspeciales($token, $json){

        $data = Http::withToken($token)->post('http://192.168.70.107:64444/Especiales/postActualizarEspeciales',[
            "EspecialesModel" => $json
        ]);
        //dd($data);
        return json_decode($data->body());
    }

    public static function getEspecialesPorPeriodo($token, $year,$month){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/Especiales/getEspecialesPorPeriodo?year='.$year.'&month='.$month);
        return json_decode($data->body());
    }

    public static function getCtesActivosMes($token, $referencia,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getCtesActivosMes?referencia='.$referencia.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getTotalVentasZona($token, $referencia,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getTotalVentasZona?zona='.$referencia.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getHistoricoCobranzaZonaList($token,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getHistoricoCobranzaZonaList?fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getExistePeriodoEjercicio($token,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getExistePeriodoEjercicio?fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getCierreMesCobranzaZona($token,$fecha){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getCierreMesCobranzaZona?fecha='.$fecha);
        return json_decode($data->body());
    }


}

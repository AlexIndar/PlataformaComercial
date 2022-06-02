<?php

namespace App\Http\Controllers\Comisiones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Customer\TokenController;

class ComisionesController extends Controller
{
    public static function getInfoCobranzaZonaWeb($token, $referencia,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getInfoCobranzaZonaWeb?referencia='.$referencia.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getProductosVendidos($token, $fecha,$zona){
        $data = Http::withToken($token)->get(config('global.api_url').'/Especiales/getProductosVendidos?fecha='.$fecha.'&zona='.$zona);
        return json_decode($data->body());
    }

    public static function getDiasNoHabiles($token, $zona,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getDiasNoHabiles?zona='.$zona.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function postParametroCtesZona($token, $referencia,$parametroCte){
        $data = Http::withToken($token)->post(config('global.api_url').'/CobranzaZona/postParametroCtesZona?referencia='.$referencia.'&parametroCte='.$parametroCte);
        return json_decode($data->body());
    }

    public static function  postActualizarArticulosEspeciales($token, $json){
        //dd(json_encode($json));
        $json = json_decode($json);
        $data = Http::withToken($token)->post(config('global.api_url').'/Especiales/postActualizarArticulosEspeciales',[
            "ArtEspeciales" => $json
        ]);

        return $data->body();
    }

    public static function  postActualizarEspeciales($token, $json){
        $json = json_decode($json);
        //dd($json);
        $data = Http::withToken($token)->post(config('global.api_url').'/Especiales/postActualizarEspeciales',[
            "EspecialesModel" => $json
        ]);

        return json_decode($data->body());
    }

    public static function getEspecialesPorPeriodo($token, $year,$month){

        $data = Http::withToken($token)->get(config('global.api_url').'/Especiales/getEspecialesPorPeriodo?year='.$year.'&month='.$month);
        //dd($data);
        return json_decode($data->body());
    }

    public static function getCtesActivosMes($token, $referencia,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getCtesActivosMes?referencia='.$referencia.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function GetZonasGerente($token, $user){
        $data = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetZonasGerente?user='.$user);
        return json_decode($data->body());
    }

    public static function getTotalVentasZona($token, $referencia,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getTotalVentasZona?zona='.$referencia.'&fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getHistoricoCobranzaZonaList($token,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getHistoricoCobranzaZonaList?fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getExistePeriodoEjercicio($token,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getExistePeriodoEjercicio?fecha='.$fecha);
        return json_decode($data->body());
    }

    public static function getCierreMesCobranzaZona($token,$fecha){
        $data = Http::withToken($token)->get(config('global.api_url').'/CobranzaZona/getCierreMesCobranzaZona?fecha='.$fecha);
        return json_decode($data->body());
    }


}

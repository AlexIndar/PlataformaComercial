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

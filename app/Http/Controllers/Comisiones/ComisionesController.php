<?php

namespace App\Http\Controllers\Comisiones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Customer\TokenController;

class ComisionesController extends Controller
{
    public static function getInfoCobranzaZonaWeb($token, $referencia){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/CobranzaZona/getInfoCobranzaZonaWeb?referencia='.$referencia);
        return json_decode($data->body());
    }
}

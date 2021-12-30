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


    public static function getZone($token, $user){
        $getZone = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getZone?userName='.$user);
        return $getZone;
    }

    public static function getTableView($token, $zone){
        $zDescription = $zone['description'];
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getTableView?zona='.$zDescription);
        return json_decode($solicitudes->body());
    }

    public static function getInfoSol($token, $folio){
        $solicitud = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getRequestDetail?fol='.$folio);
        return json_decode($solicitud->body());
    }
}

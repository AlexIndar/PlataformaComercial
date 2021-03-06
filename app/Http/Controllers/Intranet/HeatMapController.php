<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HeatMapController extends Controller
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

    public static function getItemSearchMap($token){
        $items = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetItemSearchMap');
        return json_decode($items->body());
    }

    public static function getListCustomer($token,$fechaIni, $fechaEnd, $gerencia, $zona, $idShippingWay){
        $customerList = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetListCustomer?fechaIni='.$fechaIni.'&fechaFin='.$fechaEnd.'&descGerencia='.$gerencia.'&descZona='.$zona.'&IdShippingWay='.$idShippingWay);
        return $customerList;
    }

    public static function repairReferences($token, $folioSol){
        $response = Http::withToken($token)->get(config('global.api_url').'/Cyc/RepairReferences?folioSol='.$folioSol);
        return $response;
    }
}

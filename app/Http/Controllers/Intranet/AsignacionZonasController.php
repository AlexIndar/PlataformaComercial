<?php

namespace App\Http\Controllers\Intranet;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsignacionZonasController extends Controller{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       
    }

    public static function getTemplate($token){
        $fileTemplate = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetTemplate');
        return $fileTemplate;        
    }

    public static function updateZonesCyc($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post(config('global.api_url').'/CyC/UpdateZonesCyc', [
            "id" => $json->Id,
            "description" => $json->Description
        ]);
        return $response;
    }

    public static function getExcelPrueba($token){
        $fileTemplate = Http::withToken($token)->get(config('global.api_url').'/Exporta/GetExcelPrueba');
        return $fileTemplate;        
    }
}

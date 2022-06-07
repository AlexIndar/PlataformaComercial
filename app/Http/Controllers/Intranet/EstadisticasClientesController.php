<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EstadisticasClientesController extends Controller
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

    public static function getEmployeeReport($token, $zone, $typeR, $ini, $fin){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetEmployeeReport?zona='.$zone.'&typeSol='.$typeR.'&ini='.$ini.'&end='.$fin);        
        return json_decode($solicitudes->body());
    }

    public static function getGeneralReport($token, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetGeneralReport?typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getGeneralReportByManagement($token, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetGeneralReportByManagement?typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getManagementReport($token, $idGerencia, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetManagementReport?id='.$idGerencia.'&typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getManagementReportByEmployee($token, $idGerencia, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetManagementReportByEmployee?id='.$idGerencia.'&typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getGerencia($token, $user){
        $gerencia = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetGerencia?username='.$user);
        return $gerencia;
    }
    
    public static function getTimeReport($token, $typeRequest, $ini, $end){
        $solicitudesTime = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetTimeReport?typeRequest='.$typeRequest.'&ini='.$ini.'&end='.$end);
        return $solicitudesTime;
    }
}

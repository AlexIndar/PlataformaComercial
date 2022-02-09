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
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetEmployeeReport?zona='.$zone.'&typeSol='.$typeR.'&ini='.$ini.'&end='.$fin);        
        return json_decode($solicitudes->body());
    }

    public static function getGeneralReport($token, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetGeneralReport?typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getGeneralReportByManagement($token, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetGeneralReportByManagement?typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getManagementReport($token, $idGerencia, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetManagementReport?id='.$idGerencia.'&typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }

    public static function getManagementReportByEmployee($token, $idGerencia, $typeS, $ini, $end){
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetManagementReportByEmployee?id='.$idGerencia.'&typeSol='.$typeS.'&ini='.$ini.'&end='.$end);        
        return json_decode($solicitudes->body());
    }
    
}

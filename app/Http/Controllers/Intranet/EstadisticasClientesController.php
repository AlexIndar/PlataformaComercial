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
}

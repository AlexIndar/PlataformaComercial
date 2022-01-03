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


    public static function getUser($token){
        $getUSer = Http::withToken($token)->get('http://192.168.70.107:64444/Login/getUserby?token='.$token);
        return $getUSer;
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

    public static function getStatus($id)
    {
        switch ($id) {
            case '1':
                $descripcion = 'Solicitud Guardada';
                break;
            case '2':
                $descripcion = 'Solicitud Guardada';
                break;
            case '3':
                $descripcion = 'Solicitud Guardada';
                break;
            case '4':
                $descripcion = 'Aceptada Contado';
                break;
            case '5':
                $descripcion = 'Solicitud Guardada';
                break;
            case '6':
                $descripcion = 'Aceptada Credito';
                break;
            case '7':
                $descripcion = 'Solicitud Guardada';
                break;
            case '8':
                $descripcion = 'Rechazada Credito (Aceptada Contado)';
                break;
            case '9':
                $descripcion = 'Solicitud Guardada';
                break;
            case '10':
                $descripcion = 'Solicitud Guardada';
                break;
            case '11':
                $descripcion = 'Solicitud Guardada';
                break;
            case '12':
                $descripcion = 'Solicitud Guardada';
                break;
            default:
                $descripcion = 'Sin estado';
        }
        return $descripcion;
    }
}

<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SolicitudesPendientesController extends Controller
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

    public static function getCobUsernames($token){
        $cobUsernames = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getCobUsernames');
        return json_decode($cobUsernames->body());
    }

    public static function getCustomerCatalogs($token){
        $customerCatalogs = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetCustomerCatalogs');        
        return json_decode($customerCatalogs->body());
    }

    public static function getCycTableView($token, $username){
        $solicitudes = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/getCYCTableView?username='.$username);
        return json_decode($solicitudes->body());
    }
}

<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Customer\TokenController;

class ClientesController extends Controller
{
    public static function getInfoEdoCtaWeb($token, $cliente){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/EstadoCuentaCte/getInfoEdoCtaWeb?cte='.$cliente);
        $data = json_decode($data);
        return json_decode(json_encode($data));
    }



}

<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Customer\TokenController;

class ClientesController extends Controller
{
    public static function getInfoEdoCtaWeb($token, $cliente){
        $data = Http::withToken($token)->get(config('global.api_url').'/EstadoCuentaCte/getInfoEdoCtaWeb?cte='.$cliente);
        $data = json_decode($data);
        return json_decode(json_encode($data));
    }

    public static function getFacturasCtesOpen($token, $cliente, $fechaini, $fechafin){
        $data = Http::withToken($token)->get(config('global.api_url').'/EstadoCuentaCte/getFacturasCtesOpen?cte='.$cliente.'&fechaini='.$fechaini.'&fechafin='.$fechafin);
        return json_decode($data->body());
    }

    public static function getNotasCreditoCtesOpen($token, $cliente){
        $dato = Http::withToken($token)->get(config('global.api_url').'/EstadoCuentaCte/getNotasCreditoCtesOpen?cte='.$cliente);
        return json_decode($dato->body());
    }


}

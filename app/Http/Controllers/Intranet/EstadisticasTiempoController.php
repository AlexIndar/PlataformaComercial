<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EstadisticasTiempoController extends Controller
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

    public static function getGerencia($token, $user){
        $gerencia = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetGerencia?username='.$user);
        return $gerencia;
    }
}

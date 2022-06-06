<?php

namespace App\Http\Controllers\Almacen;

use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AlmacenController extends Controller
{
    #region ALMACEN CONTROLLER
    #region CONSOLIDADO PANTALLA
    public static function consolidadoPantalla()
    {
        $consolidadoPantalla = Http::get(config('global.api_url').'/Almacen/ConsolidadoPantalla');
        $consolidado = json_decode($consolidadoPantalla->body());
        return $consolidado;
    }
    #endregion
    #endregion
}

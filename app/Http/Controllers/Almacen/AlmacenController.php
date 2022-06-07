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
    #region CAPTURA ERRORES
    public static function capturaErrores()
    {
        $capturaErrores = Http::get(config('global.api_url').'/Almacen/CapturaErrores');
        $errores = json_decode($capturaErrores->body());
        foreach($errores as $error)
        {
            $tipoError = $error->tipoError;
            $tipoError = $tipoError == "DaÃ±ado" ? "Dañado" : $tipoError;
            $error->tipoError = $tipoError;
        }
        return $errores;
    }
    public static function consultaCaptura()
    {
        $consultaCaptura = Http::get(config('global.api_url').'/Almacen/ConsultaCaptura');
        $consulta = json_decode($consultaCaptura->body());
        foreach($consulta as $consult)
        {
            $tipoError = $consult->tipoError;
            $tipoError = $tipoError == "DaÃ±ado" ? "Dañado" : $tipoError;
            $consult->tipoError = $tipoError;
        }
        return $consulta;
    }
    public static function createError($data)
    {
        $dataJson = json_decode($data);
        $createError = Http::post(config('global.api_url').'/Almacen/CreateError?articulo='.$dataJson->articulo.'&cantidad='.$dataJson->cantidad.'&pedido='.$dataJson->pedido.'&surtidor='.$dataJson->surtidor.'&tipoError='.$dataJson->tipoError.'&mesa='.$dataJson->mesa.'&usuario='.$dataJson->usuario);
        $error = json_decode($createError);
        return $error;
    }
    public static function updateError($data)
    {
        $dataJson = json_decode($data);
        $updateError = Http::post(config('global.api_url').'/Almacen/UpdateError',[
            "idError" => $dataJson->idError,
            "usuario" => $dataJson->user,
            "comentario" => $dataJson->comentario
        ]);
        $error = json_decode($updateError);
        return $error;
    }
    #endregion
    #endregion
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Customer\TokenController;
use App\Http\Controllers\LoginController;

 
class ValidateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = TokenController::getToken();
        $permissions = LoginController::getPermissions($token);

        $permissionNeeded = '';

        $url = strtolower($request->Url());

        if(strpos($url, "comisionesvendedor") !== false){
            $permissionNeeded = 'Comisiones';
        }
        if(strpos($url, "comisionesespeciales") !== false){
            $permissionNeeded = 'CargarEspeciales';
        }
        if(strpos($url, "comisionesresumen") !== false){
            $permissionNeeded = 'ComisionesResumen';
        }
        if(strpos($url, "pedido") !== false){
            $permissionNeeded = 'Pedidos';
        }
        if(strpos($url, "promociones") !== false){
            $permissionNeeded = 'Promociones';
        }
        if(strpos($url, "missolicitudes") !== false){
            $permissionNeeded = 'MisSolicitudes';
        }
        if(strpos($url, "estadistica") !== false){
            $permissionNeeded = 'Estadistica Cliente';
        }
        if(strpos($url, "pendiente") !== false){
            $permissionNeeded = 'SolicitudesPendientes';
        }
        

        // A intranet sí deja entrar a todos, siempre y cuando tengan un token activo
        if(isset($_COOKIE["_lt"]) && strpos($url, "intranet") !== false){
            return $this->nocache($next($request));
        }

        // Si la ruta no es intranet, validar que sea una ruta permitida
        if(isset($_COOKIE["_lt"]) && in_array($permissionNeeded, $permissions)){
            return $this->nocache($next($request));
        }
        else{
            return redirect('/Intranet');
        }
    }
 


    protected function nocache($response)
    {
        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        $response->headers->set('Pragma','no-cache');

        return $response;
    }

}

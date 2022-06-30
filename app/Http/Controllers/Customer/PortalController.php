<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;

class PortalController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    } 

    public static function busquedaGeneralItem($token, $filter){
        $response = Http::withToken($token)->post(config('global.api_url').'/Portal/BusquedaGeneralItem', [
            "busqueda" => $filter
        ]);
        $data = $response->body();
        return json_decode($data);
    }

    public static function busquedaItemFiltro($token, $filter, $codigo, $from, $to){
        $response = Http::withToken($token)->post(config('global.api_url').'/Portal/BusquedaItemFiltro', [
            "codCustomer" => $codigo,
            "busqueda" => $filter
        ]);
        $items = $response->body();
        $items = json_decode($items);
        $marcas = [];
        for($x = 0; $x < count($items); $x++){
            if($x == 0){
                array_push($marcas, $items[$x]->familia);
            }
            else{
                if(in_array($items[$x]->familia, $marcas)){
                    
                }
                else{
                    array_push($marcas, $items[$x]->familia);
                }
            }
        }   

        $data['items'] = [];
        $data['marcas'] = [];
        $data['resultados'] = count($items);
        foreach($marcas as $marca){
            $count = 0;
            foreach($items as $item){
                if($item->familia == $marca){
                    $count ++;
                }
            }
            $tmp['nombre'] = $marca;
            $tmp['resultados'] = $count;
            array_push($data['marcas'], $tmp);
        }

        // Si quiere llegar a una paginación más alta de los resultados disponibles, limitar a la cantidad de resultados
        $to > count($items) ? $to = count($items) : $to = $to;

        for($x = $from - 1; $x < $to; $x++){
            array_push($data['items'], $items[$x]);
        }

        // dd($items);

        return $data;
    }

    
}

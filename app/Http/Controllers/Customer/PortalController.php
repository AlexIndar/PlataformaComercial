<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;
use stdClass;

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

    // Retorna filtrado de busqueda, si se indican límites from y to devuelve solo la info encontrada en ese rango de índices
    public static function busquedaItemFiltro($token, $filter, $codigo, $directo = false, $from = null, $to = null){ 
        if($directo)
            $filter = str_replace('_', '~', $filter);
        else
            $filter = str_replace('-', '~', $filter);
        $response = Http::withToken($token)->post(config('global.api_url').'/Portal/BusquedaItemFiltro', [
            "codCustomer" => $codigo,
            "busqueda" => $filter,
            "directo" => $directo
        ]);

        $items = $response->body();

        if($directo){
            $items = json_decode($items, true);

            if(count($items)>0){
                return $items[0];
            }
            else{
                $items = new stdClass();
                $items->error = 'No se encontró el artículo buscado';
                return $items;
            }
        }
        $items = json_decode($items);
        $data = PortalController::getFiltersBusqueda($items);

        if($from == null){
            $data['items'] = $items;
        }
        else{
            $data['items'] = [];
        
            // Si quiere llegar a una paginación más alta de los resultados disponibles, limitar a la cantidad de resultados encontrados
            $to > count($items) ? $to = count($items) : $to = $to;
    
            for($x = $from - 1; $x < $to; $x++){
                array_push($data['items'], $items[$x]);
            }
        }
        return $data;
    }

    // Acomoda información para los filtros de búsqueda del lateral izquierdo de la vista
    public static function getFiltersBusqueda($items){
        $marcas = [];
        $categorias = [];
        for($x = 0; $x < count($items); $x++){
            if($x == 0){
                array_push($marcas, $items[$x]->familia);
                array_push($categorias, $items[$x]->categoriaItem);
            }
            else{
                if(!in_array($items[$x]->familia, $marcas)){
                    array_push($marcas, $items[$x]->familia);   
                }
                if(!in_array($items[$x]->categoriaItem, $categorias)){
                    array_push($categorias, $items[$x]->categoriaItem);   
                }
            }
        }   
        $data['marcas'] = [];
        $data['categorias'] = [];
        $data['competitividad'] = [];
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

        foreach($categorias as $categoria){
            $count = 0;
            foreach($items as $item){
                if($item->categoriaItem == $categoria){
                    $count ++;
                }
            }
            $tmp['nombre'] = $categoria;
            $tmp['resultados'] = $count;
            array_push($data['categorias'], $tmp);
        }

        $count = 0;
        foreach($items as $item){
            if($item->competitividad == "true"){
                $count ++;
            }
        }
        $tmp['nombre'] = "Mejor Precio Indar";
        $tmp['resultados'] = $count;
        array_push($data['competitividad'], $tmp);

        return $data;

    }

    
}

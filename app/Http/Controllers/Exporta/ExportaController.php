<?php

namespace App\Http\Controllers\Exporta;

use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Customer\TokenController;

class ExportaController extends Controller
{
    public static function precios($token)
    {
        ini_set('memory_limit','-1');
        $precios = Http::withToken($token)->get(config('global.api_url').'/Exporta/GetItems');
        $preciosExporta = json_decode($precios->body());
        $arrayPrecios = array();
        foreach($preciosExporta as $pre)
        {
            $descuento = 0;
            $promo = $pre->promoART;
            if(!empty($promo))
            {
                $descuento = $promo[0]->descuento;
            }
            array_push($arrayPrecios,[
                'claveFabricante' => $pre->clavefabricante,
                'articulo' => $pre->itemid,
                'descripcion' => $pre->purchasedescription,
                'precio' => $pre->priceLista,
                'moneda' => 'Pesos',
                'promocion' => $descuento,
                'unidad' => $pre->unidad,
                'existencias' => $pre->disponible,
                'categoria' => $pre->categoriaItem,
                'multiplo' => $pre->multiploVenta,
                'iva' => '16',
                'proveedor' => $pre->clavefabricante,
                'familia' => $pre->familia,
                'empaque' => $pre->master,
                'precio7' => $pre->price7,
                'precio8' => $pre->price8,
                'precio10' => $pre->price10,
                'precio2' => $pre->price2,
                'precio3' => $pre->price3,
                'precio4' => $pre->price4
            ]);
        }
        return $arrayPrecios;
    }
}

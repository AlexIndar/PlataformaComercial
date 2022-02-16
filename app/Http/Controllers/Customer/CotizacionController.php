<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;

class CotizacionController extends Controller
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

    public static function getCotizaciones($token, $entity){
        $getCotizaciones = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoCotizacionWeb?entity='.$entity);
        $cotizaciones = json_decode($getCotizaciones->body());
        return $cotizaciones;
    } 

    public static function getCotizacionIdWeb($token, $id){
        $getCotizacion = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoCotizacionIdWeb?id='.$id);
        $cotizacion = json_decode($getCotizacion->body());
        return $cotizacion;
    }

    public static function storePedido($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Cotizacion/CotizacionInsertLWS', [
            "idCotizacion" => 0,
            "companyId" => $json->companyId,
            "orderC" => $json->orderC,
            "email" => $json->email,
            "addressId" => $json->addressId,
            "shippingWay" => $json->shippingWay,
            "packageDelivery" => $json->packageDelivery,
            "divide" => $json->divide,
            "pickUp" => $json->pickUp,
            "order" => $json->order,
            "comments" => $json->comments,
            "enviado" => $json->enviado
        ]);
        return $response;
    }

    public static function updatePedido($token, $data){
        $json = json_decode($data);
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Cotizacion/CotizacionInsertLWS', [
            "idCotizacion" => $json->idCotizacion,
            "companyId" => $json->companyId,
            "orderC" => $json->orderC,
            "email" => $json->email,
            "addressId" => $json->addressId,
            "shippingWay" => $json->shippingWay,
            "packageDelivery" => $json->packageDelivery,
            "divide" => $json->divide,
            "pickUp" => $json->pickUp,
            "order" => $json->order,
            "comments" => $json->comments,
            "enviado" => $json->enviado
        ]);
        return $response;
    }

    public static function deletePedido($token, $id){
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Cotizacion/getBorrarCotizacionIdWeb?Id='.$id);
        $cotizacion = json_decode($response->body());
        return $cotizacion;
    }

    public static function forzarPedido($token, $cotizacion, $idCotizacion, $index, $cantidad){
        date_default_timezone_set('America/Mexico_City');
        $date = date('d/m/y');
        $date = explode('/', $date);
        $date = $date[0]."/".$date[1]."/20".$date[2];

        $billingAddress['id'] = 'XXXXXX';
        $shippingAddress['id'] = $cotizacion->addressId;
        $typeOrder['id'] = '1';
        $typeOrder['txt'] = "";

        $lineItems = [];
        for($x = 0; $x < count($cotizacion->order[$index-1]->items); $x++){
            $temp['itemid'] = $cotizacion->order[$index-1]->items[$x]->itemid;
            $temp['quantity'] = $cotizacion->order[$index-1]->items[$x]->cantidad;
            $temp['listprice'] = "FALTA";
            array_push($lineItems, $temp);
        }

        $shippingWay['id'] = $cotizacion->shippingWay;
        $shippingWay['txt'] = "";
        $package['id'] = $cotizacion->packageDelivery;
        $package['txt'] = "";
        $typeSale['id'] = $cotizacion->order[$index-1]->tipo == 'BO' ? '6' : '5';
        $typeSale['txt'] = "";
        
        $username = $_COOKIE["username"];

        $methodPayment['id'] = "10";
        $methodPayment['txt'] = "";
        $events['id'] = "0";
        $events['txt'] = "FALTA";
        $plazoEvento['id'] = "0";
        $plazoEvento['txt'] = $cotizacion->order[$index-1]->plazo;

        $json['internalId'] = 0;
        $json['idCustomer'] = 'FALTA';
        $json['date'] = $date;
        $json['location'] = $cotizacion->order[$index-1]->marca == 'OUTLET' ? '36' : '1';
        $json['billingAddress'] = $billingAddress;
        $json['shippingAddress'] = $shippingAddress;
        $json['typeOrder'] = $typeOrder;
        $json['idWeb'] = $idCotizacion.'-'.$index.'/'.$cantidad;
        $json['noCotizacion'] = $idCotizacion;
        $json['lineItems'] = $lineItems;
        $json['shippingWay'] = $shippingWay;
        $json['package'] = $package;
        $json['typeSale'] = $typeSale;
        $json['user'] = $username;
        $json['methodPayment'] = $methodPayment;
        $json['useCFDI'] = null;
        $json['comments'] = $cotizacion->comments;
        $json['events'] = $events;
        $json['plazoEvento'] = $plazoEvento;
        $json['eventSpecialDiscount'] = "FALTA";
        $json['customerDiscountPP'] = intval($cotizacion->order[$index-1]->descuento);
        $json['discountSpecial'] = "FALTA";
        $json['specialAuthorization'] = "FALTA";
        $json['numPurchase'] = $cotizacion->orderC;
        $json['desneg'] = "FALTA";
        $json['desgar'] = "FALTA";


        
        dd($json);
    }

}

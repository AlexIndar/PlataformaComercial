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

    public static function getCotizacionesByUser($token, $entity){
        $getCotizaciones = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoUsuarioCotizacionWeb?entity='.$entity);
        $cotizaciones = json_decode($getCotizaciones->body());
        return $cotizaciones;
    } 

    public static function getCotizacionIdWeb($token, $id){
        $getCotizacion = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoCotizacionIdWeb?id='.$id);
        $cotizacion = json_decode($getCotizacion->body());
        return $cotizacion;
    }

    public static function storePedido($token, $data){
        date_default_timezone_set('America/Mexico_City');
        $json = json_decode($data);
        $dateTime = date("Y-m-d H:i:s");
        $dateTime = str_replace(" ", "T", $dateTime);
        $username = $_COOKIE['username'];
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
            "enviado" => $json->enviado,
            "usuario" => $username,
            "fecha" => $dateTime,
        ]);
        return $response;
    }

    public static function deletePedido($token, $id){
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/Cotizacion/getBorrarCotizacionIdWeb?Id='.$id);
        $cotizacion = json_decode($response->body());
        return $cotizacion;     
    }

    public static function getZonasApoyo($token, $username){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/Cotizacion/getInfoZonasCotizacionIdWeb?usuario='.$username);
        $zonas = json_decode($response->body());
        return $zonas;     
    }

    public static function forzarPedido($token, $cotizacion, $idCotizacion, $index, $cantidad){
        $infoCustomer = Http::withToken($token)->get('http://192.168.70.107:64444/SaleOrder/getInfoHeatWeb?entity='.strtoupper($cotizacion->companyId));
        $customerHeat = json_decode($infoCustomer->body());
        date_default_timezone_set('America/Mexico_City');
        $date = date('d/m/y');
        $date = explode('/', $date);
        $date = $date[0]."/".$date[1]."/20".$date[2];

        $billingAddress['id'] = 'XXXXXX'; //se llena en el back
        $shippingAddress['id'] = $cotizacion->addressId;
        $typeOrder['id'] = '1';
        $typeOrder['txt'] = "";

        $desneg = 0;
        $desgar = 0;
        $descuento = intval($cotizacion->order[$index-1]->descuento);
        $specialAuthorization = "";

        $lineItems = [];
        for($x = 0; $x < count($cotizacion->order[$index-1]->items); $x++){
            $temp['itemid'] = $cotizacion->order[$index-1]->items[$x]->itemid;
            $temp['quantity'] = $cotizacion->order[$index-1]->items[$x]->cantidad;
            $temp['listprice'] = $customerHeat[0]->priceList;
            array_push($lineItems, $temp);
            if($cotizacion->order[$index-1]->items[$x]->desneg != 0){
                $desneg = $cotizacion->order[$index-1]->items[$x]->desneg;
                $specialAuthorization = $cotizacion->order[$index-1]->items[$x]->autorizaDesneg;
            }
            if($cotizacion->order[$index-1]->items[$x]->desgar != 0){
                $desgar = $cotizacion->order[$index-1]->items[$x]->desgar;
                $specialAuthorization = $cotizacion->order[$index-1]->items[$x]->autorizaDesgar;
            }
        }

        $shippingWay['id'] = 0;
        $shippingWay['txt'] = $cotizacion->shippingWay;
        $package['id'] = 0;
        $package['txt'] = $cotizacion->packageDelivery;
        $typeSale['id'] = $cotizacion->order[$index-1]->tipo == 'BO' ? '6' : '5';
        $typeSale['txt'] = "";
        
        $username = $_COOKIE['username'];

        $methodPayment['id'] = "10";
        $methodPayment['txt'] = "";
        $events['id'] = "0";
        $events['txt'] = $cotizacion->order[$index-1]->evento == null ? "" : $cotizacion->order[$index-1]->evento;
        $plazoEvento['id'] = "0";
        $plazoEvento['txt'] = $cotizacion->order[$index-1]->plazo;

        $listNS = [];
       

        $json['internalId'] = 0;
        $json['idCustomer'] = $customerHeat[0]->internalID;
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
        $json['comments'] = $cotizacion->comments == null ? "" : $cotizacion->comments;
        $json['events'] = $events;
        $json['plazoEvento'] = $plazoEvento;
        $json['eventSpecialDiscount'] = $desneg != 0 ? $descuento - $desneg : $descuento - $desgar;
        $json['customerDiscountPP'] = $descuento;
        $json['discountSpecial'] = $desneg != 0 ? $desneg : $desgar;
        $json['specialAuthorization'] = $specialAuthorization;
        $json['numPurchase'] = $cotizacion->orderC == null ? "" : $cotizacion->orderC;
        $json['desneg'] = $desneg != 0 ? 1 : 0;
        $json['desgar'] = $desgar != 0 ? 1 : 0;

        array_push($listNS, $json);
        $storeNS = Http::withToken($token)->post('http://192.168.70.107:64444/SaleOrder/EnviarPedidosNetsuite', [
            "prePedido" => $listNS
        ]);
        $response = json_decode($storeNS->body());
        return $response;
    }

}

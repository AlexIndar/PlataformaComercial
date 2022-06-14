<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use Config;

class SaleOrdersController extends Controller
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

    public static function getSaleOrders($token, $customer){
        $getOrders = Http::withToken($token)->get(config('global.api_url').'/SaleOrder/getOrders?customerID='.$customer);
        $saleOrders = json_decode($getOrders->body());
        return $saleOrders;
    } 

    public static function descargarDocumento($token, $info){
        $factura = $info->numFactura;
        $type = $info->type;
        $getUrl = Http::withToken($token)->get(config('global.api_url').'/EstadoCuentaCte/getDocumentCFDI?type=CustInvc&folio='.$factura.'&formato='.$type);
        $url = $getUrl->body();
        return $url;
    }

    public static function getInfoHeatWeb($token, $entity){
        $entity = strtoupper($entity);
        $response = Http::withToken($token)->get(config('global.api_url').'/SaleOrder/getInfoHeatWeb?entity='.$entity);
        $info = json_decode($response->body());
        $data = [];
        $shippingWays = [];
        $packageDeliveries = [];
        $addresses = [];
        $cont = 0;
        $insertShipmentInfo = 0;
        for($x = 0; $x < count($info); $x++){
            $insert = false;
            if(count($data)==0){
                $temp = array (
                    "internalID"=>$info[$x]->internalID,
                    "companyId"=>$info[$x]->companyId,
                    "company"=>$info[$x]->company,
                    "shippingWays"=> [],
                    "packageDeliveries"=> [],
                    "addresses"=> [],
                    "priceList"=>$info[$x]->priceList,
                    "email"=>$info[$x]->email,
                    "shippingWayF"=>$info[$x]->shippingWayF,
                    "packgeDeliveryF"=>$info[$x]->packgeDeliveryF,
                    "category"=>$info[$x]->category,
                    "zona"=>$info[$x]->zona
                );
                array_push($data, $temp);
            }
            else if($data[count($data)-1]['internalID'] != $info[$x]->internalID){
                $insert = true;
            }
            if($insert){
                $data[$insertShipmentInfo]["shippingWays"] = $shippingWays;
                $data[$insertShipmentInfo]["packageDeliveries"] = $packageDeliveries;
                $data[$insertShipmentInfo]["addresses"] = $addresses;

                $shippingWays = [];
                $packageDeliveries = [];
                $addresses = [];

                $temp = array (
                    "internalID"=>$info[$x]->internalID,
                    "companyId"=>$info[$x]->companyId,
                    "company"=>$info[$x]->company,
                    "shippingWays"=> [],
                    "packageDeliveries"=> [],
                    "addresses"=> [],
                    "priceList"=>$info[$x]->priceList,
                    "email"=>$info[$x]->email,
                    "shippingWayF"=>$info[$x]->shippingWayF,
                    "packgeDeliveryF"=>$info[$x]->packgeDeliveryF,
                    "category"=>$info[$x]->category,
                    "zona"=>$info[$x]->zona
                );
                array_push($data, $temp);
                array_push($shippingWays, $info[$x]->shippingWay);
                array_push($packageDeliveries, $info[$x]->packageDelivery);
                $temp_address = array(
                    "addressID" => $info[$x]->addressID,
                    "address" => $info[$x]->address,
                    "defaultBilling" => $info[$x]->defaultbilling,
                    "defaultShipping" => $info[$x]->defaultshipping,
                );
                array_push($addresses, $temp_address);
                $insertShipmentInfo = count($data)-1;
            }
            else{ 
                array_push($shippingWays, $info[$x]->shippingWay);
                array_push($packageDeliveries, $info[$x]->packageDelivery);
                $temp_address = array(
                    "addressID" => $info[$x]->addressID, 
                    "address" => $info[$x]->address,
                    "defaultBilling" => $info[$x]->defaultbilling,
                    "defaultShipping" => $info[$x]->defaultshipping,
                );
                array_push($addresses, $temp_address);
            }

            if($x+1 == count($info)){
                $data[$insertShipmentInfo]["shippingWays"] = $shippingWays;
                $data[$insertShipmentInfo]["packageDeliveries"] = $packageDeliveries;
                $data[$insertShipmentInfo]["addresses"] = $addresses;
            }
            
        }

        return $data;
    }

    public static function getItems($token, $entity){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/getItems', [
            "codCustomer" => $entity,
        ]);
        $info = json_decode($response->body());
        return $info;
    } 

    public static function getListaEmailPedido($token, $cliente){
        $response = Http::withToken($token)->get(config('global.api_url').'/SaleOrder/ListaEmailPedido?cliente='.$cliente);
        $info = json_decode($response->body());
        return $info;
    } 

    public static function getEventosCliente($token, $entity){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/EventosParaCliente?cliente='.$entity);
        $info = json_decode($response->body());
        return $info;
    } 

    public static function getItemByID($token, $id, $entity){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/getItemByID', [
            "itemID" => $id,
            "codCustomer" => $entity,
        ]);
        $info = json_decode($response->body());
        return $info;
    } 

    public static function separarPedidosPromo($token, $json){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/SeparaPedidosPromo', [
            "articulos" => json_decode($json)
        ]);
        $info = json_decode($response->body());
        return $info;
    }

    public static function separarPedidosPaquete($token, $json){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/SeparaPedidosPAQUETE', [
            "articulos" => json_decode($json)
        ]);
        $info = json_decode($response->body());
        return $info;
    }

    public static function regresaEstadoPedido($token, $id){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/RegresaEstadoPedido?Id='.$id);
        $info = json_decode($response->body());
        return $info;
    }
 
    public static function storePedidoNS($token, $data, $username){
        foreach($data as $partida){
            $partida['user'] = $username;
        }
        $storeNS = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/EnviarPedidosNetsuite', [
            "prePedido" => $data  
        ]);
        $response = json_decode($storeNS->body());
        return $response;
    }

    public static function getDetalleFacturado($token, $id){
        $response = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/SaleOrderDetalleFacturado?factura='.$id);
        $info = json_decode($response->body());
        return $info;
    }

    public static function getformaEnvioFletera($token){
        $getShippingWays = Http::withToken($token)->get(config('global.api_url').'/SaleOrder/formaEnvioFletera');
        $shippingWays = json_decode($getShippingWays->body());
        return $shippingWays;
    } 

    public static function getPedidosPendientesCTE($token){
        $getPedidosPendientesCTE = Http::withToken($token)->get(config('global.api_url').'/SaleOrder/PedidosPendientesCTE');
        $pedidosPendientes = json_decode($getPedidosPendientesCTE->body());
        return $pedidosPendientes;
    } 

    public static function forzarPedido($token, $cotizacion, $idCotizacion, $index, $cantidad, $username){
        $infoCustomer = Http::withToken($token)->get(config('global.api_url').'/SaleOrder/getInfoHeatWeb?entity='.strtoupper($cotizacion->companyId));
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
        
        $username = $username;

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

        $storeNS = Http::withToken($token)->post(config('global.api_url').'/SaleOrder/EnviarPedidosNetsuite', [
            "prePedido" => $listNS
        ]); 
        $response = json_decode($storeNS->body());
        $data = json_decode('{"response": '.$storeNS->body().', "peticion": '.json_encode($listNS).' }');
        return $data;
    }


}

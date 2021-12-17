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
        $getOrders = Http::withToken($token)->get('http://192.168.70.107:64444/SaleOrder/getOrders?customerID='.$customer);
        $saleOrders = json_decode($getOrders->body());
        return $saleOrders;
    } 

    public static function getInfoHeatWeb($token, $entity){
        $response = Http::withToken($token)->get('http://192.168.70.107:64444/SaleOrder/getInfoHeatWeb?entity='.$entity);
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
                );
                array_push($data, $temp);
                array_push($shippingWays, $info[$x]->shippingWay);
                array_push($packageDeliveries, $info[$x]->packageDelivery);
                $temp_address = array(
                    "addressID" => $info[$x]->addressID,
                    "address" => $info[$x]->address,
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
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/SaleOrder/getItems', [
            "codCustomer" => $entity,
        ]);
        $info = json_decode($response->body());
        return $info;
    } 

    public static function getItemByID($token, $id, $entity){
        $response = Http::withToken($token)->post('http://192.168.70.107:64444/SaleOrder/getItemByID', [
            "itemID" => $id,
            "codCustomer" => $entity,
        ]);
        $info = json_decode($response->body());
        return $info;
    } 

}
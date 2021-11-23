<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;


class ItemsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       
    }


    public static function getBestSellers($token){
        $getProducts = Http::withToken($token)->post('http://192.168.70.107:64444/item/GetItemsWhere', [
            "columns" => "isinactive",
            "values" => "false"
        ]);

        $bestSellers = json_decode($getProducts->body());

        foreach($bestSellers as $item){
            $item->itemid = strtr($item->itemid, " ", "_");
            // dd($item);
        }

        return $bestSellers;
    } 


    public static function getProduct($id, $token){
        $id = strtr($id, "_", " ");
        $getProduct = Http::withToken($token)->post('http://192.168.70.107:64444/item/GetItemsWhere', [
            "columns" => "itemid",
            "values" => $id
        ]);

        $item = json_decode($getProduct->body());
        dd($item);
        foreach($bestSellers as $item){
            $item->itemid = strtr($item->itemid, " ", "_");
            // dd($item);
        }
        $token = TokenController::getToken();
        return view('customers.detallesProducto', ['id' => $id, 'token' => $token]);
    }
    
}

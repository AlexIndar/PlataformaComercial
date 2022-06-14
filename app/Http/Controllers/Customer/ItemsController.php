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
        $getProducts = Http::withToken($token)->post(config('global.api_url').'/item/GetItemsWhere', [
            "columns" => "fabricanteArticulo",
            "values" => "34"
        ]);

        $bestSellers = json_decode($getProducts->body());
        
        if(isset($bestSellers['errors'])){
            return view('errors.500');
        }

        foreach($bestSellers as $item){
            $item->itemid = strtr($item->itemid, " ", "_");
        }
        return $bestSellers;
    } 


    public static function getProduct($id, $token){
        $id = strtr($id, "_", " ");
        dd($id);
        $getProduct = Http::withToken($token)->post(config('global.api_url').'/item/GetItemsWhere', [
            "columns" => "itemid",
            "values" => $id
        ]);

        $item = json_decode($getProduct->body());
        dd($item);
        $token = TokenController::getToken();
        return view('customers.detallesProducto', ['id' => $id, 'token' => $token]);
    }
    
}

<?php

namespace App\Http\Controllers\Sai;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Customer\TokenController;

class AplicarPagoController extends Controller
{
    public static function getZonas($token){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetRegresaZonas?token='.$token);
        return $data->body();
    }

    public function getCargaListaClientes($token){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/PaymentInvoiceApply/GetCargaListaClientes?token='.$token);
        return $data->body();
        # code...
    }

    public static function getRegresaPrimerosDatos($token, $id){

        $getProduct = Http::withToken($token)->post('http://192.168.70.107:64444/PaymentInvoiceApply/GetRegresaPortafolio', [
            "idZona" => $id
        ]);

        $item = json_decode($getProduct->body());
        /* foreach($bestSellers as $item){
            $item->itemid = strtr($item->itemid, " ", "_");
            // dd($item);
        } */
        $token = TokenController::getToken();
        return view('customers.detallesProducto', ['id' => $id, 'token' => $token]);

    }

    public function getLlenaEmpleados($token){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetllenaEmpleados?token='.$token);
        return $data->body();
    }
}

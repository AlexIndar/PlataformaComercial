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
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/PaymentInvoiceApply/GetRegresaPortafolio?idZona='.$id);
        return json_decode($data->body());
    }

    public function getLlenaEmpleados($token){
        $data = Http::withToken($token)->get('http://192.168.70.107:64444/Cyc/GetllenaEmpleados?token='.$token);
        return $data->body();
    }
}

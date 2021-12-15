<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;

class TokenController extends Controller
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

    public static function getToken(){
        $token = "";
        if(isset($_COOKIE["laravel-token"]) && $_COOKIE["laravel-token"] != 'error'){ 
            $token = decrypt($_COOKIE["laravel-token"], "7Ind4r7");
        }
        else if(isset($_COOKIE["refresh"])){
            $token = TokenController::refreshToken();
        }
        return $token;
    }

    public static function refreshToken(){
        $old = decrypt($_COOKIE["refresh"], "7Ind4r7Refresh");
        $response = Http::withToken($old)->post('http://192.168.70.107:64444/login/RefreshToken');
        $token = "";
        if($response->getStatusCode() == 200){ 
                $token = $response->body();
                setcookie("laravel-token", encrypt($token, "7Ind4r7"), time()+900);
                setcookie("refresh", encrypt($token, "7Ind4r7Refresh"), time()+ 60 * 480);
        }
        return $token;
    }

    public function encrypt($token, $key){
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        $options = 0;
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
        // Store the encryption key
        $encryption_key = $key;
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($token, $ciphering,$encryption_key, $options, $encryption_iv);
        return $encryption;
    }

    public function decrypt($encrypt, $key){
         // Store the cipher method
         $ciphering = "AES-128-CTR";
        $options = 0;
        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';
        // Store the decryption key
        $decryption_key = $key;
        // Use openssl_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($encrypt, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }
}

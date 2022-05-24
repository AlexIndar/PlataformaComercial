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
        if(isset($_COOKIE["_lt"]) && $_COOKIE["_lt"] != 'error'){
            $token = decrypt($_COOKIE["_lt"], "7Ind4r7");
        }
        else if(isset($_COOKIE["_rfs"])){
            $token = TokenController::refreshToken();
        }
        return $token;
    }

    public static function refreshToken(){
        if(!isset($_COOKIE['_usn'])){
            setcookie("_lt", "", time()-60*60*24, '/');
            setcookie("_rfs", "", time()- 60*60*24, '/');
            setcookie("_usn", "", time()- 60*60*24, '/');
            setcookie("_lv", "", time()- 60*60*24, '/');
            return redirect('/');
        }
        if(isset($_COOKIE["_rfs"])){
            $old = $_COOKIE["_rfs"];
            $username = $_COOKIE["_usn"];
            $typeUser = Http::withToken($old)->get('http://192.168.70.107:64444/login/getListMenu?user='.$username);
            dd($typeUser->body());
            $permissions = (json_decode(json_decode($typeUser->body())->permissions));
            $response = Http::withToken($old)->post('http://192.168.70.107:64444/Login/RefreshToken');
            if($response->getStatusCode() == 200){
                    $token = $response->body();
                    setcookie("_lt", "", time()-60*60*24, '/');
                    setcookie("_lt", encrypt($token, "7Ind4r7"), time()+60*60*24, '/');
                    setcookie("_rfs", "", time()- 60*60*24, '/');
                    setcookie("_rfs", $token, time()+ 60*60*24, '/');
                    setcookie('_usn', "", time()-60*60*24*30, '/');
                    setcookie('_usn', $username, time()+60*60*24*30, '/');
                    return $token;
            }
            else{
                return "error";
            }
        }
        else{
            return "";
        }

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

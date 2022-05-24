<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
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
<<<<<<< HEAD
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
=======
        if(isset($_COOKIE["_lt"]) && $_COOKIE["_lt"] != 'error' && $_COOKIE["_lt"] != 'expired'){
            $username = decrypt($_COOKIE["_usn"], "7Ind4r7");
            try{ //cuando token es error o expired lanza excepción porque no puede hacer decrypt de un string que no está encriptado
                $token = decrypt($_COOKIE["_lt"], "7Ind4r7"); 
>>>>>>> 3a78a8cb997effe5e395bf1af76583a6c90ac244
            }
            catch (DecryptException $e) {
                $token = "expired";
            }
            $typeUser = Http::withToken($token)->get('http://192.168.70.107:64444/login/getListMenu?user='.$username); //ejecutar y ver si responde Unauthoraized 
            if($typeUser->getStatusCode() == 401){//si responde error 401 Unauthorized, entonces el token no es válido
                $token = "expired";
                setcookie("_lt", "", time()-60*60*24, '/');
                setcookie("_lt", "expired", time()+900, '/');
                setcookie("_ep", time(), time()+60*60*24*365, '/');
            }
            
        }
        else{
            setcookie("_ep", time(), time()+60*60*24*365, '/');
            $token = "expired";
        }
<<<<<<< HEAD

=======
        return $token; 
>>>>>>> 3a78a8cb997effe5e395bf1af76583a6c90ac244
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

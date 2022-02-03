<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Config;


class LoginController extends Controller
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

    public function authenticate(Request $request){
        $username = explode('@', $request->email)[0];
        $password = $request->password;

        $response = Http::post('http://192.168.70.107:64444/login/authenticate', [
            'username' => $username,
            'password' => $password
        ]);


        if($response->getStatusCode() == 200){ 
                $token = $response->body();
                $typeUser = Http::withToken($token)->get('http://192.168.70.107:64444/login/getListMenu?user='.$username);
                $permissions = (json_decode(json_decode($typeUser->body())->permissions));
                if(json_decode($typeUser->body())->typeUser == "C"){
                    setcookie("laravel-token", encrypt($token, "7Ind4r7"), time()+3600, '/');
                    setcookie("refresh", $token, time()+3600, '/');
                    setcookie("level", "C", time()+3600, '/');
                    setcookie('access', json_encode($permissions), time()+3600);
                    return redirect('/');
                }
                else  if(json_decode($typeUser->body())->typeUser == "E"){
                    setcookie("laravel-token", encrypt($token, "7Ind4r7"), time()+3600, '/');
                    setcookie("refresh", $token, time()+3600, '/');
                    setcookie("level", "E", time()+3600, '/');
                    setcookie('access', json_encode($permissions), time()+3600);
                    return redirect('/Intranet');
                }
                
                
        } 
        else{
            setcookie("laravel-token", "error", time()+900, '/');
            return redirect('/');
        }
    }

    public function logout(){
        setcookie("laravel-token", "", time()-3600, '/');
        setcookie("level", "", time()- 60 * 480, '/');
        setcookie("refresh", "", time()- 60 * 480, '/');
        return redirect('/');
    }

    public static function getPermissions(){
        $permissions = json_decode($_COOKIE["access"]);
        return $permissions;
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

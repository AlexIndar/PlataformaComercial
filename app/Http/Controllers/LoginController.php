<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Config;
use Illuminate\Support\Facades\Artisan;


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


        $response = Http::post(config('global.api_url').'/login/authenticate', [
            'username' => $username,
            'password' => $password
        ]);

        // NOMBRES DE COOKIES 

        /*
        
        _lt     -       token api back
        _fln    -       full name logged user
        _usn    -       username
        _lv     -       user level (C - Customer : E - Employee)
        _la     -       last authenticated time 
        _ep     -       expired (used to know if a token has been requested)
        
        */


        if($response->getStatusCode() == 200){ 
                setcookie("_la", time(), time()+60*60*24*365, '/');
                $token = $response->body();
                $typeUser = Http::withToken($token)->get(config('global.api_url').'/login/getListMenu?user='.$username);
                $permissions = (json_decode(json_decode($typeUser->body())->permissions));
                $fullname = (json_decode($typeUser->body())->name);
                setcookie("_lt", encrypt($token, "7Ind4r7"), time()+60*60*24, '/');
                setcookie("_fln", encrypt($fullname, "7Ind4r7"), time()+60*60*24, '/');
                setcookie("_usn", encrypt($username, "7Ind4r7"), time()+60*60*24, '/');
                if(json_decode($typeUser->body())->typeUser == "C"){
                    setcookie("_lv", "C", time()+60*60*24, '/');
                    return redirect('/');
                }
                else  if(json_decode($typeUser->body())->typeUser == "E"){
                    setcookie("_lv", "E", time()+60*60*24, '/');
                    return redirect('/Intranet');
                }
        } 
        else{
            setcookie("_lt", "error", time()+900, '/');
            return redirect('/'); 
        }
    }

    public function logout(){
        setcookie("_lt", "", time()-60*60*24, '/');
        setcookie("_rfs", "", time()- 60*60*24, '/');
        setcookie("_fln", "", time()- 60*60*24, '/');
        setcookie("_usn", "", time()- 60*60*24, '/');
        setcookie("_lv", "", time()- 60*60*24, '/');
        setcookie("_la", "", time()- 60*60*24*365, '/');
        setcookie("laravel-token", "", time()-60*60*24, '/');
        setcookie("refresh", "", time()- 60*60*24, '/');
        setcookie("fullname", "", time()- 60*60*24, '/');
        setcookie("username", "", time()- 60*60*24, '/');
        setcookie("level", "", time()- 60*60*24, '/');
        Artisan::call('cache:clear');
        return redirect('/');
    }

    public static function getPermissions($token){
        $username = decrypt($_COOKIE["_usn"], "7Ind4r7");
        $typeUser = Http::withToken($token)->get(config('global.api_url').'/login/getListMenu?user='.$username);
        $permissions = json_decode(json_decode($typeUser->body())->permissions);
        return $permissions;
    }

    public static function getFullName(){
        $fullname = decrypt($_COOKIE["_fln"], "7Ind4r7");
        return $fullname;
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

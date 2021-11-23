<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
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
                // $semilla = "fs5Jç-1p.";
                // $encrypt = sha1($semilla.md5($token));
                setcookie("laravel-token", $token, time()+900);
                setcookie("lastLogin", time(), time()-360000);

                return redirect('/');
        }
        else{
            setcookie("laravel-token", "error", time()+900);
            return redirect('/');
        }
    }

    public function logout(){
        $token = "";
        Config::set(['token' => '']);
        setcookie("laravel-token", "", time()-3600);
        setcookie("lastLogin", time(), time()+360000);
        return redirect('/');
    }
}

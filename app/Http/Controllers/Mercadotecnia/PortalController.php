<?php

namespace App\Http\Controllers\Mercadotecnia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;
use stdClass;

class PortalController extends Controller
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

    public static function getHeroImages($token){
        $path = public_path('assets\mercadotecnia\Hero');
        $images = Storage::allFiles($path);
        dd($images);
    }

    
}

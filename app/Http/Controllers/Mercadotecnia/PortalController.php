<?php

namespace App\Http\Controllers\Mercadotecnia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
        $path = public_path('assets/mercadotecnia/Hero');
        $images = File::allFiles($path);
        // File::delete($path);
        // $start = strpos($images[0]->getPathname(), 'assets');
        // dd(substr($images[0]->getPathname(), $start, strlen($images[0]->getPathname()) - $start));
        return $images;
    }

    public static function storeTempImagesHero($images){
        $path = public_path('assets/mercadotecnia/Hero');
        $tempPath = public_path('assets/mercadotecnia/Temp/Hero');
        $tempImages = File::allFiles($tempPath);
        foreach($tempImages as $tempImage){
            File::delete($tempImage);       
        }
        $response = 1;
        
        foreach($images as $image){
            if($image['onServer']){
                $coppied = copy($path.'/'.$image['filename'] , $tempPath.'/'.$image['newPosition'].'.jpg');  
                if(!$coppied) { $response = 0; }
            }            
        }
        return $response;
    }
    
    public static function getHeroTempImages($token){
        $path = public_path('assets/mercadotecnia/Temp/Hero');
        $images = File::allFiles($path);
        return $images;
    }

    
}

<?php

namespace App\Http\Controllers\Mercadotecnia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Config;
use Illuminate\Contracts\Cache\Store;
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

    public static function deleteTemps(){
        $tempPath = public_path('assets/mercadotecnia/Temp');
        $previewPath = public_path('assets/mercadotecnia/Preview');
        $basePath = public_path('assets/mercadotecnia');
        File::cleanDirectory($tempPath);
        File::cleanDirectory($previewPath);

        File::copyDirectory($basePath.'/Hero', $tempPath.'/Hero');
        File::copyDirectory($basePath.'/Contenidos Digitales', $tempPath.'/Contenidos Digitales');
        File::copyDirectory($basePath.'/Eventos', $tempPath.'/Eventos');
        File::copyDirectory($basePath.'/Forma Parte de INDAR', $tempPath.'/Forma Parte de INDAR');
        File::copyDirectory($basePath.'/Ofertas Relampago', $tempPath.'/Ofertas Relampago');
        File::copyDirectory($basePath.'/Super Ofertas', $tempPath.'/Super Ofertas');


    }

    public static function getImages($token, $section){
        $path = public_path('assets/mercadotecnia/'.$section);
        $images = File::allFiles($path);
        // File::delete($path);
        // $start = strpos($images[0]->getPathname(), 'assets');
        // dd(substr($images[0]->getPathname(), $start, strlen($images[0]->getPathname()) - $start));
        return $images;
    }

    public static function uploadImage($uploadFile, $section){ 
        $file = Storage::disk('mercadotecniaTemp')->put($section, $uploadFile);
        return $file;
    }

    public static function deleteImage($image){ 
        $path = public_path('assets/mercadotecnia/Temp/'.$image);
        $deleted = File::delete($path);
        return $deleted;
    }

    public static function orderPreview($images, $section){
        $tempPath = public_path('assets/mercadotecnia/Temp/'.$section);
        $previewPath = public_path('assets/mercadotecnia/Preview/'.$section);
        if(file_exists($previewPath)){
            $previewImages = File::allFiles($previewPath);
            foreach($previewImages as $previewImage){
                File::delete($previewImage);       
            }
        }
        else{
            File::makeDirectory($previewPath, 0777, true, true);
        }
        
        $response = 1;

        foreach($images as $image){
            if($image['onServer']){
                $coppied = copy($tempPath.'/'.$image['filename'] , $previewPath.'/'.$image['newPosition'].'.jpg');  
                if(!$coppied) { $response = 0; }
            }            
        }
        return $response;
    }
    
    public static function getPreviewImages($token, $section){
        $path = public_path('assets/mercadotecnia/Preview/'.$section);
        $images = File::allFiles($path);
        return $images;
    }

    

    
}

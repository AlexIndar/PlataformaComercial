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

    public static function getActions($token){
        $getActions = Http::withToken($token)->get(config('global.api_url').'/PortalMKT/GetPortalMKT');
        $actions = json_decode($getActions->body(), true)['actions'];
        for($x=0; $x < count($actions); $x++){
            $tmp = explode('/',$actions[$x]['portalMkt_']['rutaImg']);
            $filename = end($tmp);
            $actions[$x]['portalMkt_']['filename'] = $filename;
        }
        // dd($actions);
        return $actions;
    }

    public static function uploadImage($uploadFile, $section, $delete){ 
        $file = Storage::disk('mercadotecniaTemp')->put($section, $uploadFile);
        if($delete != ''){
            PortalController::deleteImage($section.'/'.$delete);
        }
        return $file;
    }

    public static function deleteImage($image){ 
        $path = public_path('assets/mercadotecnia/Temp/'.$image);
        $deleted = File::delete($path);
        return $deleted;
    }

    public static function orderPreview($actions){
        foreach($actions as $action){
            $ruta = explode('/', $action['portalMkt_']['rutaImg']);
            $section = $ruta[count($ruta)-2];
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
        }
        
        $response = 1;
        $position = 1;
        for($x=0; $x < count($actions); $x++){
            $section = $actions[$x]['portalMkt_']['seccion'];
            $filename = explode('.', $actions[$x]['portalMkt_']['filename']);
            $extension = end($filename);
            $previewPath = public_path('assets/mercadotecnia/Preview/'.$section);
            if($x==0){
                $coppied = copy($actions[$x]['portalMkt_']['rutaImg'], $previewPath.'/'.$position.'-'.$filename[0].'.'.$extension);
            }
            else{
                $lastRoute = explode('/', $actions[$x-1]['portalMkt_']['rutaImg']);
                $lastSection = $lastRoute[count($lastRoute)-2];
                $position++;
                if($section != $lastSection){$position=1;}
                $coppied = copy($actions[$x]['portalMkt_']['rutaImg'], $previewPath.'/'.$position.'-'.$filename[0].'.'.$extension);
            }
            if(!$coppied) { $response = 0; }
        }

        return $response;
    }

    public static function getActionsPreview($token){
        $actions = PortalController::getActions($token);

        $sections = [];

        for($x=0; $x < count($actions); $x++){
            $ruta = explode('/', $actions[$x]['portalMkt_']['rutaImg']);
            $section = $ruta[count($ruta)-2];
            if(!in_array($section, $sections)){array_push($sections, $section);}
        }

        $actionsPreview = [];

        for($x=0; $x < count($sections); $x++){
            $previewPath = public_path('assets/mercadotecnia/Preview/'.$sections[$x]);
            if(file_exists($previewPath)){
                $previewImages = File::allFiles($previewPath);
                foreach($previewImages as $previewImage){
                    $filename = explode('-', $previewImage->getBasename());
                    $foundInActions = false;
                    for($y=0; $y < count($actions); $y++){
                        $filenameAction =  $actions[$y]['portalMkt_']['filename'];
                        $section = $actions[$y]['portalMkt_']['seccion'];
                        if(end($filename) == $filenameAction && $section == $sections[$x] ){
                            $actions[$y]['portalMkt_']['rutaImg'] = 'assets/mercadotecnia/Preview/'.$sections[$x].'/'.$previewImage->getBasename();
                            array_push($actionsPreview, $actions[$y]);
                            $foundInActions = true;
                        }
                    }
                    if(!$foundInActions){
                        $tmp = array (
                            "portalMkt_" => [
                                "idPortalMkt" => 0,
                                "seccion" => $sections[$x],
                                "rutaImg" => 'assets/mercadotecnia/Preview/'.$sections[$x].'/'.$previewImage->getBasename(),
                                "accion" => "",
                                "valor" => "#",
                                "portalMktd" => [],
                                "filename" => $previewImage->getBasename(),
                            ]
                        );
                        array_push($actionsPreview, $tmp);

                    }
                }
            }
        }
        return $actionsPreview;
    }
    

    public static function saveChanges($token, $actions){
            for($x=0; $x < count($actions); $x++){
                $actions[$x]['portalMkt_']['rutaImg'] = str_replace('/Temp', '', $actions[$x]['portalMkt_']['rutaImg']);
                $actions[$x]['portalMkt_']['idPortalMkt'] = 0;
                unset($actions[$x]['portalMkt_']['filename']);
            }

            $response = Http::withToken($token)->post(config('global.api_url').'/PortalMKT/AddPortalMKT', [
                "actions" => $actions
            ]);

            if($response->getStatusCode() == 200){
                $tempPath = public_path('assets/mercadotecnia/Temp');
                $basePath = public_path('assets/mercadotecnia');
    
                $sections = [];
    
                for($x=0; $x < count($actions); $x++){
                    $ruta = explode('/', $actions[$x]['portalMkt_']['rutaImg']);
                    $section = $ruta[count($ruta)-2];
                    if(!in_array($section, $sections)){array_push($sections, $section);}
                }
    
    
                for($x=0; $x < count($sections); $x++){
                    $folder = public_path('assets/mercadotecnia/'.$sections[$x]);
                    if(file_exists($folder)){
                        $images = File::allFiles($folder);
                        foreach($images as $oldImage){
                            $path = public_path('assets/mercadotecnia/'.$sections[$x].'/'.$oldImage->getBasename());
                            $deleted = File::delete($path);
                        }
                    }
                }
    
                File::copyDirectory($tempPath.'/Hero', $basePath.'/Hero');
                File::copyDirectory($tempPath.'/Contenidos Digitales', $basePath.'/Contenidos Digitales');
                File::copyDirectory($tempPath.'/Eventos', $basePath.'/Eventos');
                File::copyDirectory($tempPath.'/Forma Parte de INDAR', $basePath.'/Forma Parte de INDAR');
                File::copyDirectory($tempPath.'/Ofertas Relampago', $basePath.'/Ofertas Relampago');
                File::copyDirectory($tempPath.'/Super Ofertas', $basePath.'/Super Ofertas');
            }
            
            return $response;

            
    }
    
}

<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HeatMapController extends Controller
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

    public static function getItemSearchMap($token){
        $items = Http::withToken($token)->get(config('global.api_url').'/Cyc/GetItemSearchMap');
        return json_decode($items->body());
    }
}

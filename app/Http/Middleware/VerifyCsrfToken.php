<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/pedido/nuevo/getItems/all',
        '/pedido/nuevo/getItemByID',
        'pedido/nuevo/SepararPedidosPromo',
        '/promociones/storePromo',
        '/MisSolicitudes/storeSolicitud',
        '/MisSolicitudes/saveSolicitud',
        '/MisSolicitudes/getInfoSol',
        '/MisSolicitudes/getTransactionHistory',
        '/MisSolicitudes/getValidacionContactos',
        '/MisSolicitudes/getValidationRequest',
        '/MisSolicitudes/getFiles',
    ];
}

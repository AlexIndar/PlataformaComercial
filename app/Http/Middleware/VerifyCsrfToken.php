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
        '/pedido/nuevo/SepararPedidosPromo',
        '/pedido/editar', 
        '/pedido/nuevo',
        '/pedido/eliminar',
        '/pedido/storePedido',
        '/pedido/storePedidoGetID',
        '/pedido/updatePedido',
        '/pedido/storePedidoNS',
        '/pedido/getEventosCliente',
        '/pedido/forzarPedido',
        '/sendmail',
        '/pedidosAnteriores/RegresaEstadoPedido',
        '/promociones/storePromo',
        '/promociones/editar',
        '/MisSolicitudes/storeSolicitud',
        '/MisSolicitudes/saveSolicitud',
        '/MisSolicitudes/getInfoSol',
        '/MisSolicitudes/getTransactionHistory',
        '/MisSolicitudes/getValidacionContactos',
        '/MisSolicitudes/getValidationRequest',
        '/MisSolicitudes/getFiles',
        '/MisSolicitudes/getBills',
        '/MisSolicitudes/reSendForm',
        '/MisSolicitudes/UpdateFile',
        '/MisSolicitudes/UpdateReferences',
        '/MisSolicitudes/Update',
        '/sendmailSolicitud',
        '/MisSolicitudes/GetEmails',
        '/EstadisticaCliente/getEmployeeReport',
        '/EstadisticaCliente/getGeneralReport',
        '/EstadisticaCliente/getGeneralReportByManagement',
        '/EstadisticaCliente/getManagementReport', 
        '/EstadisticaCliente/getManagementReportByEmployee',
        '/Indarnet/getMyZone',
    ];
}

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
        '/pedido/nuevo/SepararPedidosPaquete',
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
        '/sendmailErrorNS',
        '/sendmailDesneg',
        '/pedidosAnteriores/RegresaEstadoPedido',
        '/pedidosAnteriores/getDetalleFacturado',
        'pedidosAnteriores/descargarDocumento',
        '/portal/busquedaGeneralItem/',
        '/portal/busqueda',
        '/promociones/storePromo',
        '/promociones/editar',
        '/promociones/eliminar',
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
        '/MisSolicitudes/UpdateConstAct',
        '/MisSolicitudes/Update',
        '/sendmailSolicitud',
        '/MisSolicitudes/GetEmails',
        '/EstadisticaCliente/getEmployeeReport',
        '/EstadisticaCliente/getGeneralReport',
        '/EstadisticaCliente/getGeneralReportByManagement',
        '/EstadisticaCliente/getManagementReport',
        '/EstadisticaCliente/getManagementReportByEmployee',
        '/Indarnet/getMyZone',
        '/SolicitudesPendientes/GetCycTableView',
        '/SolicitudesPendientes/SaveValidation',
        '/SolicitudesPendientes/RollBackRequest',
        '/SolicitudesPendientes/AcceptRequest',
        '/SolicitudesPendientes/SetReference',
        '/SolicitudesPendientes/ReactiveClient',
        '/comisiones/postActualizarArticulosEspeciales',
        '/comisiones/postActualizarEspeciales',
        '/comisiones/postComisionesResumenRH',
        '/Logistica/RegistroGuia',
        '/logistica/distribucion/numeroGuia/saveGuiaNumber',
        '/logistica/distribucion/validarSad/authoriceSad',
        '/logistica/distribucion/capturaGastoFletera/registroGuia',
        '/logistica/distribucion/capturaGastoFletera/readFileXML',
        '/logistica/distribucion/capturaGastoFletera/registerNet',
        '/logistica/distribucion/numeroGuia/updateImportsByFreighter',
        '/logistica/distribucion/numeroGuia/bulkLoadImports',
        '/logistica/distribucion/numeroGuia/captureInvoice',
        '/logistica/distribucion/numeroGuia/createImportsOfFreighter',
        '/logistica/distribucion/numeroGuia/deleteImportsOfFregihter',
        '/logistica/distribucion/autorizarGastosFleteras/cancelFolio',
        '/logistica/distribucion/autorizarGastosFleteras/authorizeFolio',
        '/almacen/capturaErrores/createError',
        '/almacen/capturaErrores/updateError',
        '/EstadisticaSolicitudTiempo/GetManagementTimeReport',
        '/EstadisticaSolicitudTiempo/GetTimeReport',
        '/EstadisticaSolicitudTiempo/GetGerencia',
        '/GetTableView',
        '/HeatMap/GetListCustomer',
        '/AsignacionZonas/UpdateZonesCyc',
        '/SolicitudesConsulta/GetCYCTableShow',
        '/MisSolicitudes/GetValidacionFacturas',
        '/MisSolicitudes/getValidacionActConst',
        '/MisSolicitudes/GetValidacionReferencias',
        '/SolicitudesPendientes/getFile',
    ];
}

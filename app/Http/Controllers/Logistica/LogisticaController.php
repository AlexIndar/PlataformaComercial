<?php

namespace App\Http\Controllers\Logistica;

use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Customer\TokenController;

class LogisticaController extends Controller
{
    #region LOGISTICA

        #region MESA CONTROL
            #region PLANEADO
            public static function getPlaneador($token){
                $getPlaneador = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetPlaneador');
                $planeador = json_decode($getPlaneador->body());
                $pedidos = array();
                foreach ($planeador as $element) {
                    $pedidos[$element->numPedido] = $element;
                }
                $pedidosAcomodados = array();
                foreach($pedidos as $pedido)
                {
                    array_push($pedidosAcomodados,[
                        'numPedido' => $pedido->numPedido,
                        'prioridad' => $pedido->prioridad,
                        'formaEnvio'=> $pedido->formaEnvio,
                        'cliente'   => $pedido->cliente,
                        'clave'     => $pedido->clave,
                        'nombre'    => $pedido->nombre,
                        'areas'     => []
                    ]);
                }
                $arrayAreas = array();
                for($a=0; $a < count($pedidosAcomodados); $a++)
                {
                    for($b=0; $b < count($planeador); $b++)
                    {
                        $area = $planeador[$b]->area;
                        if($planeador[$b]->numPedido == $pedidosAcomodados[$a]['numPedido'])
                        {
                            if($b != 0){
                                if($planeador[$b]->numPedido == $planeador[$b-1]->numPedido && $planeador[$b]->area == $planeador[$b-1]->area)
                                {
                                    $arrayAreas[$planeador[$b]->area]['porsurtir'] = $arrayAreas[$planeador[$b]->area]['porsurtir'] + $planeador[$b]->porsurtir;
                                    $arrayAreas[$planeador[$b]->area]['surtido'] = $arrayAreas[$planeador[$b]->area]['surtido'] + $planeador[$b]->surtido;
                                    if($arrayAreas[$planeador[$b]->area]['porsurtir'] > $arrayAreas[$planeador[$b]->area]['surtido'] && $arrayAreas[$planeador[$b]->area]['surtido'] == 0){
                                        $arrayAreas[$planeador[$b]->area]['style'] = 'Valorando';
                                    }else if($arrayAreas[$planeador[$b]->area]['porsurtir'] < $arrayAreas[$planeador[$b]->area]['surtido'] && $arrayAreas[$planeador[$b]->area]['porsurtir'] == 0){
                                        $arrayAreas[$planeador[$b]->area]['style'] = 'EnTiempo';
                                    }else{
                                        $arrayAreas[$planeador[$b]->area]['style'] = 'Atrasado';
                                    }
                                }else{
                                    if($planeador[$b]->porsurtir > $planeador[$b]->surtido && $planeador[$b]->surtido == 0)
                                    {
                                        $style = 'Valorando';
                                    }else if($planeador[$b]->porsurtir < $planeador[$b]->surtido && $planeador[$b]->porsurtir == 0)
                                    {
                                        $style = 'EnTiempo';
                                    }else{
                                        $style = 'Atrasado';
                                    }
                                    $dataArea =  array($area => [
                                        'mov'       => $planeador[$b]->mov,
                                        'name'      => $area,
                                        'porsurtir' => $planeador[$b]->porsurtir,
                                        'surtido'   => $planeador[$b]->surtido,
                                        'style'     => $style
                                    ]);
                                    $arrayAreas = $arrayAreas + $dataArea;
                                }
                            }else{
                                if($planeador[$b]->porsurtir > $planeador[$b]->surtido && $planeador[$b]->surtido == 0)
                                    {
                                        $style = 'Valorando';
                                    }else if($planeador[$b]->porsurtir < $planeador[$b]->surtido && $planeador[$b]->porsurtir == 0)
                                    {
                                        $style = 'EnTiempo';
                                    }else{
                                        $style = 'Atrasado';
                                    }
                                $dataArea =  array($area => [
                                    'mov'       => $planeador[$b]->mov,
                                    'name'      => $area,
                                    'porsurtir' => $planeador[$b]->porsurtir,
                                    'surtido'   => $planeador[$b]->surtido,
                                    'style'     => $style
                                ]);
                                $arrayAreas = $arrayAreas + $dataArea;
                            }
                        }
                    }
                    $pedidosAcomodados[$a]['areas'] = $arrayAreas;
                    $arrayAreas = array();
                }
                
                return $pedidosAcomodados;
            }
            public static function getArrayPlaneador($token){
                $getPlaneador = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetPlaneador');
                $planeador = json_decode($getPlaneador->body());
                return $planeador;
            }
            public static function getCajasPendientes($token){
                $getCajasPendientes = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetCajasPendientes');
                $cajasPendientes = json_decode($getCajasPendientes->body());
                return $cajasPendientes;
            }
            #endregion
        #endregion

        #region DISTRIBUCION
            #region NUMERO GUIA
            public static function getFreighters($token){
                $getFreighters = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetFreighters');
                $freighters = json_decode($getFreighters->body());
                return $freighters;
            }
            public static function costFletera($token){
                $costFletera = Http::withToken($token)->get(config('global.api_url').'/Logistica/CostFletera');
                $cost = json_decode($costFletera->body());
                return $cost;
            }
            public static function existShipment($token,$data){
                $dataJson = json_decode($data);
                $existShipment = Http::withToken($token)->get(config('global.api_url').'/Logistica/ExistShipment?embarque='.$dataJson->embarque);
                $exist = json_decode($existShipment);
                return $exist;
            }
            public static function captureInvoice($token,$data){
                $dataJson = json_decode($data);
                $captureInvoice = Http::withToken($token)->post(config('global.api_url').'/Logistica/returnBills',
                [
                    $dataJson->embarques[0]
                ]);
                $invoice = json_decode($captureInvoice);
                return $invoice;
            }
            public static function existAnyBillsInAnyShipment($token,$data){
                $dataJson = json_decode($data);
                $existAnyBills = Http::withToken($token)->get(config('global.api_url').'/Logistica/ExistAnyBillsInAnyShipment?factura='.$dataJson->factura);
                $exist = json_decode($existAnyBills);
                return $exist;
            }
            public static function saveGuiaNumber($token,$data){
                $dataJson = json_decode($data);
                $saveGuiaNumber = Http::withToken($token)->post(config('global.api_url').'/Logistica/SaveGuiaNumber',
                [
                    "facturas" => $dataJson->facturasSelected,
                    "tipos" => $dataJson->tablaTipo,
                    "fletera" => $dataJson->fletera,
                    "importeSeguro" => $dataJson->importeSeguro,
                    "importeTotal" => $dataJson->importeTotal,
                    "numGuia" => $dataJson->numGuia,
                    "chofer" => $dataJson->chofer
                ]);
                $save = json_decode($saveGuiaNumber);
                return $save;
            }
            public static function cuentaBultosWMSManager($token, $data)
            {
                $dataJson = json_decode($data);
                $consultaBultos = Http::withToken($token)->get(config('global.api_url').'/Logistica/CuentaBultosWMS',[
                    "factura" => $dataJson->factura,
                    "fletera" => $dataJson->fletera
                ]);
                $bultos = json_decode($consultaBultos->body());
                return $bultos;
            }
            public static function getDrivers($token)
            {
                $getDrivers = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetDrivers');
                $drivers = json_decode($getDrivers->body());
                return $drivers;
            }
            public static function getStates($token)
            {
                $getStates = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetStates');
                $states = json_decode($getStates->body());
                return $states;
            }
            public static function getCitiesByState($token,$data)
            {
                $dataJson = json_decode($data);
                $getCities = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetCitiesByState',[
                    "state" => $dataJson->estado
                ]);
                $cities = json_decode($getCities->body());
                return $cities;
            }
            public static function getFreightersImports($token, $data)
            {
                $dataJson = json_decode($data);
                $getFreightersImports = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetFreightersImports',[
                    "freighter" => $dataJson->fletera,
                    "state" => $dataJson->estado
                ]);
                $imports = json_decode($getFreightersImports->body());
                return $imports;
            }
            public static function getImportsByFreighter($token,$data)
            {
                $dataJson = json_decode($data);
                $getImportsByFreighter = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetImportsByFreighter?id='.$dataJson->id);
                $imports = json_decode($getImportsByFreighter->body());
                return $imports;
            }
            public static function updateImportsByFreighter($token,$data)
            {
                $dataJson = json_decode($data);
                $updateImportsByFreighter = Http::withToken($token)->put(config('global.api_url').'/Logistica/UpdateImportsByFreighter',[
                    "id" => $dataJson->id,
                    "cp" => $dataJson->cp,
                    "fletera" => $dataJson->fletera,
                    "zona" => $dataJson->zona,
                    "caja" => $dataJson->caja,
                    "atado" => $dataJson->atado,
                    "bulto" => $dataJson->bulto,
                    "cubeta" => $dataJson->cubeta,
                    "tarima" => $dataJson->tarima,
                    "fechaInicio" => $dataJson->fechaInicio,
                    "fechaFin" => $dataJson->fechaFin
                ]);
                $update = json_decode($updateImportsByFreighter->body());
                return $update;
            }
            public static function bulkLoadImports($token,$data)
            {
                $dataJson = json_decode($data);
                //dd($dataJson->json);
                // dd($json);
                $bulkLoadImports = Http::withToken($token)->post(config('global.api_url').'/Logistica/BulkLoadImports',json_decode($dataJson->json));
                $bulkLoad = json_decode($bulkLoadImports->body());
                return $bulkLoad;
            }
            #endregion
            #region VALIDAR SAD
            public static function consultValidateSAD($token){
                $validateSAD = Http::withToken($token)->get(config('global.api_url').'/Logistica/ConsultValidateSAD');
                $sad = json_decode($validateSAD->body());
                foreach($sad as $validate){
                    $fechaFactura = explode('T',$validate->fechaFactura)[0];
                    $validate->fechaFactura = $fechaFactura == "0001-01-01" ? '' : $fechaFactura;
                }
                return $sad;
            }
            public static function authoriceSad($token,$data){
                $dataJson = json_decode($data);
                $username = decrypt($_COOKIE["_usn"], "7Ind4r7");
                $validateSAD = Http::withToken($token)->post(config('global.api_url').'/Logistica/AuthorizationSAD',[
                    "sadID" => $dataJson->sadID,
                    "username"=>$username
                ]);
                return $validateSAD;
            }
            #endregion
            #region REPORTE SAD
            public static function getReportSad($token){
                $reportSad = Http::withToken($token)->get(config('global.api_url').'/Logistica/ReportSAD');
                $sad = json_decode($reportSad);
                foreach($sad as $report){
                    $fecha = explode('T',$report->fecha)[0];
                    $report->fecha = $fecha == "0001-01-01" ? '' : $fecha;
                    $cxcFecha = explode('T',$report->cxcFecha)[0];
                    $report->cxcFecha = $cxcFecha == "0001-01-01" ? '' : $cxcFecha;
                    $validaFecha = explode('T',$report->validaFecha)[0];
                    $report->validaFecha = $validaFecha == "0001-01-01" ? '' : $validaFecha;
                }
                return $sad;
            }
            #endregion
            #region REPORTE EMBARQUE
            public static function reportShipment($token){
                $reportShipment = Http::withToken($token)->get(config('global.api_url').'/Logistica/ReportShipment');
                $shipment = json_decode($reportShipment);
                foreach($shipment as $report){
                    $report->fecha = explode(' ',$report->fecha)[0];
                    $report->fechaConcluido = explode(' ',$report->fechaConcluido)[0];
                    $report->fechaHora = explode(' ',$report->fechaHora)[0];
                }
                return $shipment;
            }
            #endregion
            #region CAPTURA GASTO FLETERA
            public static function getVendors($token){
                $getVendors = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetVendors');
                $vendors = json_decode($getVendors->body());
                return $vendors;
            }
            public static function getDepartments($token){
                $getDepartments = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetDepartments');
                $departments = json_decode($getDepartments->body());
                return $departments;
            }
            public static function getMunicipios($token){
                $getMunicipios = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetMunicipios');
                $municipios = json_decode($getMunicipios->body());
                return $municipios;
            }
            public static function getClasificadores($token){
                $getClasificadores = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetClasificadores');
                $clasificadores = json_decode($getClasificadores->body());
                return $clasificadores;
            }
            public static function getGuias($token,$data){
                $dataJson = json_decode($data);
                $getGuias = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetGuias?paqueteriaID='.$dataJson->paqueteriaID);
                $guias = json_decode($getGuias->body());
                return $guias;
            }
            public static function getGuia($token, $data){
                $dataJson = json_decode($data);
                $getGuia = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetGuia?numeroGuia='.$dataJson->numeroGuia);
                $guia = json_decode($getGuia->body());
                return $guia;
            }
            public static function guiaSelected($token,$data)
            {
                $dataJson = json_decode($data);
                $guiaSelected = Http::withToken($token)->get(config('global.api_url').'/Logistica/GuiaSelected?idNumeroGuia='.$dataJson->idNumeroGuia.'&numeroGuia='.$dataJson->numeroGuia.'&importeTotal='.$dataJson->importeTotal);
                $guia = json_decode($guiaSelected->body());
                return $guia;
            }
            public static function getAutorizacion($token,$data)
            {
                $dataJson = json_decode($data);
                $getAutorizacion = Http::withToken($token)->get(config('global.api_url').'/Logistica/GetAutorizacion?user='.$dataJson->user.'&pass='.$dataJson->password);
                $autorizacion = json_decode($getAutorizacion->body());
                return $autorizacion;
            }
            public static function registroGuia($token, $data)
            {
                $dataJson = json_decode($data);
                $registroGuia = Http::withToken($token)->post(config('global.api_url').'/Logistica/RegistroGuia',[
                    "numguia" => $dataJson->numguia,
                    "importe" => $dataJson->importe,
                    "vendor" => $dataJson->vendor,
                    "department" => $dataJson->department,
                    "municipio" => $dataJson->municipio,
                    "estado" => $dataJson->estado,
                    "clasificador" => $dataJson->clasificador,
                    "paqueteriaID" => $dataJson->paqueteriaID,
                    "usuario" => $dataJson->usuario,
                ]);
                $guia = json_decode($registroGuia->body());
                return $guia;
            }
            public static function readFileXML($token, $pathXML)
            {
                $xml = simplexml_load_file(storage_path('app/'.$pathXML));
                $ns = $xml->getNamespaces(true);
                $xml->registerXPathNamespace('c', $ns['cfdi']);
                $xml->registerXPathNamespace('t', $ns['tfd']);
                
                
                foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
                    $Cpt_version = $cfdiComprobante['version']; 
                    $Cpt_fecha = $cfdiComprobante['fecha']; 
                    $Cpt_Folio = $cfdiComprobante['Folio'];
                    $Cpt_sello = $cfdiComprobante['sello']; 
                    $Cpt_total = $cfdiComprobante['Total']; 
                    $Cpt_subTotal = $cfdiComprobante['SubTotal']; 
                    $Cpt_certificado = $cfdiComprobante['certificado']; 
                    $Cpt_formaDePago = $cfdiComprobante['formaDePago']; 
                    $Cpt_noCertificado = $cfdiComprobante['noCertificado']; 
                    $Cpt_tipoDeComprobante = $cfdiComprobante['tipoDeComprobante']; 
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
                    $Emi_rfc = $Emisor['rfc']; 
                    $Emi_nombre = $Emisor['nombre']; 
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $DomicilioFiscal){ 
                    $DomF_pais = $DomicilioFiscal['pais']; 
                    $DomF_calle = $DomicilioFiscal['calle']; 
                    $DomF_estado = $DomicilioFiscal['estado']; 
                    $DomF_colonia = $DomicilioFiscal['colonia']; 
                    $DomF_municipio = $DomicilioFiscal['municipio']; 
                    $DomF_noExterior = $DomicilioFiscal['noExterior']; 
                    $DomF_codigoPostal = $DomicilioFiscal['codigoPostal']; 
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $ExpedidoEn){ 
                    $ExpEn_pais =  $ExpedidoEn['pais']; 
                    $ExpEn_calle = $ExpedidoEn['calle']; 
                    $ExpEn_estado = $ExpedidoEn['estado']; 
                    $ExpEn_colonia = $ExpedidoEn['colonia']; 
                    $ExpEn_conExterior = $ExpedidoEn['noExterior']; 
                    $ExpEn_codigoPostal = $ExpedidoEn['codigoPostal']; 
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
                    $Recpetor_rfc =  $Receptor['rfc']; 
                    $Recpetor_nombre =  $Receptor['nombre']; 
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $ReceptorDomicilio){ 
                    $RecepDomi_pais = $ReceptorDomicilio['pais']; 
                    $RecepDomi_calle = $ReceptorDomicilio['calle']; 
                    $RecepDomi_estado = $ReceptorDomicilio['estado']; 
                    $RecepDomi_colonia = $ReceptorDomicilio['colonia']; 
                    $RecepDomi_municipio = $ReceptorDomicilio['municipio']; 
                    $RecepDomi_noExterior = $ReceptorDomicilio['noExterior']; 
                    $RecepDomi_noInterno = $ReceptorDomicilio['noInterior']; 
                    $RecepDomi_codigoPostal = $ReceptorDomicilio['codigoPostal']; 
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
                    $Concepto_unidad =  $Concepto['unidad']; 
                    $Concepto_importe =  $Concepto['importe']; 
                    $Concepto_cantidad =  $Concepto['cantidad']; 
                    $Concepto_descripcion =  $Concepto['descripcion']; 
                    $Concepto_valorUnitario =  $Concepto['valorUnitario'];   
                } 
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
                    $Traslado_tasa =  $Traslado['tasa']; 
                    $Traslado_importe =  $Traslado['importe']; 
                    $Traslado_impuestos =  $Traslado['impuesto'];  
                } 
                
                foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
                    $Tf_selloCFD =  $tfd['selloCFD']; 
                    $Tf_FechaTimbrado = $tfd['FechaTimbrado']; 
                    $Tf_UUID = $tfd['UUID'];
                    $Tf_noCertificadoSAT = $tfd['noCertificadoSAT']; 
                    $Tf_version = $tfd['version']; 
                    $Tf_selloSAT = $tfd['selloSAT']; 
                } 
                
                Storage::disk('local')->delete($pathXML);
                $data = [
                    'uuid' => $Tf_UUID,
                    'numFactura' => $Cpt_Folio,
                    'subTotal' => $Cpt_subTotal,
                    'total' => $Cpt_total 
                ];
                return $data; 
            }
            public static function registerNet($token, $data)
            {
                // dd(json_encode($data));
                dd($data);
                $jsonData = json_decode($data);
                dd($jsonData);
            }
            #endregion
        #endregion
        
        #region REPORTES
            #region FACTURAS X EMBARCAR
            public static function consultBillsXShipments($token,$data)
            {
                ini_set('memory_limit','-1');
                $jsonData = json_decode($data);
                $facturasEmbarcar = Http::withToken($token)->get(config('global.api_url').'/Logistica/ConsultBillsXShipments?fechaInicio='.$jsonData->fechaInicio.'&fechaFin='.$jsonData->fechaFin);
                $facturas = json_decode($facturasEmbarcar->body());
                foreach($facturas as $fa){
                    $fa->fechaEmbarque = explode('T',$fa->fechaEmbarque)[0];
                    $fechaFleteXConfirmar  = explode('T',$fa->fechaFleteXConfirmar)[0];
                    $fa->fechaFleteXConfirmar = $fechaFleteXConfirmar == '0001-01-01' ? '' : $fechaFleteXConfirmar;
                    $fa->fechaFactura = explode('T',$fa->fechaFactura)[0];
                    $fechaIngreso  = explode('T',$fa->fechaIngreso)[0];
                    $fa->fechaIngreso = $fechaIngreso == "0001-01-01" ? '' : $fechaIngreso;
                }
                return $facturas;
            }
            public static function exportExcelBillsXShipments($token,$data)
            {
                $jsonData = json_decode($data);
                $exportExcel = Http::withToken($token)->get(config('global.api_url').'/Logistica/ConsultBillsXShipments?fechaInicio='.$jsonData->fechaInicio.'&fechaFin='.$jsonData->fechaFi);
                $export = json_decode($exportExcel->body());
                return $export;
            }
            #endregion
            
            #region GASTO FLETERA
            public static function consultFreightExpense($token)
            {
                $gastoFleteras = Http::withToken($token)->get(config('global.api_url').'/Logistica/ConsultFreightExpense');
                $reporte = json_decode($gastoFleteras->body());
                return $reporte;
            }
            #endregion
            
            #region INTERFA FACTURACION
            public static function consultBillingInterface($toke,$data)
            {
                ini_set('memory_limit','-1');
                $jsonData = json_decode($data);
                $facturasEmbarques = Http::withToken($token)->get(config('global.api_url').'/Logistica/ConsultBillingInterface?fechaInicio='.$jsonData->fechaInicio.'&fechaFin='.$jsonData->fechaFin);
                $reporte = json_decode($facturasEmbarques->body());
                return $facturas;
            }
            #endregion
        #endregion
    
    #endregion
}

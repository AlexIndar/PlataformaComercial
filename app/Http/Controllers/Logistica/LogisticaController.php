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
                $getPlaneador = Http::withToken($token)->get('https://localhost:44384/Logistica/GetPlaneador');
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
                $getPlaneador = Http::withToken($token)->get('https://localhost:44384/Logistica/GetPlaneador');
                $planeador = json_decode($getPlaneador->body());
                return $planeador;
            }
            public static function getCajasPendientes($token){
                $getCajasPendientes = Http::withToken($token)->get('https://localhost:44384/Logistica/GetCajasPendientes');
                $cajasPendientes = json_decode($getCajasPendientes->body());
                return $cajasPendientes;
            }
            #endregion
        #endregion

        #region DISTRIBUCION
            #region CAPTURA GASTO FLETERA
            public static function getVendors($token){
                $getVendors = Http::withToken($token)->get('https://localhost:44384/Logistica/GetVendors');
                $vendors = json_decode($getVendors->body());
                return $vendors;
            }
            public static function getDepartments($token){
                $getDepartments = Http::withToken($token)->get('https://localhost:44384/Logistica/GetDepartments');
                $departments = json_decode($getDepartments->body());
                return $departments;
            }
            public static function getMunicipios($token){
                $getMunicipios = Http::withToken($token)->get('https://localhost:44384/Logistica/GetMunicipios');
                $municipios = json_decode($getMunicipios->body());
                return $municipios;
            }
            public static function getClasificadores($token){
                $getClasificadores = Http::withToken($token)->get('https://localhost:44384/Logistica/GetClasificadores');
                $clasificadores = json_decode($getClasificadores->body());
                return $clasificadores;
            }
            public static function getGuias($token,$data){
                $dataJson = json_decode($data);
                $getGuias = Http::withToken($token)->get('https://localhost:44384/Logistica/GetGuias?paqueteriaID='.$dataJson->paqueteriaID);
                $guias = json_decode($getGuias->body());
                return $guias;
            }
            public static function getGuia($token, $data){
                $dataJson = json_decode($data);
                $getGuia = Http::withToken($token)->get('https://localhost:44384/Logistica/GetGuia?numeroGuia='.$dataJson->numeroGuia);
                $guia = json_decode($getGuia->body());
                return $guia;
            }
            public static function guiaSelected($token,$data)
            {
                $dataJson = json_decode($data);
                $guiaSelected = Http::withToken($token)->get('https://localhost:44384/Logistica/GuiaSelected?idNumeroGuia='.$dataJson->idNumeroGuia.'&numeroGuia='.$dataJson->numeroGuia.'&importeTotal='.$dataJson->importeTotal);
                $guia = json_decode($guiaSelected->body());
                return $guia;
            }
            public static function getAutorizacion($token,$data)
            {
                $dataJson = json_decode($data);
                $getAutorizacion = Http::withToken($token)->get('https://localhost:44384/Logistica/GetAutorizacion?user='.$dataJson->user.'&pass='.$dataJson->password);
                $autorizacion = json_decode($getAutorizacion->body());
                return $autorizacion;
            }
            public static function registroGuia($token, $data)
            {
                $dataJson = json_decode($data);
                $registroGuia = Http::withToken($token)->post('https://localhost:44384/Logistica/RegistroGuia',[
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
            #region FACTURAS X EMBARQUE
            public static function consultBillsXShipments($token,$data)
            {
                ini_set('memory_limit','-1');
                $jsonData = json_decode($data);
                $facturasEmbarques = Http::withToken($token)->get('https://localhost:44384/Logistica/consultBillsXShipments?fechaInicio='.$jsonData->fechaInicio.'&fechaFin='.$jsonData->fechaFin);
                $facturas = json_decode($facturasEmbarques->body());
                return $facturas;
            }
            #endregion
            
            #region GASTO FLETERA
            public static function consultFreightExpense($token)
            {
                $gastoFleteras = Http::withToken($token)->get('https://localhost:44384/Logistica/consultFreightExpense');
                $reporte = json_decode($gastoFleteras->body());
                return $reporte;
            }
            #endregion
        #endregion
    
    #endregion
}

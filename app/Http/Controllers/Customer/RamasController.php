<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RamasController extends Controller
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

    public static function getRama1(){
        $rama = array ("Abrasivos", "Adhesivos y selladores", "Automotriz", "Cerradura y herrajes", "Fijación", "Herramientas", "Herrería y soldadura", "Jardinería", "Material eléctrico", "Mercadeo", "Pintura y accesorios", "Plomería y gas", "Seguridad industrial");
        return $rama;
    }

    public static function getRama2(){
        $rama = array();

        $rama[0] = array ("Diamantados", "Fibras", "Metálicos", "Paquete", "Revestidos", "Sólidos");
        $rama[1] = array ("Adhesivos", "Cintas adhesivas", "Impermeabilizantes", "Paquete de solventes y otros", "Resanadores y reparadores", "Selladores");
        $rama[2] = array ("Complementos automotrices", "Limpieza automotriz", "Lubricantes", "Pulido y encerado");
        $rama[3] = array ("Cajas fuertes", "Candados", "Cerraduras", "Herrajes", "Vigilancia");
        $rama[4] = array ("Abrazaderas", "Cables, cadenas y soga", "Clavos y grapas", "Remaches y remachadoras", "Taquetes", "Tornillería");
        $rama[5] = array ("Equipos de gasolina", "Herramientas de corte", "Herramientas de mano", "Herramientas eléctricas", "Herramientas hidráulicas", "Herramientas neumáticas", "Herramientas de medición");
        $rama[6] = array ("Cortadora de plasma", "Soldaduras", "Soldadura para electrónica", "Soldaduras");
        $rama[7] = array ("Equipos de gasolina para jardinería", "Herramientas para corte y poda", "Herramientas para jardinería", "Mangueras y riego");
        $rama[8] = array ("Accesorios eléctricos", "Cables y accesorios", "Contactos eléctricos", "Electrodomésticos", "Generadores", "Iluminación", "Pilas", "Placas y apagadores");
        $rama[9] = array ("Electrónicos y electrométricos", "Exhibición", "Impresos", "Otros", "Promocionales", "Textiles");
        $rama[10] = array ("Complementos para pintar", "Escaleras", "Limpieza", "Paquete", "Pinturas y barnices", "Pistola para pintar");
        $rama[11] = array("Baños", "Bombas", "Calentadores de agua", "Cocina", "Ductos", "Gas y conexiones", "Paquete", "Parrillas y quemadores", "Plomería", "Válvulas");
        $rama[12] = array("Aromatiantes y deodorizantes", "Plaguicidas", "Protección corporal", "Señalamientos", "Telas y mallas");
        return $rama;
    }

    public static function getRama3(){
        $rama = array();

        $rama[0][0] = array ("Copas de diamantada", "Discos de diamante", "Lija de carburo", "Lima de diamante", "Pads diamantados", "Rectificadores diamantados", "Rueda de diamante");
        $rama[0][1] = array ("Almohadillas", "Bandas de lija", "Discos de fibra", "Rodillos", "Ruedas");
        $rama[0][2] = array ("Cardas", "Cepillos", "Espirales", "Limas");
        $rama[0][3] = array ("Paquete", "Paquete");
        $rama[0][4] = array ("Bandas de lija", "Cilindros", "Discos de esponja", "Discos de lija", "Lijas en hoja", "Lijas esponjas", "Rehilete de lija", "Rollos de lija", "Rueda flap", "Tiras de lija");
        $rama[0][5] = array ("Discos de cubo", "Discos tipo 41 para máquinas estacionarias", "Discos tipo 41 para máquinas portátiles", "Limas y piedras abrasivas", "Pastas para pulido");

        $rama[1][0] = array ("Adhesivo de montaje", "Adhesivo epóxico", "Adhesivo estructural", "Adhesivo fijador", "Adhesivo instantáneo", "Adhesivo de contacto", "Cemento", "Pegamento blanco", "Pegamento universal");
        $rama[1][1] = array ("Cinta adhesiva reflejante", "Cinta aislante", "Cinta antiderrapante", "Cinta asfáltica", "Cinta decorativa", "Cinta doble cara", "Cinta masking", "Cinta para ducto", "Cinta para empaque", "Cintas de acero inoxidable", "Cintas selladoras");
        $rama[1][2] = array ("Concreto impermeable", "Impermeabilizante", "Morteros y aditivos");
        $rama[1][3] = array ("Paquete de solventes y otros químicos");
        $rama[1][4] = array ("Resanador");
        $rama[1][5] = array ("Juntas", "Pistola calafateadora", "Sellador de rosca", "Selladores", "Silicón");

        $rama[2][0] = array ("Anticongelante", "Inversores y arrancadores");
        $rama[2][1] = array ("Equipo de limpieza", "Escobas", "Limpiadores automotrices", "Shampoos");
        $rama[2][2] = array ("Lubricantes en aerosol", "Lubicantes líquidos", "Lubricantes sólidos");
        $rama[2][3] = array ("Complementos para pulido y encerado", "Encerado automotriz", "Pulimento automotriz");

        $rama[3][0] = array ("Caja fuerte");
        $rama[3][1] = array ("Candado de combinación", "Candado de llave");
        $rama[3][2] = array ("Cerradura de embutir", "Cerradura de sobreponer", "Cerradura para mueble", "Pomos, manijas y cerrojos");
        $rama[3][3] = array ("Bisagras", "Carro de rodamientos", "Cierrapuertas", "Correderas", "Escuadras y mensulas", "Fijapuerta y topes", "Gancho y percheros", "Guardapolvos", "Jaladeras", "Ruedas y rodajas", "Señalamiento de fachada", "Tubo para closet");
        $rama[3][4] = array ("Circuito cerrado de televisión", "Mirillas", "Videoreporteo");

        $rama[4][0] = array ("Abrazaderas");
        $rama[4][1] = array ("Alambres", "Cables", "Cadenas", "Sogas y sujetadores");
        $rama[4][2] = array ("Clavos y grapas");
        $rama[4][3] = array ("Remaches y remachadoras");
        $rama[4][4] = array ("Taquetes");
        $rama[4][5] = array ("Tornillería");

        $rama[5][0] = array ("Equipos para la construcción");
        $rama[5][1] = array ("Avellanadores", "Brocas", "Buriles y cortadores", "Cinceles y botadores", "Cizallas y cortadores de lámina y barilla", "Cuchillos y navajas", "Machuelos", "Seguetas y serruchos");
        $rama[5][2] = array ("Almacenamiento de herramientas", "Desarmadores y puntas", "Herramientas automotrices", "Herramientas para construcción", "Herramientas para madera", "Herramientas para tubo", "Llaves y dados", "Manejo de carga", "Martillos y marros", "Paquetes de herramientas varias", "Pinzas y tijeras", "Prensas y tornillos");
        $rama[5][3] = array ("Herramientas eléctricas estacionarias", "Herramientas eléctricas portatiles", "Herramientas eléctricas inalámbricas", "Herramientas eléctricas portatiles inalámbricas, cargadores de baterías", "Herramientas para limpieza", "Paquete", "Refacciones de herramientas eléctricas");
        $rama[5][4] = array ("Elevadores", "Equipo para carrocería", "Gatos", "Prensas de banco", "Traspaleta hidráulica");
        $rama[5][5] = array ("Bomba de aire", "Clavadoras y engrapadoras", "Compresores y accesorios", "Herramientas neumáticas automotrices");
        $rama[5][6] = array ("Básculas", "Calibradores", "Inspección y detección", "Medidores de distancia", "Medidores de inclinación", "Multímetros", "Termómetros", "Torquímetros", "Trazadores");

        $rama[6][0] = array ("Cortadora de plasma");
        $rama[6][1] = array ("Accesorios para soldaduras", "Soldadura autogena", "Soldadura para electrodo de microalambre inverter", "Soldadura para electrodo revestido", "Soldadura para electrodo revestido inverter");
        $rama[6][2] = array ("Cautines");
        $rama[6][3] = array ("Complementos para soldar", "Soldaduras para electrodo revestido", "Soldaduras sólidas");

        $rama[7][0] = array ("Desbrozadora", "Moto-sierra y corta cortasestos", "Podadora", "Sopladora");
        $rama[7][1] = array ("Herramientas de jardinería eléctrica", "Herramientas de jardinería manual");
        $rama[7][2] = array ("Herramientas para jardinería");
        $rama[7][3] = array ("Mangueras de riego", "Riego");

        $rama[8][0] = array ("Accesorios para instalación eléctrica");
        $rama[8][1] = array ("Accesorios para cables eléctricos", "Cable coaxial", "Cables eléctricos", "Extensiones eléctricas", "Fijación y anclaje");
        $rama[8][2] = array ("Contacto eléctrico", "Multicontacto eléctrico");
        $rama[8][3] = array ("Antena", "Extractor de aire", "Hielera", "Parrilla eléctrica", "Protección de equipos eléctricos", "Soportes", "Ventiladores");
        $rama[8][4] = array ("Generadores");
        $rama[8][5] = array ("Foco ahorrador", "Foco de led", "Foco incandescente", "Lámparas", "Lámparas de led", "Linternas", "Porta lámpara");
        $rama[8][6] = array ("Pilas deshechables", "Pilas recargables");
        $rama[8][7] = array ("Apagadores", "Placa armada", "Placas");

        $rama[9][0] = array ("Audio y video", "Cómputo y comunicación", "Electrométricos");
        $rama[9][1] = array ("Exhibidores", "Propaganda");
        $rama[9][2] = array ("Impresos");
        $rama[9][3] = array ("Otros");
        $rama[9][4] = array ("Casa y jardín", "Deportes", "Oficina", "Vinos y licores");
        $rama[9][5] = array ("Ropa");

        $rama[10][0] = array ("Brochas y cepillos", "Cuñas y espátulas", "Revolvedor de pintura", "Rodillos");
        $rama[10][1] = array ("Escaleras");
        $rama[10][2] = array ("Limpiadores");
        $rama[10][3] = array ("Paquete");
        $rama[10][4] = array ("Anticorrosivos", "Barnices", "Colorantes", "Pinturas y esmaltes");
        $rama[10][5] = array ("Aerografos", "Equipo para pintar", "Pistola para pintar de gravedad", "Pistola para pintar de presión", "Pistola para pintar de succión", "Pistola para pintar eléctrica", "Pistola para sopletear", "Refacciones para pistolas para pintar");
        
        $rama[11][0] = array("Accesorios para baño", "Llave de mano para tina", "Mezcladora para empotrar", "Mezcladora para lavabo", "Mexcladoras monomandos", "Muebles para baño", "Refacciones para W.C.", "Regaderas");
        $rama[11][1] = array("Bomba sumergible", "Bombas autocebante", "Bombas de diafragma", "Bombas industriales", "Bombas residenciales", "Hidroneumático", "Purificadores de agua");
        $rama[11][2] = array("Calentador de gas", "Calentador eléctrico", "Calentador solar");
        $rama[11][3] = array("Llave para fregadero", "Mezcladora para fregadero", "Mezcladoras monomandos para fregadero", "Tarjas");
        $rama[11][4] = array("Ducto flexible de alumninio", "Filtros para ducto");
        $rama[11][5] = array("Conexión para gas", "Gases", "Manguera para gas", "Regulador para gas", "Válvula para gas");
        $rama[11][6] = array("Paquete");
        $rama[11][7] = array("Parrilla de gas", "Quemador de gas");
        $rama[11][8] = array("Cespol", "Coladera", "Contra", "Desagüe", "Manguera para agua", "Recipiente para drenaje", "Tuberúa de acero galvanizado", "Tubería de cpvc", "Tubería de polietileno reticulado", "Tubería de polipropileno random");
        $rama[11][9] = array("Fluxometro", "Llave para control de fluido", "Trampas", "Válvula de compuerta", "Válvula de esfera", "Válvula de globo", "Válvula de pie pichancha", "Válvula de retención", "Válvula para boiler", "Válvula para flotador", "Válvula para sistema drenaje", "Válvula para tomas domiciliarias", "Válvula para W.C.", "Válvula reductora");

        $rama[12][0] = array("Aromatizantes", "Deodorizantes");
        $rama[12][1] = array("Plaguicidas");
        $rama[12][2] = array("Arneses", "Bandola", "Botas", "Impermeables", "Lonas", "Prendas de alta visibilidad", "Protección auditiva", "Protección desechable", "Protección facial", "Protección lumbar", "Protección para cabeza", "Protección para manos", "Protección para soldar", "Protección respiratoria", "Protección visual", "Rodilleras");
        $rama[12][3] = array("Señalamientos de seguridad");
        $rama[12][4] = array("Mallas", "Telas");

        return $rama;
    }

}

<?php

require_once "nusoap.php";

$server = new soap_server();
$server->configureWSDL("oshiro2", "urn:oshiro2");

$server->register("getTest",
    array(), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#getTest", 
    "rpc", 
    "literal", 
    utf8_decode("Prueba de wsdl."));

$server->register("get_Clientes_autocomplete",
    array(), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#get_Clientes_autocomplete", 
    "rpc", 
    "literal", 
    utf8_decode("Obtener un array de nombres de clientes para autocomplete de Android en formato JSON."));

$server->register("get_ClientesFilter_autocomplete",
    array("cliente" => "xsd:string"), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#get_ClientesFilter_autocomplete", 
    "rpc", 
    "literal", 
    utf8_decode("Obtener un array de nombres de clientes para autocomplete de Android en formato JSON con parametro."));


$server->register("get_Productos_autocomplete",
    array(), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#get_Productos_autocomplete", 
    "rpc", 
    "literal", 
    utf8_decode("Obtener un array de nombres de productos para autocomplete de Android en formato JSON."));

$server->register("get_ProductosFilter_autocomplete",
    array("desc_pro" => "xsd:string"), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#get_ProductosFilter_autocomplete", 
    "rpc", 
    "literal", 
    utf8_decode("Obtener un array de nombres de productos para autocomplete de Android en formato JSON con."));


$server->register("get_producto_byId", 
    array("desc_pro" => "xsd:string"), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#get_producto_byId", 
    "rpc", 
    "literal",  
    utf8_decode("Obtener detalle de un producto mediante ID."));

$server->register("validarUsuario", 
    array("nomb_usu" => "xsd:string", "clav_usu" => "xsd:string"), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#validarUsuario", 
    "rpc", 
    "literal",  
    utf8_decode("Validar usuario de acceso."));

$server->register("register_pedido", 
    array("detalle" => "xsd:string", 
          "subtotal" => "xsd:string",
          "igv" => "xsd:string",
          "total" => "xsd:string",
          "cliente" => "xsd:string",
          'codi_usu' => "xsd:string"), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#register_pedido", 
    "rpc", 
    "literal",  
    utf8_decode("Registrar pedido."));

$server->register("register_cliente", 
    array("usuario" => "xsd:string", 
          "clave" => "xsd:string",
          "dni" => "xsd:string",
          "nombre" => "xsd:string",
          "apellido" => "xsd:string",
          "telefono" => "xsd:string",
          "direccion" => "xsd:string",
          'fecha' => "xsd:string"), 
    array("return" => "xsd:string"), 
    "urn:oshiro2", 
    "urn:oshiro2#register_cliente", 
    "rpc", 
    "literal",  
    utf8_decode("Registrar cliente."));

if (!isset($HTTP_RAW_POST_DATA))
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
$server->service($HTTP_RAW_POST_DATA);

function getTest(){
    return "Mensaje";
}

function get_Clientes_autocomplete() {
    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');
    $resultado = $db->fetch_all_array("SELECT name_usu FROM v_usuario WHERE codi_rol = '3'");
    $autocomplete = array();
    foreach ($resultado as $a) {
        $autocomplete["clientes"][] = $a["name_usu"];
    }
    return utf8_decode(json_encode($autocomplete));
}

function get_ClientesFilter_autocomplete($cliente) {
    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');
    $resultado = $db->fetch_all_array("SELECT * FROM v_usuario WHERE codi_rol = '3' AND (nomb_usu LIKE '%".$cliente."%' OR apel_usu LIKE '%".$cliente."%') limit 0,5;");
    $autocomplete = array();
    foreach ($resultado as $a) {
        $autocomplete[] = json_encode(array($a["name_usu"], $a["dni_usu"], $a["tele_usu"]));
    }
    return utf8_decode(json_encode($autocomplete));
}

function get_Productos_autocomplete() {
    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');
    $resultado = $db->fetch_all_array("SELECT desc_pro FROM v_producto WHERE CAST(stock_pro AS SIGNED INTEGER) > 0");
    $autocomplete = array();
    foreach ($resultado as $a) {
        $autocomplete["productos"][] = $a["desc_pro"];
    }
    return utf8_decode(json_encode($autocomplete));
}

function get_ProductosFilter_autocomplete($desc_pro) {
    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');
    $resultado = $db->fetch_all_array("SELECT * FROM v_producto WHERE desc_pro LIKE '%".$desc_pro."%' limit 0,5;");
    $autocomplete = array();
    foreach ($resultado as $a) {
        $autocomplete[] = json_encode(array($a["desc_pro"], $a["stock_pro"], $a["prec_pro"]));
    }
    return utf8_decode(json_encode($autocomplete));
}

function get_producto_byId($desc_pro) {
    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');
    $resultado = $db->fetch_all_array("SELECT * FROM v_producto WHERE desc_pro = '$desc_pro'");
    return utf8_decode(json_encode(array($resultado[0]["desc_pro"], $resultado[0]["prec_pro"], $resultado[0]["stock_pro"])));
}

function validarUsuario($nomb_usu, $clav_usu) {
    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');
    $resultado = $db->fetch_all_array("SELECT * FROM v_usuario WHERE login_usu = '$nomb_usu' AND clave_usu = '$clav_usu';");
    if (count($resultado) == 1) {
        if ($resultado[0]['codi_rol'] == "2") {
            return utf8_decode($resultado[0]['codi_usu']);
        } else {
            return utf8_decode("Permiso");
        }
    } else {
        return utf8_decode("Incorrecto");
    }
}

function register_pedido($detalle, $subtotal, $igv, $total, $cliente, $codi_usu){

    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');

    $sql = "SELECT * FROM factura ORDER BY fech_fac DESC";

    $fact = $db->fetch_all_array($sql);

    $serie = "";
    if ((int) count($fact) > 0) {
        $number = (int) substr($fact[0]["serie_fac"],1) + 1;
        $longitud = strlen($number);
        $faltante = 7 - $longitud;
        $serie = "F";
        for ($i=1; $i <= $faltante ; $i++) { 
            $serie .= "0";
        }
        $serie .= $number;
    } else {
        $serie = "F0000001";
    }

    $sql = "SELECT * FROM v_usuario WHERE name_usu LIKE '$cliente';";
    $resultado = $db->fetch_all_array($sql);
    $codi_cli = $resultado[0]['codi_usu'];

    $sql = "SELECT * FROM v_usuario WHERE codi_usu ='".$codi_usu."';";
    $vendedor = $db->fetch_all_array($sql);
    $vend_fac = $vendedor[0]["name_usu"]. '. D.N.I.: ' . $vendedor[0]["dni_usu"];

    $detalle_js = json_decode($detalle);

    date_default_timezone_set('America/Lima');
    $sql = "INSERT INTO factura(serie_fac, fech_fac, tota_fac, igv_fac, subt_fac, 
        codi_usu, codi_tpa, vend_fac) VALUES('$serie', '".date("Y-m-d H:i:s")."', 
        '$total', '$igv', '$subtotal', '$codi_cli', '1', '$vend_fac')";
    $db->query($sql);
    $codi_fac = $db->last_id();
    foreach ($detalle_js as $row) {

        $sql = "SELECT * FROM producto WHERE desc_pro LIKE '".$row[0]."';";
        $resultado = $db->fetch_all_array($sql);
        $codi_pro = $resultado[0]['codi_pro'];

        $sql = "INSERT INTO detalle_factura(codi_fac, codi_pro, prec_dfa, cant_dfa, impo_dfa) 
        VALUES('$codi_fac', '$codi_pro', '".$row[2]."', '".$row[1]."', '".$row[3]."')";
        $db->query($sql);
        $sql = "UPDATE producto SET 
                    stock_pro = stock_pro - ".$row[1]." 
                    WHERE codi_pro = '".$codi_pro."';";
        $db->query($sql);
    }

    return 'http://oshiro2.zz.mu/reporte.php?codi_fac='.$codi_fac;
}

function register_cliente($usuario, $clave, $dni, $nombre, $apellido, $telefono, $direccion, $fecha){

    require_once "database.php";
    $db = new Database('mysql.hostinger.es', 'u244796827_admin', 'admin123', 'u244796827_oshir');

    $sql = "SELECT COUNT(*) as cont FROM usuario WHERE login_usu = '".$usuario."';";
    $resultado = $db->fetch_all_array($sql);
    if ($resultado[0]["cont"] !=  "1") {
        
        date_default_timezone_set('America/Lima');
        $sql = "INSERT INTO usuario(login_usu, clave_usu, nomb_usu, apel_usu, dni_usu,
         fena_usu, tele_usu, dire_usu, codi_rol, esta_usu) 
        VALUES('$usuario', '$clave', '$nombre', '$apellido', '$dni', 
            '$fecha', '$telefono', '$direccion', '3', '0')";
        
        $db->query($sql);

        return "OK";

    } else {
        return "Error";
    }
}
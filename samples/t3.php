<?php
/**
  Script inical que recibe una petición de servicios que un script t4 va a consumir
  como cliente del mismo, ara esto se setea un servidor que monta el core del parse
  de dicho set de servicios pequeños a revisar
*/
	require_once "../shared/nusoap/nusoap.php";

	function getProd($categoria) {
	    if ($categoria == "libros") {
	        return join(",", array(
	            "El señor de los anillos",
	            "Los límites de la Fundación",
	            "The Rails Way"));
	    }
	    else {
	        return "No hay productos de esta categoria";
	    }
	}

	$server = new soap_server();
	$server->configureWSDL("producto", "urn:producto");

	$server->register("getProd",
	    array("categoria" => "xsd:string"),
	    array("return" => "xsd:string"),
	    "urn:producto",
	    "urn:producto#getProd",
	    "rpc",
	    "encoded",
	    "Nos da una lista de productos de cada categoría");

	$server->service($HTTP_RAW_POST_DATA);
?>

<?php
/**
  Este es el cliente de t3.php que es el server que administra el flujo para el consumo
  de las solicitudes de servicios
*/
	require_once "../shared/nusoap/nusoap.php";
	$cliente = new nusoap_client("./t3.php");

	$error = $cliente->getError();
	if ($error) {
	    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}

	$result = $cliente->call("getProd", array("categoria" => "libros"));

	if ($cliente->fault) {
	    echo "<h2>Fault</h2><pre>";
	    print_r($result);
	    echo "</pre>";
	}
	else {
	    $error = $cliente->getError();
	    if ($error) {
	        echo "<h2>Error</h2><pre>" . $error . "</pre>";
	    }
	    else {
	        echo "<h2>Libros</h2><pre>";
	        echo $result;
	        echo "</pre>";
	    }
	}
?>

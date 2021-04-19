<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

$persona_juridica_id = $_POST['ID'];


$razon_social = $_POST["razon_social"];
$nro_habilitacion = $_POST["nro_habilitacion"];
$fecha_alta = date($_POST["fecha_alta"]);



$sql1 = "UPDATE personas_juridicas"
	. " SET razon_social = '$razon_social', nro_habilitacion = $nro_habilitacion"
	. " WHERE persona_juridica_id = ". $persona_juridica_id;

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_PERSONA_ERROR';
	header("location: ../listado.php?persona_juridica_id=$persona_juridica_id&mensaje=$mensaje");
	exit;
}


$sql2 = "UPDATE proveedores"
	. " SET proveedor_fecha_alta = '$fecha_alta' "
	. " WHERE rela_persona_juridica = ".$persona_juridica_id;


//echo $sql2;
//exit();

if (!mysqli_query($conexion, $sql2)) {
	$mensaje = 'MODIFICAR_PROVEEDOR_ERROR';
	header("location: ../listado.php?persona_juridica_id=$persona_juridica_id&mensaje=$mensaje");
	exit;
}


$mensaje = 'MODIFICAR_PROVEEDOR_OK';
header("location: ../listado.php?mensaje=$mensaje");

?>
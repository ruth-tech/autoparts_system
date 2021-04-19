<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}


$nombre = $_POST["nombre"];
$nro_habilitacion = $_POST["nro_habilitacion"];



// cuando agrego nueva persona estado = 1
$estado = 1;

// GUARDO PERSONA
$sql1 = "INSERT INTO personas"
	. " (persona_id)"
	. " VALUES ('')";

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'GUARDAR_PERSONA_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}


$persona_id = mysqli_insert_id($conexion);



$sql2 = " INSERT INTO personas_juridicas"
	. " (`rela_persona`,`razon_social`,`nro_habilitacion`)"
   . " VALUES ($persona_id,'$nombre',$nro_habilitacion) ";

//echo $sql2;
//exit();

if (!mysqli_query($conexion, $sql2)) {
	$mensaje = 'GUARDAR_PERSONA_JURIDICA_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}

// obtengo el id insertado en personas
$id_persona_juridica = mysqli_insert_id($conexion);

// obtengo fecha/hora actual
$fecha_alta = date('Y-m-d');

// GUARDO CLIENTE
$sql3 = "INSERT INTO proveedores(`rela_persona_juridica`,`proveedor_fecha_alta`,`estado`)"
	. "VALUES ($id_persona_juridica,'$fecha_alta',$estado)";

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql3)) {
	$mensaje = 'GUARDAR_PROVEEDOR_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}



$mensaje = 'GUARDAR_PROVEEDOR_OK';
header("location: ../listado.php?mensaje=$mensaje");

?>
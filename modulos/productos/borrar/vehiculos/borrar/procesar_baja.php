<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];
$vehiculo_id = $_GET['vehiculo_id'];

// MODIFICO 
$sql = "UPDATE categoriaxvehiculo SET estado = 0 WHERE rela_vehiculo
 = " . $vehiculo_id." and rela_prod_categoria=".$prod_categoria_id;

// echo $sql;
// exit();

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'VEHICULO_ESTADO_UPDATE_ERROR';
	header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'VEHICULO_ESTADO_UPDATE_OK';
header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");

?>
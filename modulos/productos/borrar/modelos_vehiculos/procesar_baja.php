<?php

require '../../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id = $_GET['prod_categoria_id'];

$vehiculo_id=$_GET['vehiculo_id'];

$id=$_GET['modelo_vehiculo_id'];

// MODIFICO 
$sql = "UPDATE modelos_vehiculos SET estado = 0 WHERE modelo_vehiculo_id
 = " . $id;

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'MODELO_ESTADO_UPDATE_ERROR';
	header("location: listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'MODELO_ESTADO_UPDATE_OK';
header("location: listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&mensaje=$mensaje");

?>
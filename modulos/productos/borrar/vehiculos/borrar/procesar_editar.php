<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];
$id = $_POST['ID'];
$descripcion = $_POST["descripcion"];


$sql1 = "UPDATE vehiculos"
	. " SET vehiculo_descripcion = '$descripcion'"
	. " WHERE vehiculo_id = ". $id;

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_VEHICULO_ERROR';
	header("location: listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&mensaje=$mensaje");
	exit;
}


$mensaje = 'MODIFICAR_VEHICULO_OK';
header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");

?>
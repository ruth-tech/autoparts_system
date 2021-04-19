<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];

$vehiculo_id = $_POST["cboVehiculo"];


// cuando agrego nuevo vehiculo estado = 1
$estado = 1;

// insertar a bd

// $sql1 = "INSERT INTO vehiculos(`vehiculo_descripcion`)"
// 	. " VALUES ('$descripcion') ";

//echo $sql1;
//exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
// if (!mysqli_query($conexion, $sql1)) {
// 	$mensaje = 'GUARDAR_VEHICULO_ERROR';
// 	header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");
// 	exit;
// }

// $vehiculo_id=mysqli_insert_id($conexion);

$sql2 = "INSERT INTO categoriaxvehiculo(rela_prod_categoria,rela_vehiculo,estado)"
	. " VALUES ($prod_categoria_id,$vehiculo_id,$estado) ";

//echo $sql1;
//exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql2)) {
	$mensaje = 'GUARDAR_CATEGORIAXVEHICULO_ERROR';
	header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'GUARDAR_VEHICULO_OK';
header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");

?>

<?php

require '../../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];

$vehiculo_id= $_GET['vehiculo_id'];
$descripcion = $_POST['descripcion'];
$modelo_anio=$_POST['modeloanio'];


// cuando agrego nuevo producto estado = 1
$estado = 1;

// insertar a bd
$sql1 = "INSERT INTO `modelos_vehiculos`(`rela_vehiculo`,`modelo_vehiculo_descripcion`,`modelo_vehiculo_anio`,estado)"
	. " VALUES ($vehiculo_id,'$descripcion',$modelo_anio,$estado)";

//echo $sql1;
//exit();

// $rs = $conexion->query($sql1) or die($conexion->error);
// exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'GUARDAR_MODELO_ERROR';
	header("location: listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'GUARDAR_MODELO_OK';
header("location: listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&mensaje=$mensaje");

?>

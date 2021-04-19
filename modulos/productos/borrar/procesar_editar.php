<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$id = $_POST['ID'];
$descripcion = $_POST["descripcion"];


$sql1 = "UPDATE prod_categorias"
	. " SET prod_categoria_descripcion = '$descripcion'"
	. " WHERE prod_categoria_id = ". $id;

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_CATEGORIA_ERROR';
	header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=$mensaje");
	exit;
}


$mensaje = 'MODIFICAR_CATEGORIA_OK';
header("location: listado.php?mensaje=$mensaje");

?>
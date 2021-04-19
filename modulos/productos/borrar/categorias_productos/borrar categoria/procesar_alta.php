<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$descripcion = $_POST["descripcion"];


// cuando agrego  una nueva categoria tiene estado = 1
$estado = 1;

// insertar a bd
$sql1 = "INSERT INTO prod_categorias(`prod_categoria_descripcion`,estado)"
	. " VALUES('$descripcion',$estado)";

//echo $sql1;
//exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'GUARDAR_CATEGORIA_ERROR';
	header("location: listado.php?mensaje=$mensaje");
	exit;
}

$mensaje = 'GUARDAR_CATEGORIA_OK';
header("location: listado.php?mensaje=$mensaje");

?>

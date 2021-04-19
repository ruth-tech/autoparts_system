<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id = $_GET['prod_categoria_id'];

// MODIFICO 
$sql = "UPDATE prod_categorias SET estado = 0 WHERE prod_categoria_id
 = " . $prod_categoria_id;

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'CATEGORIA_ESTADO_UPDATE_ERROR';
	header("location: listado.php?mensaje=$mensaje");
	exit;
}

$mensaje = 'CATEGORIA_ESTADO_UPDATE_OK';
header("location: listado.php?mensaje=$mensaje");

?>
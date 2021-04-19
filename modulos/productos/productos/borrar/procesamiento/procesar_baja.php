<?php

require '../../../../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];

$vehiculo_id=$_GET['vehiculo_id'];

$modelo_vehiculo_id=$_GET['modelo_vehiculo_id'];

$producto_id = $_GET['producto_id'];

// MODIFICO 
$sql = "UPDATE productoxcategoria SET estado = 0 WHERE rela_producto
 = " . $producto_id;

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'PRODUCTO_ESTADO_UPDATE_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'PRODUCTO_ESTADO_UPDATE_OK';
header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&mensaje=$mensaje");

?>
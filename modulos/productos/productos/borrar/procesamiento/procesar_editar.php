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

$productoxcategoria_id=$_GET['productoxcategoria_id'];

$producto_id = $_POST['ID'];
$producto_descripcion = $_POST["descripcion"];
$producto_detalle_fabricante = $_POST["fabricante"];
$cant_actual = $_POST["cant_actual"];
$precio_valor = $_POST["precio"];


$sql1 = "UPDATE productos"
	. " SET producto_descripcion = '$producto_descripcion', producto_detalle_fabricante = '$producto_detalle_fabricante' "
	. " WHERE producto_id = ". $producto_id;

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_PRODUCTO_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&producto_id=$producto_id&mensaje=$mensaje");
	exit;
}

$sql3 = "UPDATE producto_precio "
	. "SET precio_valor =". $precio_valor
	. " where rela_productoxcategoria=".$productoxcategoria_id;

if (!mysqli_query($conexion, $sql3)) {
	$mensaje = 'MODIFICAR_PRECIO_PRODUCTO_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&producto_id=$producto_id&mensaje=$mensaje");
	exit;
}


$sql2 = "UPDATE productoxcategoria"
	. " SET cantidad_actual = $cant_actual "
	. " WHERE rela_producto = ".$producto_id;

//$rs = $conexion->query($sql2) or die($conexion->error);



if (!mysqli_query($conexion, $sql2)) {
	$mensaje = 'MODIFICAR_PRODUCTOXCATEGORIA_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&producto_id=$producto_id&mensaje=$mensaje");
	exit;
}


$mensaje = 'MODIFICAR_PRODUCTO_OK';
header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&producto_id=$producto_id&mensaje=$mensaje");

?>
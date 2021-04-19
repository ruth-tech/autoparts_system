<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

$fecha_compra = $_POST['fecha_compra'];
$proveedor_id = $_POST['proveedor_id'];
$encargado_compra = $_POST['encargado_compra'];
$categoria_id = $_POST['categorias'];
$codigo_producto = $_POST['codigo_producto'];
$cantidad_adquirida = $_POST['cant_adquirida'];
$precio_unitario_compra = $_POST['precio_unit_compra'];

$forma_pago_id = $_POST['forma_pago'];

$total_compra = $cantidad_adquirida * $precio_unitario_compra;

// cuando agrego nueva compra estado = 1
$estado = 1;


$sql = "INSERT INTO productos(`descripcion_producto`,`producto_cantidad_minima`,`observaciones`) VALUES ()";




// GUARDO compra
$sql1 = "INSERT INTO compras(`rela_proveedor`,`fecha_compra`,`total_compra`,`forma_pago`)
VALUES ($proveedor_id,'$fecha_compra',$total_compra,$forma_pago_id)";

//echo $sql1;
//exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'GUARDAR_COMPRA_ERROR';
	header("location: ../listado.php?id_compra=$id_compra&mensaje=$mensaje");
	exit;
}



$mensaje = 'GUARDAR_COMPRA_OK';
header("location: ../listado.php?id_compra=$id_compra&mensaje=$mensaje");

?>

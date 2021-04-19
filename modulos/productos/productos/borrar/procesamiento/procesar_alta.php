<?php

require '../../../../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id = $_GET['prod_categoria_id'];

$vehiculo_id = $_GET['vehiculo_id'];

$modelo_vehiculo_id = $_GET['modelo_vehiculo_id'];


$descripcion = $_POST["descripcion"];

$fabricante_producto = $_POST["fabricante_producto"];

$cant_actual = $_POST["cant_actual"];

$precio = $_POST["precio"];






// cuando agrego nuevo producto estado = 1
$estado = 1;

// GUARDO PRODUCTO
$sql1 = "INSERT INTO productos(`rela_modelo_vehiculo`,`producto_descripcion`,`producto_fecha_ingreso`,`producto_detalle_fabricante`)".
" VALUES ($modelo_vehiculo_id,'$descripcion',CURDATE(),'$fabricante_producto')
";

//echo $sql1;
//exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'GUARDAR_PRODUCTO_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&mensaje=$mensaje");
	exit;
}


$producto_id = mysqli_insert_id($conexion);


$sql3 = "INSERT INTO productoxcategoria(`rela_producto`,`rela_prod_categoria`,`cantidad_actual`,`estado`)".
" VALUES ($producto_id,$prod_categoria_id,$cant_actual,$estado)";

if (!mysqli_query($conexion, $sql3)) {
	$mensaje = 'GUARDAR_PRODUCTOXCATEGORIA_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&mensaje=$mensaje");
	exit;
}

$productoxcategoria_id = mysqli_insert_id($conexion);

$sql2 = "INSERT INTO producto_precio(`rela_productoxcategoria`,`precio_fecha`,`precio_valor`)".
" VALUES ($productoxcategoria_id,CURDATE(),$precio)";



if (!mysqli_query($conexion, $sql2)) {
	$mensaje = 'GUARDAR_PRODUCTO_PRECIO_ERROR';
	header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&mensaje=$mensaje");
	exit;
}


$mensaje = 'GUARDAR_PRODUCTO_OK';
header("location: ../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id&mensaje=$mensaje");

?>

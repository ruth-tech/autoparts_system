<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}


$marca = $_POST['marca'];
$modelo= strtoupper($_POST['descripcion']);
$anio=$_POST['anio'];


// cuando agrego nuevo modelo estado = 1
$estado = 1;

// insertar a bd
$sql1 = "INSERT INTO `modelos_vehiculos`(`rela_vehiculo`,`modelo_vehiculo_descripcion`,estado)"
	. " VALUES ($marca,'$modelo',$estado)";

//echo $sql1;
//exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla modelos_vehiculos!';
    exit();
}

$modelo_id = mysqli_insert_id($conexion);

// insertar a bd
$sql2 = "INSERT INTO `modelos_anio_vehiculos`(`rela_modelo_vehiculo`,`modelo_anio_descripcion`,estado)"
	. " VALUES ($modelo_id,'$anio',$estado)";

// echo $sql2;
// exit();

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql2)) {
	echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla modelos_anio_vehiculos!';
    exit();
}


echo '¡Registro agregado exitosamente!';
       

?>

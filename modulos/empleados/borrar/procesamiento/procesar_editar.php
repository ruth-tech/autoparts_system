<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}


$id = $_POST['ID'];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$dni = $_POST["DNI"];
$cuil=$_POST['cuil'];
$fecha_nacimiento = $_POST["FechaNac"];



$sql1 = "UPDATE personas_fisicas "
	. " SET nombres_persona = '$nombre', apellidos_persona = '$apellido', persona_dni = '$dni',persona_cuil = $cuil, fecha_nacimiento = '$fecha_nacimiento' "
	. " WHERE persona_fisica_id = ". $id;

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_PERSONA_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}



$mensaje = 'MODIFICAR_EMPLEADO_OK';
header("location: ../listado.php?mensaje=$mensaje");

?>
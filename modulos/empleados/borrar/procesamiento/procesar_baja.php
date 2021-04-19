<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

$empleado_id = $_GET['empleado_id'];

// MODIFICO PERSONA
$sql = "UPDATE empleados SET estado = 0 WHERE empleado_id
 = " . $empleado_id;

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'EMPLEADO_ESTADO_UPDATE_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}

$mensaje = 'EMPLEADO_ESTADO_UPDATE_OK';
header("location: ../listado.php?mensaje=$mensaje");

?>
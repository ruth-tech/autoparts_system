<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$persona_id = $_GET['persona_id'];

$persona_contacto_id = $_GET['persona_contacto_id'];

// MODIFICO PERSONA
$sql = "UPDATE persona_contacto SET estado = 0 WHERE rela_persona
 = " . $persona_id." AND persona_contacto_id =".$persona_contacto_id;

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'PERSONA_ESTADO_UPDATE_ERROR';
	header("location: listado.php?persona_id=$persona_id&persona_contacto_id=$persona_contacto_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'PERSONA_ESTADO_UPDATE_OK';
header("location: listado.php?persona_id=$persona_id&persona_contacto_id=$persona_contacto_id&mensaje=$mensaje");
exit();

?>
<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$persona_id = $_POST["persona_id"];
$persona_contacto_id = $_POST["persona_contacto_id"];
$tipo_contacto_id = $_POST["cbotipo_contacto"];
$valor_contacto = $_POST["valor"];


$sql1 = "UPDATE persona_contacto"
	. " SET rela_persona = $persona_id, rela_tipo_contacto = $tipo_contacto_id, valor_contacto = '$valor_contacto'"
	. " WHERE  persona_contacto_id= ". $persona_contacto_id;

// echo $sql1;
// exit();

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_PERSONA_CONTACTO_ERROR';
	header("location: listado.php?persona_id=$persona_id&persona_contacto_id=$persona_contacto_id&mensaje=$mensaje");
	exit;
}


$mensaje = 'MODIFICAR_CONTACTO_OK';
header("location: listado.php?persona_id=$persona_id&persona_contacto_id=$persona_contacto_id&mensaje=$mensaje");

?>
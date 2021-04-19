<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$persona_id = $_GET['id_persona_fisica'];

$sql = " SELECT p.id_persona FROM personas p"
	." INNER JOIN personas_fisicas pf ON p.`id_persona`=pf.`rela_persona` "
	." WHERE pf.id_persona_fisica=".$persona_id;

//echo $sql;
//exit();

$rs_persona = $conexion->query($sql) or die($conexion->error);

$persona = $rs_persona->fetch_assoc();

$id_persona = $persona["id_persona"];

$id_domicilio = $_GET['id_domicilio'];

// MODIFICO PERSONA
$sql = "UPDATE persona_domicilio SET estado = 0 WHERE rela_persona
 = " . $id_persona." AND id_domicilio =".$id_domicilio;

// si no puedo modificar, redirecciono al formulario con mensaje de error
if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'PERSONA_ESTADO_UPDATE_ERROR';
	header("location: listado.php?id_persona_fisica=$persona_id&mensaje=$mensaje");
	exit;
}

$mensaje = 'PERSONA_ESTADO_UPDATE_OK';
header("location: listado.php?id_persona_fisica=$persona_id&mensaje=$mensaje");


?>
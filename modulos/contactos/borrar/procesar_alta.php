<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$persona_id = $_POST["ID"];

// $sql = " SELECT p.id_persona FROM personas p"
// 	." INNER JOIN personas_fisicas pf ON p.`id_persona`=pf.`rela_persona` "
// 	." WHERE pf.id_persona_fisica=".$id;

// //echo $sql;
// //exit();

// $rs_persona = $conexion->query($sql) or die($conexion->error);

// $persona = $rs_persona->fetch_assoc();

// $id_persona = $persona["id_persona"];


$tipo_contacto_id = $_POST["tipo_contacto"];
$valor = $_POST["valor"];

$estado = 1;



$sql = "INSERT INTO persona_contacto(`rela_persona`,`rela_tipo_contacto`,`valor_contacto`,estado)"
	. " VALUES($persona_id,$tipo_contacto_id,'$valor',$estado)";


	
// echo $sql;
// exit();

if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'GUARDAR_CONTACTO_ERROR';
	header("location: listado.php?mensaje=$mensaje&persona_id=$persona_id");
	exit;
} 


$mensaje = 'GUARDAR_CONTACTO_OK';
header("location: listado.php?mensaje=$mensaje&persona_id=$persona_id");

?>
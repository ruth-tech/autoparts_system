<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$persona_id = $_POST["persona_id"];

$id_tipo_domicilio = $_POST["tipo_domi"];
$provincia=$_POST['provincia'];
$id_localidad = $_POST["localidad"];
$barrio = $_POST["barrio"];
$calle = $_POST["calle"];
$altura =$_POST["altura"];
$torre = $_POST["torre"];
$piso = $_POST["piso"];
$manzana = $_POST["manzana"];
$sector=$_POST['sector'];
$parcela = $_POST["parcela"];

$estado = 1;

if ($calle == '') {
	$calle = 'NULL';
}
if ($altura == '') {
	$altura = 'NULL';
}
if ($torre == '') {
	$torre = 'NULL';
}
if ($piso == '') {
	$piso = 'NULL';
}
if ($manzana == '') {
	$manzana = 'NULL';
}
if ($sector == '') {
	$sector = 'NULL';
}
if ($parcela == '') {
	$parcela = 'NULL';
}


$sql = " INSERT INTO `persona_domicilio`(`rela_persona`,`rela_tipo_domicilio`,`rela_barrio`,`calle`,`altura`,`piso`,`torre`,`manzana`,`sector`,`parcela`,`estado`)"
	. " VALUES ( $persona_id, $id_tipo_domicilio, '$barrio', '$calle', $altura, $piso,$torre, $manzana, $sector,$parcela, $estado)";

//echo $sql;
//exit;




if (!mysqli_query($conexion, $sql)) {
	$mensaje = 'GUARDAR_DOMICILIO_ERROR';
	header("location: listado.php?prsona_id=$persona_id&mensaje=$mensaje");
	exit;
} 


$mensaje = 'GUARDAR_DOMICILIO_OK';
header("location: listado.php?persona_id=$persona_id&mensaje=$mensaje");

?>
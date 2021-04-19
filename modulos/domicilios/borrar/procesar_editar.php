<?php

require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

$id_persona = $_POST["id_persona"];
$id_persona_fisica = $_POST["id_persona_fisica"];
$id_domicilio = $_POST["id_domicilio"];
$id_tipo_domi= $_POST["cbotipo_domi"];
$id_localidad = $_POST["cbo_localidad"];
$barrio = $_POST["barrio"];
$calle = $_POST["calle"];
$altura = $_POST["altura"];
$piso = $_POST["piso"];
$torre = $_POST["torre"];
$manzana = $_POST["manzana"];
$parcela = $_POST["parcela"];

if ($calle == '') {
	$calle = ' ';
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
if ($parcela == '') {
	$parcela = 'NULL';
}


$sql1 = "UPDATE persona_domicilio"
	. " SET rela_tipo_domicilio = $id_tipo_domi, barrio = '$barrio', calle = '$calle', altura = $altura, piso = $piso, torre = $torre, manzana = $manzana, sector_parcela = $parcela, rela_localidad = $id_localidad "
	. " WHERE  id_domicilio= ". $id_domicilio;

//echo $sql1;
//exit();

//$rs = $conexion->query($sql1) or die($conexion->error);

if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'MODIFICAR_PERSONA_DOMICILIO_ERROR';
	header("location: listado.php?id_persona_fisica=$id_persona_fisica&mensaje=$mensaje");
	exit;
}


$mensaje = 'MODIFICAR_DOMICILIO_OK';
header("location: listado.php?id_persona_fisica=$id_persona_fisica&mensaje=$mensaje");

?>
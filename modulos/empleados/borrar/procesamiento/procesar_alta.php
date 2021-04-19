<?php

require '../../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}


$nombre = $_POST["nombre"];  
$apellido = $_POST["apellido"];
$dni = $_POST["dni"];
$cuil = $_POST["cuil"];
$sexo = $_POST["sexo"];
$fecha_nac= date($_POST["fchNac"]);
$nacionalidad = $_POST["nacionalidad"];
$perfil = $_POST["perfil"];
$name_user=$_POST['name_user'];
$password=$_POST['password_user'];



// cuando agrego nueva persona estado = 1
$estado = 1;

// GUARDO PERSONA
$sql1 = "INSERT INTO personas(persona_id)"
	. " VALUES ('')";

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql1)) {
	$mensaje = 'GUARDAR_PERSONA_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}


$persona_id = mysqli_insert_id($conexion);



$sql2 = " INSERT INTO personas_fisicas(`rela_persona`,`apellidos_persona`,`nombres_persona`,`persona_sexo`,`persona_dni`,`persona_cuil`,`persona_fecha_nac`,`persona_nacionalidad`)"
   . " VALUES ($persona_id,'$apellido','$nombre', '$sexo', $dni,'$cuil',$fecha_nac,'$nacionalidad' ) ";

 //$rs_persona = $conexion->query($sql2) or die($conexion->error);

if (!mysqli_query($conexion, $sql2)) {
	$mensaje = 'GUARDAR_PERSONA_FISICA_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}


// obtengo el id insertado en personas
$persona_fisica_id = mysqli_insert_id($conexion);

// obtengo fecha/hora actual


// GUARDO empleado
$sql3 = "INSERT INTO empleados(`rela_persona_fisica`,`empleado_fecha_alta`,`estado`)"
	. " VALUES ($persona_fisica_id,CURDATE(),$estado)";

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql3)) {
	$mensaje = 'GUARDAR_EMPLEADO_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}

$sql3 = "INSERT INTO usuarios(`rela_persona`,`usuario_nombre`,`usuario_password`,`usuario_fecha_alta`,`rela_perfil`)"
	. " VALUES ($persona_id,'$name_user','$password',CURDATE(),$perfil)";

// si no puedo guardar, redirecciono al listado con mensaje de error
if (!mysqli_query($conexion, $sql3)) {
	$mensaje = 'GUARDAR_USUARIO_ERROR';
	header("location: ../listado.php?mensaje=$mensaje");
	exit;
}



$mensaje = 'GUARDAR_EMPLEADO_OK';
header("location: ../listado.php?mensaje=$mensaje");

?>
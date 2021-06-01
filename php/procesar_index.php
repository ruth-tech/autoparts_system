<?php

require 'conexion.php';
require '../funciones/obtener_modulos.php';

$usuario = $_POST['txtUsuario'];
$password = $_POST['txtPassword'];

$sql = "SELECT usuario_id, rela_persona FROM usuarios "
     . "WHERE usuario_nombre='$usuario' AND usuario_password='$password'";

$rs_usuario = mysqli_query($conexion, $sql);

$cantidad = mysqli_num_rows($rs_usuario);

// Si la cantidad es 0 (cero), entonces no existe usuario.
// Redirijo al formulario de login, con una variable error por metodo GET.
if ($cantidad == 0) {
	header('location: ../index.php?error=login_error');
exit;
}

// En caso de que cantidad sea mayor a 0 (cero), entonces hay que seguir validando
// Obtenemos el id_persona del usuario, de la consulta anterior.
$user = $rs_usuario->fetch_assoc();

// Consultamos por el estado del usuario: 1 = activo y 0 = inactivo
$sql = "SELECT * FROM personas_fisicas "
	 . "WHERE rela_persona=" . $user['rela_persona'];
	 
// echo $sql;
// exit();

$rs_persona = mysqli_query($conexion, $sql);

$persona = $rs_persona->fetch_assoc();

// Si el estado de la persona es = 1, entonces hago el login
// Si el estado de la persona es = 0, entonces persona inactiva
/*if ($persona['estado'] == 0) {
	// Redirijo al formulario de login, con una variable error por metodo GET.
	header('location: ../iniciar_sesion.php?error=usuario_inactivo');
	exit;
}*/

// Si el usuario esta activo, entonces hay que crear sesión
session_start();
$_SESSION['logueado'] = true;
$_SESSION['usuario'] = $persona['apellidos_persona'].", ".$persona['nombres_persona'];
$_SESSION['persona_id'] = $user['rela_persona'];
$_SESSION['id'] = $user['usuario_id'];

// Llamada a la función para obtener módulos.
// Esta función develve un array con el id y descripción de los módulos.
$modulos = obtener_modulos($user['rela_persona']);

// Este array de módulos lo asigno a una variable de sesión.
$_SESSION["modulos"] = $modulos;

// Luego de crear la sesión debemos redireccionar
header('location: ../dashboard.php');

?>











?>
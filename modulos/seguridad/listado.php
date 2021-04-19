<?php


require '../../php/conexion.php';

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}




?>





<!DOCTYPE html>
<html>
<head>
	<title>Seguridad</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>

		<?php require '../../php/menu.php'; ?>

	<div align="center">

	<h1>Menú de seguridad</h1>

	<p><a href="usuarios/listado.php">Usuarios</a>||<a href="modulos/listado.php">Modulos</a>||<a href="perfiles/listado.php">Perfiles</a></p>

	<p><a href="../../dashboard.php">Volver</a></p>

	


	</div>
</body>
</html>

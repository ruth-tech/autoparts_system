<?php 

require('../../php/conexion.php');

session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Buscar un Empleado</title>
	<link rel="stylesheet" href="">
</head>
<body>

	<h1><b>Búsqueda de Empleado</h1>
	<p>
		<a href='listado.php'>Listado</a> || 
		<a href="alta_empleado.php">Crear nuevo</a> 
	</p>
	<br>
	<form action="procesamiento/procesar_buscar.php" method="post">
		<label for="">Filtro de búsqueda:</label>
		<input type="text" name="filtro" placeholder="Ingrese nombre o email">
		<button type="submit">Buscar</button>
	</form>

</body>
</html>
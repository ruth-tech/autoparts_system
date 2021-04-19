<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Buscar una categoria</title>
	<link rel="stylesheet" href="">
</head>
<body>

	<h1><b>Búsqueda de Categorias</h1>
	<p>
		<a href='listado.php'>Listado</a> || 
		<a href="alta_categoria.php">Crear nuevo</a> 
	</p>
	<br>
	<form action="procesar_buscar.php" method="post">
		<label for="">Filtro de búsqueda:</label>
		<input type="text" name="filtro" placeholder="Ingrese alguna descripcion">
		<button type="submit">Buscar</button>
	</form>

</body>
</html>
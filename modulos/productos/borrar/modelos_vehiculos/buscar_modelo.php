<?php

require ('../../../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../../../index.php?error=debe_loguearse");
  exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];
$vehiculo_id=$_GET['vehiculo_id'];

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Buscar un modelo</title>
	<link rel="stylesheet" href="">
</head>
<body>

	<h1><b>Búsqueda de Modelos de vehiculos</h1>
	<p>
		<a href='listado.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>'>Listado</a> || 
		<a href="alta_categoria.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">Crear nuevo</a> 
	</p>
	<br>
	<form action="procesar_buscar.php?prod_categoria_id=<?php echo $prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>" method="post">
		<label for="">Filtro de búsqueda:</label>
		<input type="text" name="filtro" placeholder="Ingrese alguna descripcion">
		<button type="submit">Buscar</button>
	</form>

</body>
</html>
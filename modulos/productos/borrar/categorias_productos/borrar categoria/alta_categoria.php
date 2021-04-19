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
	<title>Nueva categoria</title>
</head>
<body>
  <div align="center">

	 <h1>Alta de Categorias</h1>


    <p>
      <a href="listado.php">Lista de Categorias</a> ||
      <a href="buscar_categoria.php">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesar_alta.php">


      <h3>Ingrese los datos de la Categoria</h3>
      <p>
        <label>Descripcion: </label>
        <input type="text" name="descripcion" placeholder="INGRESE EN MAYUSCULAS">
        </label>
      </p>
      

      <p>
        <button type="button" onclick="window.history.go(-1); return false;">Cancelar</button> &nbsp;
        <input type="submit" value="Guardar">
      </p>
    </form>
  </div>
</body>
</html>
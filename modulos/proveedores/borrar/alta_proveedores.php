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
	<title>Nuevo Proveedor</title>
</head>
<body>
  <div align="center">

	 <h1>Alta de Proveedores</h1>


    <p>
      <a href="listado.php">Lista de Proveedores</a> ||
      <a href="buscar.php">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesamiento/procesar_alta.php">
      <table border="1" cellpadding="2" cellspacing="0">
      <tbody>

      <h3>Ingrese los datos del Proveedor</h3>
      <tr>
        <td>Nombre o Razon Social: </td>
        <td><input type="text" name="nombre"></td>
      </tr>
        <tr>
        <td>Nro de habilitacion: </td>
        <td><input type="text" name="nro_habilitacion" placeholder="Debe contener 9 digitos" maxlength="9"></td>
        
      </tr>
            
      </tbody>
    </table>
    
      <p><button type="button" onclick="window.history.go(-1); return false;">Cancelar</button> &nbsp;
      <input type="submit" value="Guardar"></p>
    
     
    </form>
  </div>
</body>
</html>
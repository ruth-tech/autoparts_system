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
	<title>Nuevo Modelo</title>
</head>
<body>
  <div align="center">

	 <h1>Alta de Modelo</h1>


    <p>
      <a href="listado.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">Lista de Modelos</a> ||
      <a href="buscar_modelo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesar_alta.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">


      <h3>Ingrese los datos del Modelo </h3>
    
      <p>

        <label>Descripcion: </label>
        <input type="text" name="descripcion" placeholder="INGRESE EN MAYUSCULAS">
        </label> 
      </p>

      <p>

        <label>Modelo año: </label>
        <input type="text" name="modeloanio" >
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
<?php

require ('../../../../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../../../../index.php?error=debe_loguearse");
  exit;
}

$prod_categoria_id = $_GET['prod_categoria_id'];
$vehiculo_id = $_GET['vehiculo_id'];
$modelo_vehiculo_id = $_GET['modelo_vehiculo_id'];





?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nuevo Producto</title>
</head>
<body>
  <div align="center">

	 <h1>Alta de Productos</h1>


    <p>
      <a href="listado.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>">Lista de Productos</a> ||
      <a href="buscar_producto.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesamiento/procesar_alta.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>">


      <h3>Ingrese los datos del producto</h3>
      <p>
        <label>Descripcion del producto: </label>
        <input type="text" name="descripcion">
        </label>
      </p>
      
      <p>
        <label>Fabricante del producto: </label>
        <input type="text" name="fabricante_producto" >
        </label>
      </p>
      <p>
        <label>Cantidad actual: </label>
        <input type="text" name="cant_actual" >
        </label>
      </p>
      
      <p>
        <label>Precio:</label>
        <input type="text" name="precio" >
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
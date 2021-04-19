<?php

require ('../../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../../index.php?error=debe_loguearse");
  exit;
}


$prod_categoria_id=$_GET['prod_categoria_id']; 

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nuevo vehiculo</title>
</head>
<body>
  <div align="center">

	 <h1>Alta de Vehiculos</h1>


    <p>
      <a href="listado.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">Lista de Vehiculos</a> ||
      <a href="buscar_vehiculo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesar_alta.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">


      <h3>Seleccione los vehiculos que quiere agregar</h3>
      <p>
        <label>Vehiculos</label>
        <select name="cboVehiculo">
        <option value="">--SELECCIONE--</option>
        <?php 
        $vehiculos = $conexion->query("SELECT * FROM vehiculos") or die ("Error de SQL");
        while ($row = $vehiculos->fetch_assoc()) {
          echo '<option VALUE="'.$row['vehiculo_id'].'">'.$row['vehiculo_descripcion'].'</option>'  ;
        }

        ?>
      </select>
      </p>
      

      <p>
        <button type="button" onclick="window.history.go(-1); return false;">Cancelar</button> &nbsp;
        <input type="submit" value="Guardar">
      </p>
    </form>
  </div>
</body>
</html>
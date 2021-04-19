<?php

require ('../../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../../index.php?error=debe_loguearse");
  exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];

$id = $_GET['vehiculo_id'];



$sql = "SELECT * FROM vehiculos "
  
  . " WHERE `vehiculo_id` = ". $id;


$rs_vehiculos = $conexion->query($sql) or die($conexion->error);


$vehiculos = $rs_vehiculos->fetch_assoc();





if (!$vehiculos) {
  header("location: listado.php?prod_categoria_id=$prod_categoria_id&mensaje=NO_EXISTE_VEHICULO");
  exit;
}


?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <div align='center'>
    <?php require '../../../php/menu.php'; ?>

    <?php if (isset($mensaje)): ?>
        <h3><font color="red"><?php echo $mensaje; ?></font></h3>
      <?php endif; ?>
  
    <h1><b>Datos del vehiculo:</b></h1>
    <form method="POST" action="procesar_editar.php?prod_categoria_id=<?php echo $prod_categoria_id;?>">
      <input type="hidden" name="ID" value="<?php echo $vehiculos['vehiculo_id']; ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
          <tr>
            <td>Descripcion: </td>
            <td>
              <input
                type="text"
                name="descripcion"
                value = <?php echo utf8_encode($vehiculos['vehiculo_descripcion']); ?>>
            </td>
          </tr>
          
            <tr>
              <td colspan="2">
                <input type="submit" value="Guardar">
              </td>
            </tr>
        </tbody>
      </table>
    </form>
  </div>
</body>
</html>
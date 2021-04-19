<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}

//recibimos el id de la categoria que queremos editar y lo guardamos en una variable


$id = $_GET['prod_categoria_id'];


$sql = "SELECT * FROM prod_categorias "
  . " WHERE `prod_categoria_id` = ". $id;


$rs_categoria = $conexion->query($sql) or die($conexion->error);


$categorias = $rs_categoria->fetch_assoc();





if (!$categorias) {
  header("location: listado.php?mensaje=NO_EXISTE_CATEGORIA");
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
    <?php require '../../php/menu.php'; ?>

    <?php if (isset($mensaje)): ?>
        <h3><font color="red"><?php echo $mensaje; ?></font></h3>
      <?php endif; ?>
  
    <h1><b>Datos de la categoria:</b></h1>
    <form method="POST" action="procesar_editar.php">
      <input type="hidden" name="ID" value="<?php echo $categorias['prod_categoria_id']; ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
          <tr>
            <td>Descripcion: </td>
            <td>
              <input
                type="text"
                name="descripcion"
                value = <?php echo utf8_encode($categorias['prod_categoria_descripcion']); ?>>
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
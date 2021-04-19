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

$producto_id=$_GET['producto_id'];



$sql = "SELECT * FROM productoxcategoria"
  . " WHERE `rela_prod_categoria` = ". $prod_categoria_id.
  " and rela_producto=".$producto_id;


$rs_productoXcategoria = $conexion->query($sql) or die($conexion->error);

$productoxcategoria = $rs_productoXcategoria->fetch_assoc();

$productoxcategoria_id=$productoxcategoria['productoxcategoria_id'];


$sql = "SELECT * FROM productos "
  . "WHERE producto_id=".$producto_id
  . " and rela_modelo_vehiculo=". $modelo_vehiculo_id;

$rs_productos = $conexion->query($sql) or die ($conexion->error);

$productos = $rs_productos->fetch_assoc();

$sql = "SELECT * FROM producto_precio"
  . " WHERE rela_productoxcategoria =".$productoxcategoria_id;

$rs_precio = $conexion->query($sql) or die ($conexion->error);

$precio = $rs_precio->fetch_assoc();

?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <div align='center'>
    <?php require '../../../../../php/menu.php'; ?>

    <?php if (isset($mensaje)): ?>
        <h3><font color="red"><?php echo $mensaje; ?></font></h3>
      <?php endif; ?>
  
    <h1><b>Datos del cliente:</b></h1>
    <form method="POST" action="procesamiento/procesar_editar.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>&productoxcategoria_id=<?php echo$productoxcategoria_id;?>">
      <input type="hidden" name="ID" value="<?php echo $producto_id ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
          <tr>
            <td>Descripcion: </td>
            <td>
              <input
                type="text"
                name="descripcion"
                value = <?php echo utf8_encode($productos['producto_descripcion']); ?>>
            </td>
          </tr>
          <tr>
            <td>Fabricante: </td>
            <td>
              <input
                type="text"
                name="fabricante"
                value = <?php echo utf8_encode($productos['producto_detalle_fabricante']); ?>>
            </td>
          </tr>
          <tr>
            <td>Cantidad Actual: </td>
            <td>
              <input
                type="text"
                name="cant_actual"
                value=<?php echo utf8_encode($productoxcategoria['cantidad_actual']); ?>>
            </td>
          </tr>
          <tr>
            <td>Precio: </td>
            <td>
              <input
                type="text"
                name="precio"
                value=<?php echo $precio['precio_valor']; ?>>
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
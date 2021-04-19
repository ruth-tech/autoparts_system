<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


$persona_juridica_id = $_GET['persona_juridica_id'];



$sql = "SELECT * FROM personas_juridicas "
  . " WHERE `persona_juridica_id` = ". $persona_juridica_id;


$rs_persona = $conexion->query($sql) or die($conexion->error);

$personas_juridicas = $rs_persona->fetch_assoc();

$sql = "SELECT * FROM proveedores "
  . "WHERE rela_persona_juridica = ".$persona_juridica_id;

$rs_proveedores = $conexion->query($sql) or die ($conexion->error);


$proveedores = $rs_proveedores->fetch_assoc();


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
  
    <h1><b>Datos del Proveedor:</b></h1>
    <form method="POST" action="procesamiento/procesar_editar.php">
      <input type="hidden" name="ID" value="<?php echo $personas_juridicas['persona_juridica_id']; ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
          <tr>
            <td>Nombre o razon social: </td>
            <td>
              <input
                type="text"
                name="razon_social"
                value = <?php echo utf8_encode($personas_juridicas['razon_social']); ?>>
            </td>
          </tr>
          <tr>
            <td>Nro de habilitacion: </td> 
            <td>
              <input
                type="text"
                name="nro_habilitacion"
                value=<?php echo utf8_encode($personas_juridicas['nro_habilitacion']); ?>
                maxlength="9">

            </td>
          </tr>
          <tr>
          <td>Fecha alta: </td>
            <td>
             <input 
             type="date" 
             name="fecha_alta"
             value=<?php echo utf8_encode($proveedores['proveedor_fecha_alta']); ?>>
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
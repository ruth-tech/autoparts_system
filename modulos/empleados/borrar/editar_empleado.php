<?php
 
require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


$id_persona_fisica = $_GET['persona_fisica_id'];


$sql = "SELECT * FROM personas_fisicas "
   . " WHERE `persona_fisica_id` = ". $id_persona_fisica;

$rs_persona = $conexion->query($sql) or die($conexion->error);

$persona = $rs_persona->fetch_assoc();

$sql = "SELECT * FROM empleados "
  . " WHERE rela_persona_fisica =".$id_persona_fisica;

$rs_empleado = $conexion->query($sql) or die ($conexion->error);

$empleados = $rs_empleado->fetch_assoc();





if (!$persona) {
  header("location: listado.php?mensaje=NO_EXISTE_PERSONA");
  exit;
}

//COMPROBAR SI LA CONSULTA FUNCIONA 
/*if($conexion->query($sql)!==False){ 
    echo "Éxito"; 
}else{ 
    echo "Falló"; 
} */

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
  
    <h1><b>Datos del Empleado:</b></h1>
    <form method="POST" action="procesamiento/procesar_editar.php">
      <input type="hidden" name="ID" value="<?php echo $persona['persona_fisica_id']; ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
          <tr>
            <td>Nombre: </td>
            <td>
              <input
                type="text"
                name="nombre"
                value =<?php echo utf8_encode($persona['nombres_persona']); ?>>
            </td>
          </tr>
          <tr>
            <td>Apellido: </td>
            <td>
              <input
                type="text"
                name="apellido"
                value=<?php echo utf8_encode($persona['apellidos_persona']); ?>>
            </td>
          </tr>
          
          <tr>
            <td>DNI: </td>
            <td>
              <input
                type="text"
                name="DNI"
                value="<?php echo $persona['persona_dni']; ?>">
              </td>
          </tr>

          <tr>
            <td>Cuil: </td>
            <td>
              <input
                type="text"
                name="cuil"
                value="<?php echo $persona['persona_cuil']; ?>">
              </td>
          </tr>
  
          <tr>
            <td>Fecha de Nacimiento: </td>
            <td>
              <input
                type="date"
                name="FechaNac"
                value="<?php echo $persona['persona_fecha_nac']; ?>">
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
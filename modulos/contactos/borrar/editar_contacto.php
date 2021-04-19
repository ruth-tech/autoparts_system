<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


$persona_id = $_GET["persona_id"];
$persona_contacto_id=$_GET['persona_contacto_id'];

// $sql = " SELECT * FROM personas "
//   ." INNER JOIN personas_fisicas ON p.`id_persona`=pf.`rela_persona` "
//   ." WHERE pf.id_persona_fisica=".$id;

// //echo $sql;
// //exit();

// $rs_persona = $conexion->query($sql) or die($conexion->error);

// $persona = $rs_persona->fetch_assoc();

// if (!$persona) {
//   header("location: listado.php?mensaje=NO_EXISTE_PERSONA");
//   exit;
// }

// $id_persona = $persona["id_persona"];


$sql = "SELECT * FROM persona_contacto WHERE persona_contacto_id =". $persona_contacto_id;

//echo $sql;
//exit();

$rs_persona_contacto = $conexion->query($sql) or die($conexion->error);

$persona_contacto = $rs_persona_contacto->fetch_assoc();





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
  
    <h1><b>Datos de contacto:</b></h1>
    <form method="POST" action="procesar_editar.php">
      <input type="hidden" name="persona_id" value="<?php echo $persona_id; ?>">
      <input type="hidden" name="persona_contacto_id" value="<?php echo $persona_contacto_id; ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
         
          <tr>
           <td>Tipo contacto: </td>
            <td>
              <select name="cbotipo_contacto">
                <?php
                $tipo_contacto = $conexion->query("SELECT * FROM tipo_contacto") or die ("Error de SQL");
                 while ($row = $tipo_contacto->fetch_assoc()) :?>

                  <?php
                  if ($persona_contacto['rela_tipo_contacto'] == $row['tipo_contacto_id']):
                    $selected = 'SELECTED';
                  else:
                    $selected = '';
                  endif;
                  ?>

                  <option value="<?php echo $row['tipo_contacto_id']; ?>" <?php echo $selected; ?>>
                    <?php echo $row["tipo_contacto_descripcion"]; ?>
                    </option>
                  <?php endwhile; ?>
              </select>
              </td>
          </tr>
          <tr>
            <td>Valor: </td>
            <td>
              <input
                type="text"
                name="valor"
                value=<?php echo utf8_encode($persona_contacto['valor_contacto']); ?>>
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
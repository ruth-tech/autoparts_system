<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


$id = $_GET["id_persona_fisica"];
$id_domicilio=$_GET['id_domicilio'];

$sql = " SELECT p.id_persona FROM personas p"
  ." INNER JOIN personas_fisicas pf ON p.`id_persona`=pf.`rela_persona` "
  ." WHERE pf.id_persona_fisica=".$id;

//echo $sql;
//exit();

$rs_persona = $conexion->query($sql) or die($conexion->error);

$persona = $rs_persona->fetch_assoc();

if (!$persona) {
  header("location: listado.php?mensaje=NO_EXISTE_PERSONA");
  exit;
}

$id_persona = $persona["id_persona"];


$sql = "SELECT * FROM persona_domicilio pd "
  . " INNER JOIN personas p ON pd.rela_persona = p.id_persona"
  . " WHERE pd.id_domicilio =". $id_domicilio;

//echo $sql;
//exit();

$rs_persona_domicilio = $conexion->query($sql) or die($conexion->error);

$persona_domicilio = $rs_persona_domicilio->fetch_assoc();







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
  
    <h1><b>Datos del domicilio:</b></h1>
    <form method="POST" action="procesar_editar.php">
      <input type="hidden" name="id_persona" value="<?php echo $id_persona; ?>">
      <input type="hidden" name="id_persona_fisica" value="<?php echo $id; ?>">
      <input type="hidden" name="id_domicilio" value="<?php echo $id_domicilio; ?>">
      <table border="1" cellpadding="2" cellspacing="0">
        <tbody>
         <p><tr>
            <td>Tipo Domcilio:</td>
                <td>
                <select name="cbotipo_domi">
                  
                  <?php 
                    $tipo_domi = $conexion->query("SELECT * FROM tipo_domicilio") or die ("Error de SQL");
                    while ($row = $tipo_domi->fetch_assoc()) :?>

                  <?php
                  if ($persona_domicilio['rela_tipo_domicilio'] == $row['id_tipo_domicilio']):
                    $selected = 'SELECTED';
                  else :  
                    $selected ='';
                  endif;
                  ?>


                  <option VALUE=<?php echo $row['id_tipo_domicilio']; ?> <?php echo $selected; ?> ><?php echo $row['descripcion_tipo_domicilio'];?> 
                </option> 
                  <?php endwhile;  ?>
                </select>
                </td>

          </tr></p>
          <p><tr>
          <td>Localidad:</td>
                <td><select name="cbo_localidad">
                  
                  <?php 
                    $localidad = $conexion->query("SELECT * FROM localidades") or die ("Error de SQL");
                    while ($row = $localidad->fetch_assoc()) :?>

                  <?php
                  if ($persona_domicilio['rela_localidad'] == $row['id_localidad']):
                    $selected = 'SELECTED';
                  else :  
                    $selected ='';
                  endif;
                  ?>
        
                  <option VALUE=<?php echo $row['id_localidad']; ?> <?php echo $selected; ?>> <?php echo $row['descripcion_localidad'];?></option>  
                  <?php endwhile;  ?>
                </select>
                </td>

          </tr></p>
          <p><tr>
            <td>Barrio: </td>
            <td>
              <input
                type="text"
                name="barrio"
                value=<?php echo utf8_encode($persona_domicilio['barrio']); ?>>
            </td>
          </tr></p>
          <p><tr>
            <td>Calle: </td>
            <td>
              <input
                type="text"
                name="calle"
                value=<?php echo utf8_encode($persona_domicilio['calle']); ?>>
            </td>
          </tr></p>
          <p><tr>
            <td>Altura: </td>
            <td>
              <input
                type="text"
                name="altura"
                value=<?php echo ($persona_domicilio['altura']); ?>>
            </td>
          </tr></p>
          <p><tr>
            <td>Torre: </td>
            <td>
              <input
                type="text"
                name="torre"
                value=<?php echo ($persona_domicilio['torre']); ?>>
            </td>
          </tr></p>
          <p><tr>
            <td>Piso: </td>
            <td>
              <input
                type="text"
                name="piso"
                value=<?php echo ($persona_domicilio['piso']); ?>>
            </td>
          </tr></p>
          <p><tr>
            <td>Manzana: </td>
            <td>
              <input
                type="text"
                name="manzana"
                value=<?php echo ($persona_domicilio['manzana']); ?>>
            </td>
          </tr></p>
          <p><tr>
            <td>Parcela: </td>
            <td>
              <input
                type="text"
                name="parcela"
                value=<?php echo ($persona_domicilio['sector_parcela']); ?>>
            </td>
          </tr></p>
            <p><tr>
              <td colspan="5">
                <input type="submit" value="Guardar">
              </td>
            </tr></p>
        </tbody>
      </table>
    </form>
  </div>
</body>
</html>
<?php
require '../../../php/conexion.php';

session_start();
  
// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location:../../../index.php?error=debe_loguearse");
  exit;
}    

$modelo = $_POST['modelo'];
// $checkBox = implode(',', $_POST['checkbox']);
// echo $modelo,'-',$checkBox;
//CUANDO DOY DE ALTA A UNA CATEGORIA EL ESTADO ES = 1
$estado = 1;
if(!empty($_POST['checkbox'])) {
  foreach($_POST['checkbox'] as $checkbox) {
    // echo $modelo,'-',$checkbox. "\n" ;  //Mostramos el resultaso seleccionado. 
    $insert = "INSERT INTO categoriaxmodelo(rela_modelo_anio,rela_categoria,estado) VALUES($modelo,$checkbox,$estado)";
      if (mysqli_query($conexion, $insert)) {
          //$mensaje = 'GUARDAR_PERSONA_FISICA_ERROR';
          //header("location: ../listado.php?mensaje=$mensaje");
      }else{
        echo '!Ha ocurrido un error en la carga a la base de datos!';
        exit();
      }               
  }
}

echo "Los datos se insertaron correctamente";

//Continuas con tu código para guardar tus datos.
?>

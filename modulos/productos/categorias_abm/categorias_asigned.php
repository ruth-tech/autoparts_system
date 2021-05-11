<?php
require '../../../php/conexion.php';

session_start();
  
// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location:../../../index.php?error=debe_loguearse");
  exit;
}    

$modelo = $_POST['modelo'];
$checkBox = implode(',', $_POST['checklista']);
echo $modelo,'-',$checkBox;
// if(!empty($_POST['checklista'])) {
//     foreach($_POST['checklista'] as $checklista) {
//         echo $modelo,'-',$checklista; //Mostramos el resultaso seleccionado.                
//     }
// }

//Continuas con tu código para guardar tus datos.
?>

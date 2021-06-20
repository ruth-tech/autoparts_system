<?php

include '../../../php/conexion.php';
session_start();
 // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

        
  $usuario = $_POST['usuarioid'];
  
  $sql = "SELECT * from usuarios where usuario_id = $usuario";
  $rs = mysqli_query($conexion,$sql);
  $json = array();

  while($row = mysqli_fetch_array($rs)){
    $json[] = array(
     'user'=>$row['usuario_nombre'],
     'pass'=>$row['usuario_password']         
    );
    
      
  }
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;

?>
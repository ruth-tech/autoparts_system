<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

    $categoriaid = $_POST['categoriaid'];
  
    $sql = "SELECT * FROM prod_categorias "
    . " WHERE `prod_categoria_id` = ". $categoriaid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       "categoriaid"=>$categoriaid,  
       "descripcion"=>preg_replace('([^A-Za-z0-9 ])', '', $row['prod_categoria_descripcion'])           
      );      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
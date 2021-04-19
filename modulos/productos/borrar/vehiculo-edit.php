<?php
    require '../../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../../index.php?error=debe_loguearse");
      exit;
    }

    $idcategoria = $_POST['idcategoria'];
    $idvehiculo = $_POST['idvehiculo'];
  
    $sql = "SELECT * FROM categoriaxvehiculo"
    ." INNER JOIN vehiculos ON categoriaxvehiculo.rela_vehiculo= vehiculos.vehiculo_id"
    ." WHERE `rela_prod_categoria` = ". $idcategoria
    ." AND vehiculo_id = ".$idvehiculo;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       "idcategoria"=>$idcategoria, 
       "idvehiculo"=>$idvehiculo, 
       "descripcion"=>preg_replace('([^A-Za-z0-9 ])', '', $row['vehiculo_descripcion'])           
      );      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
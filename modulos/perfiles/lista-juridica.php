<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }
    $personaid = $_GET['personaid'];
   
    $json = array();   

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_juridicas ON 
    personas.`persona_id` = personas_juridicas.`rela_persona`"    
    . " WHERE personas.`persona_id`=".$personaid;


    $rs_per = $conexion->query($sql) or die($conexion->error);

    while($row = mysqli_fetch_array($rs_per)){
        $json[]= array(   
            "personaid" =>$personaid,             
            "cuit" => $row['cuit'],
            "razonsocial" => $row['razon_social'],
            "nrohabilitacion"=> $row['nro_habilitacion']
        );
    }
    
    $jsonstring=json_encode($json);
    echo $jsonstring;
   
?>
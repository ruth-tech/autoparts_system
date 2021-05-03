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

    $sql = "SELECT
                personas.persona_id AS id,
                personas_juridicas.cuit AS cuit,
                personas_juridicas.razon_social AS razonsocial,
                personas_juridicas.nro_habilitacion AS habilitacion"
    ." FROM personas"
    . " INNER JOIN personas_juridicas ON 
    personas.`persona_id` = personas_juridicas.`rela_persona`"    
    . " WHERE personas.`persona_id`=".$personaid;


    $rs_per = $conexion->query($sql) or die($conexion->error);

    while($data = mysqli_fetch_assoc($rs_per)){
        $json["data"][]= $data;
    }
    
    $jsonstring=json_encode($json);
    echo $jsonstring;
   
?>
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
    . " INNER JOIN personas_fisicas ON 
    personas.`persona_id` = personas_fisicas.`rela_persona`"
    . " INNER JOIN persona_sexo ON persona_sexo.id_sexo = personas_fisicas.rela_persona_sexo"
    . " WHERE personas.`persona_id`=".$personaid;


    $rs_per = $conexion->query($sql) or die($conexion->error);

    while($row = mysqli_fetch_array($rs_per)){
        $json[]= array(   
            "personaid" =>$row['persona_id'],             
            "persona" => $row['apellidos_persona'].', '.$row['nombres_persona'],
            "sexo" => $row['descripcion_sexo'],
            "dni"=> $row['persona_dni'],
            "cuil" => $row['persona_cuil'],
            "fechanac" => $row['persona_fecha_nac'],
            "nacionalidad" => $row['persona_nacionalidad']
        );
    }
    
    $jsonstring=json_encode($json);
    echo $jsonstring;
   
?>
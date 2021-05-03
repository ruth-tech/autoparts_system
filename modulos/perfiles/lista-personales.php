<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }
    $personaid = 54;
   
    $json = array();   

    $sql = "SELECT 
                personas.persona_id AS id,
                CONCAT(personas_fisicas.apellidos_persona,', ', personas_fisicas.nombres_persona) AS persona,
                persona_sexo.descripcion_sexo AS sexo,
                personas_fisicas.persona_dni AS dni,
                personas_fisicas.persona_cuil AS cuil,
                personas_fisicas.persona_fecha_nac AS fechanac,
                personas_fisicas.persona_nacionalidad AS nacionalidad "
    ." FROM personas"
    . " INNER JOIN personas_fisicas ON 
    personas.`persona_id` = personas_fisicas.`rela_persona`"
    . " INNER JOIN persona_sexo ON persona_sexo.id_sexo = personas_fisicas.rela_persona_sexo"
    . " WHERE personas.`persona_id`=".$personaid;

    
    $rs_per = $conexion->query($sql) or die($conexion->error);

    while($data = mysqli_fetch_assoc($rs_per)){
        $json["data"][]= $data;
    }
    
    $jsonstring = json_encode($json);
    echo $jsonstring;
   
?>
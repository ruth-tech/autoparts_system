<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT COUNT(*) FROM empleados WHERE estado = 1";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){

        $sql1="SELECT personas.persona_id AS personaid,empleados.empleado_id AS id, CONCAT(personas_fisicas.apellidos_persona,' ',nombres_persona) AS empleado, personas_fisicas.persona_dni AS dni, perfiles.perfil_descripcion AS cargo FROM empleados"
        . " INNER JOIN personas_fisicas ON empleados.`rela_persona_fisica`= personas_fisicas.`persona_fisica_id`"
        . " INNER JOIN personas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
        . " INNER JOIN usuarios ON usuarios.rela_persona = personas.persona_id"
        . " INNER JOIN perfiles ON perfiles.perfil_id = usuarios.rela_perfil"
        . " WHERE empleados.`estado`=1 "; 

        // echo $sql1;
        // exit;
        $rs = $conexion->query($sql1) or die($conexion->error);


        while($data = mysqli_fetch_assoc($rs)){
            $json["data"][]= $data;
        }
        
        
    }else{
        $json[] = array('No existen registros');
        
        
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;


   
?>
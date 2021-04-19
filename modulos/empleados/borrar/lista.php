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

        $sql1="SELECT * FROM empleados"
        . " INNER JOIN personas_fisicas ON empleados.`rela_persona_fisica`= personas_fisicas.`persona_fisica_id`"
        . " INNER JOIN personas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
        . " INNER JOIN usuarios ON usuarios.rela_persona = personas.persona_id"
        . " INNER JOIN perfiles ON perfiles.perfil_id = usuarios.rela_perfil"
        . " WHERE empleados.`estado`=1 "; 

        $rs = $conexion->query($sql1) or die($conexion->error);


        while($row = mysqli_fetch_array($rs)){
            $json[]= array(
                'personaid' => $row['persona_id'],
                'id' => $row['empleado_id'],
                'empleado' => $row['apellidos_persona'].", ".$row['nombres_persona'],
                'dni' => $row['persona_dni'],
                'cargo' => $row['perfil_descripcion']
            );
        }
        
        
    }else{
        $json[] = array('No existen registros');
        
        
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;


   
?>
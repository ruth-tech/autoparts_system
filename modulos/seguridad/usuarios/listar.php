<?php

    include '../../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT COUNT(*) FROM usuarios WHERE estado = 1";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){ 

        $sql1="SELECT 
        u.usuario_id AS id,
        usuario_nombre AS usuario,
        usuario_password AS pass,
        usuario_fecha_alta AS alta,
        p.perfil_descripcion AS perfil,
        CONCAT(pf.apellidos_persona,' ',nombres_persona) AS empleado
        FROM usuarios u
        INNER JOIN perfiles p ON u.rela_perfil = p.perfil_id
        INNER JOIN personas per ON per.persona_id = u.rela_persona
        INNER JOIN personas_fisicas pf ON pf.rela_persona = per.persona_id
        WHERE u.estado = 1";

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
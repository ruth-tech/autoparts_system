<?php

    include '../../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario_estado = 1";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){ 

        $sql1="SELECT 
        us.rela_persona AS persona_id,
        us.`usuario_id` AS id,
        CONCAT(pf.apellidos_persona,' ',nombres_persona) AS nombre,
        us.`usuario_nombre` AS usuario,
        pc.`valor_contacto` AS email,
        us.`usuario_fecha_alta` AS agregado"	
        ." FROM usuarios us"
        ." INNER JOIN personas_fisicas pf ON  us.`rela_persona` = pf.`rela_persona`"
        ." INNER JOIN empleados e ON e.`rela_persona_fisica` = pf.`persona_fisica_id`"
        ." INNER JOIN perfiles perf ON us.`rela_perfil`=perf.`perfil_id`"
        ." INNER JOIN persona_contacto pc ON pf.`rela_persona`=pc.`rela_persona`"
        ." INNER JOIN tipo_contacto tc ON pc.`rela_tipo_contacto`=tc.`tipo_contacto_id`"
        ." WHERE us.usuario_estado=1 AND tc.`tipo_contacto_descripcion`= 'email' AND pc.estado=1";

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
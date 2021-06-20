<?php

    include('../../php/conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT * FROM caja";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $count = mysqli_num_rows($rs);
    $json = array();

    if($count !== 0){ 

        $sql1="SELECT caja.caja_id as id,caja_fecha_inicio, CONCAT('$ ',monto_inicial) as monto_inicial, caja_fecha_cierre,CONCAT('$ ',caja_monto_total) as caja_monto_total,caja_estados.nombre AS estado FROM caja INNER JOIN caja_estados ON caja.rela_estado = caja_estados.id ORDER BY caja.caja_fecha_inicio DESC ";

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
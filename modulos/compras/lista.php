<?php

    include('../../php/conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT COUNT(*) FROM compras";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){

        $sql1="SELECT 
        c.compra_id AS id,
        compra_fecha AS fecha,
        CONCAT('$ ',compra_total) AS total,
        pj.razon_social AS proveedor,
        e.nombreEmpleado AS empleado,
        td.nombre AS documento
        FROM compras c
        INNER JOIN proveedores p ON c.rela_proveedor = p.proveedor_id
        INNER JOIN vw_empleado_nombre e ON e.`usuarioid`=c.rela_usuario
        INNER JOIN  tipo_documento td ON td.id = c.rela_tipo_doc
        INNER JOIN personas_juridicas pj ON pj.persona_juridica_id = p.rela_persona_juridica";
        // echo $sql1;
        // exit;

        $rs_compras = $conexion->query($sql1) or die($conexion->error);   
        
        while($data = mysqli_fetch_assoc($rs_compras)){
            $json["data"][]= $data;
        }
        
        
    }else{
        $json[] = array();
        
        
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;


   
?>
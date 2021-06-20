<?php

    include('../../../php/conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT COUNT(*) FROM pedidos";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){

        $sql1="SELECT p.`pedido_id`, 
            p.pedido_fecha,
            CONCAT('$ ',p.pedido_total) AS total, 
            pe.pedido_estado_descripcion,
            c.`nombreCliente`,
            e.`nombreEmpleado`,
            f.no_factura, tf.tipo_factura_descripcion as tipo"             
        ." FROM pedidos p"
        ." INNER JOIN facturas f ON p.pedido_id = f.rela_pedido"
        ." INNER JOIN pedidos_estados pe ON p.`rela_pedido_estado`=pe.`pedido_estado_id`"
        ." INNER JOIN vw_cliente_nombre c ON c.`idcliente`=p.`rela_cliente`"
        ." INNER JOIN vw_empleado_nombre e ON e.`usuarioid`=p.`rela_user`"
        ." INNER JOIN tipo_factura tf ON tf.tipo_factura_id = f.rela_tipo_factura";
        // echo $sql1;
        // exit;

        $rs_pedidos = $conexion->query($sql1) or die($conexion->error);   
        
        while($data = mysqli_fetch_assoc($rs_pedidos)){
            $json["data"][]= $data;
        }
        
        
    }else{
        $json[] = array();
        
        
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;


   
?>
<?php
    require '../../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../../index.php?error=debe_loguearse");
      exit;
    }

    $productoid = $_POST['productoid'];

    $sql = "SELECT * FROM productos"
    . " INNER JOIN producto_detalles ON productos.`producto_id`= producto_detalles.`rela_producto`"
    . " INNER JOIN productoxcategoriaxmodelo ON productos.`producto_id`= productoxcategoriaxmodelo.`rela_producto`"
    . " WHERE productoxcategoriaxmodelo.`productoxcategoria_id`=".$productoid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
        $json[] = array(
        
        "productoid"=>$row['producto_id'],
        "producto_descripcion"=>$row['producto_descripcion'],
        
        "producto_fecha_ingreso"=>$row['producto_fecha_ingreso'],
        "producto_detalle_fabricante"=>$row['producto_detalle_fabricante'],
        "producto_detalle_descripcion"=>$row['producto_detalle_descripcion']           
        );     
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
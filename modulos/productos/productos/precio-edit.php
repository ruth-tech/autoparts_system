<?php
    require '../../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../../index.php?error=debe_loguearse");
      exit;
    }

    $productoxcategoriaid = $_POST['productoid'];

    $sql = "SELECT * FROM productos"
    . " INNER JOIN producto_precio ON productos.`producto_id`= producto_precio.`rela_producto`"
    . " INNER JOIN productoxcategoriaxmodelo ON productos.`producto_id`= productoxcategoriaxmodelo.`rela_producto`"
    . " WHERE producto_precio.`precio_fecha`= 
    (SELECT MAX(producto_precio.`precio_fecha`) FROM producto_precio WHERE producto_precio.`rela_producto`= productos.producto_id)" 
    . "AND productoxcategoriaxmodelo.`productoxcategoria_id`=".$productoxcategoriaid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
        $json[] = array(
        
        "productoid"=>$row['producto_id'],
        "descripcion"=>$row['producto_descripcion'],
        "fabricante"=>$row['producto_detalle_fabricante'],
        "precioproveedor"=>$row['precio_proveedor'],           
        "precio"=>$row['precio_venta']           
        );     
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
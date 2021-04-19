<?php
    include('../../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['productoid'])){
        $productoid = $_POST['productoid'];       
        $precioproveedor = $_POST['precioproveedor'];
        $precio = $_POST['precio'];

    }
    // echo $productoid, '---',$precio;
    // exit;
    $fechaPrecio = date('Y-m-d');

    $sql1 = "INSERT INTO producto_precio(`rela_producto`,`precio_fecha`,`precio_proveedor`,`precio_venta`)"
    ."VALUES ($productoid,'$fechaPrecio',$precioproveedor,$precio)";

    // echo $sql1;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
    if (!mysqli_query($conexion, $sql1)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado respecto a la tabla de Precios!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }
    
    echo "¡Registro actualizado exitosamente!";



?>
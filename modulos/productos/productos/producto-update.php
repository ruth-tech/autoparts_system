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
        $descripcion = strtoupper($_POST['descripcion']);        
        $fehcaingreso = $_POST['fechaingreso'];
        $fabricante = strtoupper($_POST['fabricante']);
        $detalles = strtoupper($_POST['detalles']);

    }
    // echo $productoid;
    // exit;

    $sql1 = "UPDATE productos "
    . "SET producto_descripcion = '".$descripcion."', producto_fecha_ingreso = '".$fehcaingreso."', producto_detalle_fabricante = '".$fabricante
    ."' WHERE producto_id = ".$productoid;

    // echo $sql1;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
    if (!mysqli_query($conexion, $sql1)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado respecto a la tabla productos!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }
    $sql2 = "UPDATE producto_detalles "
    . "SET producto_detalle_descripcion = '".$detalles
    ."' WHERE rela_producto = ".$productoid;

    // echo $sql2;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
    if (!mysqli_query($conexion, $sql2)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado respecto a la tabla producto_detalles!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }



    echo "¡Registro actualizado exitosamente!";



?>
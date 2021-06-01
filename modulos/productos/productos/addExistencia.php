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
        $existencia = $_POST['existencia'];        
        $precio = $_POST['precio'];

    }
    
    $sql2 = "CALL proc_actualizar_stockYprecio(".$productoid.",".$existencia.",".$precio.")";



     // si no puedo guardar, redirecciono al listado con mensaje de error
    if (!mysqli_query($conexion, $sql2)) {
        echo "¡Ha ocurrido un error al intentar actualizar el stock!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }



    echo "¡Registro actualizado exitosamente!";



?>
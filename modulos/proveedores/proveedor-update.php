<?php
    include('../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['proveedorid'])){
        $proveedorid = $_POST['proveedorid'];
        $fechaalta = $_POST['fechaalta'];
        
        $website =  strtoupper($_POST['website']);
        

    }

    $sql1 = "UPDATE proveedores SET proveedor_fecha_alta = '".$fechaalta."', proveedor_website = '".$website
    ."' WHERE proveedor_id = ".$proveedorid;

    // echo $sql1;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
     if (!mysqli_query($conexion, $sql1)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado!";
                 
        exit;
    }

    echo "¡Registro actualizado exitosamente!";



?>
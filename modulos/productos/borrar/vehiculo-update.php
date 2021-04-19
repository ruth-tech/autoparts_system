<?php
    include('../../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['categoriaid'])){ 
        $categoriaid = $_POST['categoriaid'];
        $vehiculoid = $_POST['vehiculoid'];
        $descripcion = strtoupper($_POST['descripcion']);
    }

    $sql1 = "UPDATE vehiculos "
    ." INNER JOIN categoriaxvehiculo ON vehiculos.`vehiculo_id`=categoriaxvehiculo.`rela_vehiculo`"
    ." SET vehiculo_descripcion='".$descripcion
    ."' WHERE categoriaxvehiculo.`rela_prod_categoria`=".$categoriaid
    ." AND categoriaxvehiculo.`rela_vehiculo`=".$vehiculoid;

    // echo $sql1;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
     if (!mysqli_query($conexion, $sql1)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }

 

    echo "¡Registro actualizado exitosamente!";



?>
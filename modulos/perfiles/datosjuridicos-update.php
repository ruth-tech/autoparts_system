<?php
    include('../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['personaid'])){
        $personaid = $_POST['personaid'];
        $cuit = $_POST['cuit'];
        $razonsocial = strtoupper($_POST['razonsocial']);
        $habilitacion = $_POST['habilitacion'];
       
    }

    $sql1 = "UPDATE personas_juridicas "
    ." SET cuit = '".$cuit."', razon_social = '".$razonsocial."', nro_habilitacion = ".$habilitacion
    ." WHERE rela_persona = ".$personaid;

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
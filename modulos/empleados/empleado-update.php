<?php
    include('../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['empleadoid'])){
        $empleadoid = $_POST['empleadoid'];
        $personaid = $_POST['personaid'];
        $fechaalta = $_POST['fechaalta'];        
        $perfilid = $_POST['perfilid'];
    }
    
    $sql1 = "UPDATE empleados"
    ." SET empleado_fecha_alta = ".$fechaalta
    ." WHERE empleado_id = ".$empleadoid;

    // echo $sql1;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
    if (!mysqli_query($conexion, $sql1)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado respecto a la tabla empleados!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }

    $sql2 = "UPDATE usuarios"
    ." SET rela_perfil=".$perfilid
    ." WHERE rela_persona=".$personaid;

    if (!mysqli_query($conexion, $sql2)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado respecto a la tbla usuarios!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }
  

    echo "¡Registro actualizado exitosamente!";



?>
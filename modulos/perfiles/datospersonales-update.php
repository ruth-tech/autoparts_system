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
        $apellido = strtoupper($_POST['apellido']);
        $nombre = strtoupper($_POST['nombre']);
        $dni = $_POST['dni'];
        $cuil = $_POST['cuil'];        
        $fechaNac = $_POST['fechaNac'];
        $nacionalidad = strtoupper($_POST['nacionalidad']);

     }

    $sql1 = "UPDATE personas_fisicas "
    ." SET apellidos_persona = '".$apellido."', nombres_persona = '".$nombre."', persona_dni = ".$dni.", persona_cuil = '".$cuil."', persona_fecha_nac = '".$fechaNac."', persona_nacionalidad = '".$nacionalidad
    ."' WHERE rela_persona = ".$personaid;

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
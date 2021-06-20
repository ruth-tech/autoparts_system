<?php
    include('../../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['usuarioid'])){
        $usuarioid = $_POST['usuarioid'];
        $user = $_POST['user'];        
        $pass = $_POST['pass'];

     }

    $sql1 = "UPDATE usuarios SET usuario_nombre = ".$user.", usuario_password = ".$pass
    ." WHERE usuario_id = ".$usuarioid;

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
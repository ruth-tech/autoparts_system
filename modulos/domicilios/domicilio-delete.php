<?php

    include('../../php/conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

   

        $domicilioid = $_POST['domicilioid'];

       // MODIFICO PERSONA
        $sql = "UPDATE persona_domicilio SET estado = 0 WHERE persona_domicilio_id =".$domicilioid;

        $result = mysqli_query($conexion,$sql);

        if(!$result){
            die('¡No se ha logrado eliminar el registro de la base de datos!');
        }

       
        echo "¡Registro eliminado exitosamente!";
?>
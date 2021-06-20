<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    

        $id = $_POST['id'];

        $query = "UPDATE caja SET caja_fecha_cierre = NOW(), rela_estado = 2 WHERE caja_id = ". $id;

        $result = mysqli_query($conexion,$query);

        if(!$result){
            die('¡No se ha logrado cerrar la caja!');
        }

       
        echo "¡Caja cerrada exitosamente!";
    


?>
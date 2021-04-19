<?php 

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../../index.php?error=debe_loguearse");
    exit;
}

        $categoria = $_POST['categoriaid'];
        $descripcion = strtoupper($_POST['descripcion']);
        
        // cuando agrego nueva persona estado = 1
        $estado = 1;


        // GUARDO CLIENTE
        $sql3 = "INSERT INTO vehiculos(`vehiculo_descripcion`)"
            . " VALUES ('$descripcion')";

        

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql3)) {
            echo 'Falla la insercion en la tabla vehiculo';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }
        $vehiculoid= mysqli_insert_id($conexion);
        
        $sql = "INSERT INTO categoriaxvehiculo(`rela_prod_categoria`,`rela_vehiculo`,`estado`)"
        ." VALUES($categoria,$vehiculoid,$estado)";
        
        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql)) {
            echo '!Ha ocurrido un error en la carga a la base de datos!';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }


        echo '¡Registro agregado exitosamente!';
        //$mensaje = 'GUARDAR_CLIENTE_OK';
        
        //header("location: ../listado.php?mensaje=$mensaje");
  
?>
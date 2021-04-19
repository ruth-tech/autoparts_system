<?php 

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../index.php?error=debe_loguearse");
    exit;
}

    // if(isset($_POST['nombre'])){
        $nombre = strtoupper($_POST['nombre']);
        $apellido = strtoupper($_POST['apellido']);
        $dni = $_POST['dni'];
        $cuil = $_POST['cuil'];
        $sexo = $_POST['sexo'];
        $fchNac = $_POST['fchNac'];
        $nacionalidad = strtoupper($_POST['nacionalidad']);
        $nro_cuenta = $_POST['nro_cuenta'];
         
        // echo $nombre.', '.$apellido.', '.$dni;

        // cuando agrego nueva persona estado = 1
        $estado = 1;

        // // GUARDO PERSONA
        $sql1 = "INSERT INTO personas"
            . " (persona_id)"
            . " VALUES ('')";
    
        
        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (mysqli_query($conexion, $sql1)) {
            //$mensaje = 'GUARDAR_PERSONA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }else{
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla personas!';
            exit();
        }

        $id_persona = mysqli_insert_id($conexion);



        $sql2 = " INSERT INTO personas_fisicas" 
        . " (`rela_persona`,`apellidos_persona`,`nombres_persona`,`rela_persona_sexo`,`persona_dni`,`persona_cuil`,`persona_fecha_nac`,`persona_nacionalidad`)"
        . " VALUES ('$id_persona','$apellido','$nombre','$sexo','$dni','$cuil','$fchNac', '$nacionalidad') ";
        // echo $sql2;
        // exit;
        //$rs_persona = $conexion->query($sql2) or die($conexion->error);

        if (mysqli_query($conexion, $sql2)) {
            //$mensaje = 'GUARDAR_PERSONA_FISICA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }else{
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla personas fisicas!';
            exit();
        }



        // obtengo el id insertado en personas
        $id_persona_fisica = mysqli_insert_id($conexion);

        // obtengo fecha/hora actual
        $fecha_alta = date('Y-m-d');

        // GUARDO CLIENTE
        $sql3 = "INSERT INTO clientes (`rela_persona_fisica`,`cliente_fecha_alta`,`cliente_nro_cuenta`,`estado`)"
            . " VALUES ('$id_persona_fisica','$fecha_alta','$nro_cuenta', '$estado')";

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (mysqli_query($conexion, $sql3)) {
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }else{
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla clientes!';
            exit();
        }


        echo '¡Registro agregado exitosamente!';
        //$mensaje = 'GUARDAR_CLIENTE_OK';
        
        //header("location: ../listado.php?mensaje=$mensaje");
    // }else{
    //     echo 'no estan definidas las variables';
    // };

?>
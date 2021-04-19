<?php
    include('../../php/conexion.php');

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['clienteid'])){
        $personaid = $_POST['personaid'];
        $clienteid = $_POST['clienteid'];
        
        $fechaalta = $_POST['fechaalta'];
        $nrocuenta = $_POST['nrocuenta'];

     }

    $sql1 = "UPDATE clientes SET cliente_nro_cuenta = ".$nrocuenta.", cliente_fecha_alta = '".$fechaalta
    ."' WHERE cliente_id = ".$clienteid;

    // echo $sql1;
    // exit;

     // si no puedo guardar, redirecciono al listado con mensaje de error
     if (!mysqli_query($conexion, $sql1)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado respecto a la tabla clientes!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }



    echo "¡Registro actualizado exitosamente!";



?>
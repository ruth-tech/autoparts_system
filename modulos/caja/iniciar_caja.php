<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    
        $action = 'INICIO_CAJA';
        $monto_inicial = $_POST['monto_inicial'];
        $tipo_pago = 2;
        $estado = 1;

        // ABRIMOS LA CAJA
        $query = "INSERT into caja(monto_inicial,rela_estado) values($monto_inicial,$estado)";

        $result = mysqli_query($conexion,$query);
        // $caja_id = mysqli_insert_id($conexion);
        if(!$result){
            die('¡No se ha logrado Iniciar la caja!');
        }

        // REGISTRAMOS EL MOVIMIENTO DE CAJA
        $query1 = "CALL proceso_caja_mov('$action',$monto_inicial,$tipo_pago)";
        // echo $query1;exit;
        $result = mysqli_query($conexion,$query1);

        if(!$result){
            die('¡No se ha logrado registrar el movimiento de la caja!');
        }
       
        echo "¡Caja iniciada exitosamente!";
    


?>
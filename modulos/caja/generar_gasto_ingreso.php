<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

        if ($_POST['tipo'] == 1) {
            $action = 'INGRESO_SIN_DOCUMENTAR';
        }elseif ($_POST['tipo'] == 2) {
            $action = 'EGRESO_POR_GASTO';
        }
        
        $monto = $_POST['monto'];
        $tipo_pago = $_POST['tipo_pago'];


        // REGISTRAMOS EL MOVIMIENTO DE CAJA
        $query1 = "CALL proceso_caja_mov('$action',$monto,$tipo_pago)";
        // echo $query1;exit;
        $result = mysqli_query($conexion,$query1);

        if(!$result){
            die('¡No se ha logrado registrar el movimiento de la caja!');
        }
       
        echo "¡Gasto/Ingreso generado exitosamente!";
    


?>
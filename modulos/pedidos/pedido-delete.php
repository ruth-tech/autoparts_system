<?php
    require '../../php/conexion.php';

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../index.php?error=debe_loguearse");
        exit;
    }

    //DAR DE BAJA PEDIDO
    
        $id = $_POST['id'];
        
        $query_del = mysqli_query($conexion,"CALL delete_pedido(".$id.")");
        mysqli_close($conexion);
        if($query_del){
            echo 'Se dio de baja exitosamente.';
        }else{
            echo 'Error al dar de baja.';
        }
        exit;
    


?>
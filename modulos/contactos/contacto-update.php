<?php
    require '../../php/conexion.php';

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['contactoid'])){
        $contactoid = $_POST['contactoid'];
        $tipocontactoid = $_POST['tipocontactoid'];
        $valor = $_POST['valor'];
    }    
       

    $sql = "UPDATE persona_contacto"
    ." SET rela_tipo_contacto = ".$tipocontactoid.", valor_contacto = '".$valor
    ."' WHERE persona_contacto_id = ".$contactoid;
// echo $sql;
// exit;
     // si no puedo guardar, redirecciono al listado con mensaje de error
     if (!mysqli_query($conexion, $sql)) {
        echo "¡Ha ocurrido un error al intentar modificar el registro seleccionado!";
        //$mensaje = 'GUARDAR_PERSONA_ERROR';
        //header("location: ../listado.php?mensaje=$mensaje");
        exit;
    }
    echo "¡Registro actualizado exitosamente!";



?>
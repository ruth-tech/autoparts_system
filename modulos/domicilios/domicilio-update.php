<?php
    require '../../php/conexion.php';

    session_start();
    
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(isset($_POST['domicilioid'])){
        $domicilioid = $_POST['domicilioid'];
        $tipodomicilioid = $_POST['tipodomicilioid'];
        $localidadid = $_POST['localidadid'];
        $barrio = $_POST['barrio'];
        $calle1 = $_POST['calle'];              
        $altura1 = $_POST['altura'];
        $torre1 = $_POST['torre'];
        $piso1 = $_POST['piso'];
        $manzana1 = $_POST['manzana'];
        $sector1 = $_POST['sector'];
        $parcela1 = $_POST['parcela'];
        $calle = (!empty($calle1))   ?  "'$calle1'" : "NULL" ;
        $altura = (!empty($altura1))   ?  "$altura1" : "NULL" ;
        $torre = (!empty($torre1))   ?  "'$torre1'" : "NULL" ;
        $piso = (!empty($piso1))   ?  "$piso1" : "NULL";
        $manzana = (!empty($manzana1))   ?  "'$manzana1'" : "NULL";
        $sector = (!empty($sector1))   ?  "'$sector1'" : "NULL" ;
        $parcela = (!empty($parcela1))   ?  "'$parcela1'" : "NULL" ;
        
    }    
       
    $sql = "UPDATE persona_domicilio"
    ." SET rela_tipo_domicilio = ".$tipodomicilioid.", rela_localidad = ".$localidadid.", barrio = '".$barrio."', calle = ".$calle.", altura = ".$altura.", piso = ".$piso.", torre = ".$torre.", manzana = ".$manzana.", parcela = ".$parcela.", sector = ".$sector
    ." WHERE persona_domicilio_id = ".$domicilioid;
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
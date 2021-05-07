<?php

    require '../../../php/conexion.php';

    // session_start();

    // // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    // if (!isset($_SESSION["logueado"])) {
    //     header("location: ../../index.php?error=debe_loguearse");
    //     exit;
    // }
    $categoriaxmodelo = $_POST['categoriaxmodelo'];
    // $modelo = $_POST['modelo'];

    // echo $categoria, $modelo;

    $sql = "SELECT COUNT(*) FROM productoxcategoriaxmodelo"
    ." WHERE estado = 1 "
    ." AND rela_categoriaxmodelo =".$categoriaxmodelo;
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){

        $sql1="CALL proc_productoxcategoriaxmodelo(".$categoriaxmodelo.")";
        // echo $sql1;
        // exit;

        $rs_prod = $conexion->query($sql1) or die($conexion->error);        

        while($data = mysqli_fetch_assoc($rs_prod)){
            $json["data"][]=$data; 
        }        
        
    }else{
        $json[] = array('No existen registros');        
    }
    
    $jsonstring = json_encode($json);
//     switch(json_last_error()) {
//     case JSON_ERROR_NONE:
//         echo ' - Sin errores';
//     break;
//     case JSON_ERROR_DEPTH:
//         echo ' - Excedido tamaño máximo de la pila';
//     break;
//     case JSON_ERROR_STATE_MISMATCH:
//         echo ' - Desbordamiento de buffer o los modos no coinciden';
//     break;
//     case JSON_ERROR_CTRL_CHAR:
//         echo ' - Encontrado carácter de control no esperado';
//     break;
//     case JSON_ERROR_SYNTAX:
//         echo ' - Error de sintaxis, JSON mal formado';
//     break;
//     case JSON_ERROR_UTF8:
//         echo ' - Caracteres UTF-8 malformados, posiblemente codificados de forma incorrecta';
//     break;
//     default:
//         echo ' - Error desconocido';
//     break;
// }
    echo $jsonstring;
   
?>
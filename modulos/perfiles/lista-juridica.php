<?php

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }
    $id = 73;
   
    $json = array();   

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_juridicas ON 
    personas.`persona_id` = personas_juridicas.`rela_persona`"    
    . " WHERE personas.`persona_id`=$id";
    // echo $sql;
    // exit;

    $rs_per = $conexion->query($sql) or die($conexion->error);
    while($row = mysqli_fetch_array($rs_per)){
        $json[]= array(
            "personaid"=>$id,
            "cuit"=>$row['cuit'],
            "razonsocial" => $row['razon_social'],
            "habilitacion" => $row['nro_habilitacion']
            );
        }        
    
    $jsonstring=json_encode($json);
//         switch(json_last_error()) {
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
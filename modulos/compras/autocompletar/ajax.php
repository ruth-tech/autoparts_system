<?php
require '../../../php/conexion.php';

if($_POST['action']=='modelos'){
    $vehiculo=$_POST['vehiculoid'];

    $sql = "SELECT modelo_vehiculo_id AS id,
    modelo_vehiculo_descripcion AS nombre FROM modelos_vehiculos"
    ." WHERE rela_vehiculo=".$vehiculo;
    // echo $sql;
    // exit();

    $rs = $conexion->query($sql) or die($conexion->error); 
    $modelos = array();
    while($row = mysqli_fetch_array($rs)){
        $modelos[]= array(
            "id"=>$row['id'],
            "nombre" => preg_replace('([^A-Za-z0-9 ])', '', $row['nombre'])
        );
    } 
    $modelosjson = json_encode($modelos);
    // switch(json_last_error()) {
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

    echo $modelosjson;
}

if($_POST['action']=='modelos_anio'){
    $modelo=$_POST['id'];

    $sql = "SELECT modelo_anio_id AS id,
    modelo_anio_descripcion AS nombre FROM modelos_anio_vehiculos
    "
    ." WHERE rela_modelo_vehiculo=".$modelo;
    // echo $sql;
    // exit();

    $rs = $conexion->query($sql) or die($conexion->error); 
    $anio = array();
    while($row = mysqli_fetch_array($rs)){
        $anio[]= array(
            "id"=>$row['id'],
            "nombre" => preg_replace('([^A-Za-z0-9 ])', '', $row['nombre'])
        );
    } 
    $aniojson = json_encode($anio);
    // switch(json_last_error()) {
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

    echo $aniojson;
}

if($_POST['action']=='categorias'){
    $anio=$_POST['id'];

    $sql = "SELECT categoriaxmodelo_id AS id,
    prod_categoria_descripcion AS nombre
    FROM categoriaxmodelo INNER JOIN categorias ON categoriaxmodelo.rela_categoria = categorias.prod_categoria_id"
    ." WHERE rela_modelo_anio=".$anio;
    // echo $sql;
    // exit();

    $rs = $conexion->query($sql) or die($conexion->error); 
    $categorias = array();
    while($row = mysqli_fetch_array($rs)){
        $categorias[]= array(
            "id"=>$row['id'],
            "nombre" => preg_replace('([^A-Za-z0-9 ])', '', $row['nombre'])
        );
    } 
    $categoriasjson = json_encode($categorias);
    // switch(json_last_error()) {
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

    echo $categoriasjson;
}

?>
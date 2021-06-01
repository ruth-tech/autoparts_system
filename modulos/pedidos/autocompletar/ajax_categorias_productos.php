<?php
require '../../../php/conexion.php'; 


$modelo_anio = $_POST['modelo_anio'];
  


$sql1 = "SELECT * FROM categoriaxmodelo"
." INNER JOIN categorias ON categoriaxmodelo.rela_categoria = categorias.prod_categoria_id"
." INNER JOIN modelos_anio_vehiculos ON categoriaxmodelo.rela_modelo_anio = modelos_anio_vehiculos.modelo_anio_id"
. " INNER JOIN modelos_vehiculos ON modelos_anio_vehiculos.rela_modelo_vehiculo = modelos_vehiculos.modelo_vehiculo_id"
." WHERE  modelos_anio_vehiculos.modelo_anio_id=".$modelo_anio
." ORDER BY prod_categoria_descripcion ASC";

// echo $sql1;
// exit;

$rs_categoria =$conexion->query($sql1) or die($conexion->error);


$categorias = array();
while($row = mysqli_fetch_array($rs_categoria)){
    $categorias[]= array(
        "id"=>$row['categoriaxmodelo_id'],
        "categoria" => $row['prod_categoria_descripcion']
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

?>
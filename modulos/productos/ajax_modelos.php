<?php
require '../../php/conexion.php'; 


$idvehiculo = $_POST['marca'];
  
$sql = "SELECT 
    v.`vehiculo_id` AS vehiculoid,
    mv.`modelo_vehiculo_id` AS id,
    mv.`modelo_vehiculo_descripcion` AS vehiculo,
    mv.`modelo_vehiculo_anio` AS anio"
." FROM vehiculos v "
." INNER JOIN modelos_vehiculos mv ON v.`vehiculo_id`=mv.`rela_vehiculo`"
." WHERE mv.`estado`=1 AND v.`vehiculo_id`=".$idvehiculo;

// echo $sql;
// exit();

$rs =$conexion->query($sql) or die($conexion->error);


$modelos = array();

while($data = mysqli_fetch_assoc($rs)){
    $modelos["data"][]= $data;
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

?>
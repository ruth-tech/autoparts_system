<?php
require '../../php/conexion.php'; 


$sql1 = "SELECT 
    vehiculo_id AS id,
	vehiculo_descripcion AS descripcion,
	vehiculo_img AS img"
." FROM vehiculos"
." ORDER BY vehiculo_descripcion ASC"; ;

// echo $sql;
// exit();

$rs =$conexion->query($sql1) or die($conexion->error);


$vehiculos = array();

while($data = mysqli_fetch_assoc($rs)){
    $vehiculos["data"][]= $data;
} 
$vehiculosjson = json_encode($vehiculos);
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

echo $vehiculosjson;

?>
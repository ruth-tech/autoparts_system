<?php
require '../../../php/conexion.php';


$modelo=$_POST['modelos'];

$sql = "SELECT * FROM modelos_anio_vehiculos"
. " WHERE estado = 1 AND rela_modelo_vehiculo= ".$modelo;
// echo $sql;
// exit();

$rs_modelos = $conexion->query($sql) or die($conexion->error); 
$modelos = array();
while($row = mysqli_fetch_array($rs_modelos)){
    $modelos[]= array(
        "id"=>$row['modelo_anio_id'],
        "anio" => $row['modelo_anio_descripcion']
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

?>
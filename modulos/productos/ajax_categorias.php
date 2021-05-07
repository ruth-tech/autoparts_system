<?php
require '../../php/conexion.php'; 


$modeloid = $_POST['modelo'];
  


$sql1 = "SELECT 
    categoriaxmodelo_id AS id,
	prod_categoria_descripcion AS categoria,
	texto_descripcion AS detalle" 
." FROM categoriaxmodelo"
." INNER JOIN categorias ON categoriaxmodelo.rela_categoria = categorias.prod_categoria_id"
." INNER JOIN modelos_anio_vehiculos ON categoriaxmodelo.rela_modelo_anio = modelos_anio_vehiculos.modelo_anio_id"
. "INNER JOIN modelos_vehiculos ON modelo_anio_vehiculo.rela_modelo_vehiculo = modelo_vehiculo.modelo_vehiculo_id"
." WHERE  modelos_vehiculos.=".$modeloid
." ORDER BY prod_categoria_descripcion ASC";

// echo $sql1;
// exit;

$rs_categoria =$conexion->query($sql1) or die($conexion->error);


$categorias = array();

while($data = mysqli_fetch_assoc($rs_categoria)){
    $categorias["data"][]= $data;
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
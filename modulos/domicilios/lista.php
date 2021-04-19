<?php

    require '../../php/conexion.php';

    // session_start();

    // // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    // if (!isset($_SESSION["logueado"])) {
    //     header("location: ../../index.php?error=debe_loguearse");
    //     exit;
    // }
    $personaid = $_GET['personaid'];

    $sql = "SELECT COUNT(*) FROM persona_domicilio WHERE estado = 1 and rela_persona =".$personaid;
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){

        $sql1="SELECT * FROM personas"
        . " INNER JOIN persona_domicilio ON
        personas.`persona_id`= persona_domicilio.`rela_persona`"
        . " INNER JOIN tipo_domicilios ON 
        persona_domicilio.`rela_tipo_domicilio`=tipo_domicilios.`tipo_domicilio_id`"
        . " WHERE  persona_domicilio.`estado`=1 
        AND personas.`persona_id`= ".$personaid;

        $rs_dom = $conexion->query($sql1) or die($conexion->error);        

        while($row = mysqli_fetch_array($rs_dom)){
            $json[]= array(
                "personaid"=>$personaid,
                "domicilioid"=>$row['persona_domicilio_id'],
                "tipo_domicilio_descripcion" => $row['tipo_domicilio_descripcion'],
                "barrio" => preg_replace('([^A-Za-z0-9 ])', '',$row['barrio']),
                "calle"=> preg_replace('([^A-Za-z0-9 ])', '',$row['calle']),
                "altura" => $row['altura'],
                "torre"=> preg_replace('([^A-Za-z0-9 ])', '',$row['torre']),
                "piso" => $row['piso'],
                "manzana" => preg_replace('([^A-Za-z0-9 ])', '',$row['manzana']),
                "sector" => preg_replace('([^A-Za-z0-9 ])', '',$row['sector']),
                "parcela" => preg_replace('([^A-Za-z0-9 ])', '',$row['parcela'])
            );
        }        
        
    }else{
        $json[] = array();        
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
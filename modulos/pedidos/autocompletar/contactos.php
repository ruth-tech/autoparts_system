<?php 

    require '../../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) { 
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }
    $personaid = $_POST['personaid'];
    
    $json = array();
 

        $sql1="SELECT persona_contacto.valor_contacto,tipo_contacto.tipo_contacto_descripcion FROM personas"
        . " INNER JOIN persona_contacto ON 
        personas.`persona_id`= persona_contacto.`rela_persona`"
        . " INNER JOIN tipo_contacto ON 
        persona_contacto.`rela_tipo_contacto`=tipo_contacto.`tipo_contacto_id`"
        . " WHERE persona_contacto.`estado`=1 
        AND tipo_contacto.`tipo_contacto_descripcion`='telefono celular'
        AND personas.`persona_id`=".$personaid;

        // echo $sql1;
        // exit;
        $rs_con = $conexion->query($sql1) or die($conexion->error);
        
        while($row = mysqli_fetch_array($rs_con)){
            $json[]= array(
                "contacto" => $row['valor_contacto']
            );
        }
   
    $jsonstring=json_encode($json);
    // switch(json_last_error()) {
    // case JSON_ERROR_NONE:
    //     echo ' - Sin errores';
    // break;
    // case JSON_ERROR_DEPTH:
    //     echo ' - Excedido tamaño máximo de la pila';
    // break;
    // case JSON_ERROR_STATE_MISMATCH:
    //     echo ' - Desbordamiento de buffer o los modos no coinciden';
    // break;
    // case JSON_ERROR_CTRL_CHAR:
    //     echo ' - Encontrado carácter de control no esperado';
    // break;
    // case JSON_ERROR_SYNTAX:
    //     echo ' - Error de sintaxis, JSON mal formado';
    // break;
    // case JSON_ERROR_UTF8:
    //     echo ' - Caracteres UTF-8 malformados, posiblemente codificados de forma incorrecta';
    // break;
    // default:
    //     echo ' - Error desconocido';
    // }
    echo $jsonstring;
   
?>
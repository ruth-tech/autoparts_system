<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

    $empleadoid = $_POST['id'];

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_fisicas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
    . " INNER JOIN empleados ON empleados.`rela_persona_fisica`= personas_fisicas.`persona_fisica_id`"
    . " INNER JOIN usuarios ON  usuarios.`rela_persona`= personas.`persona_id`"
    . " INNER JOIN perfiles ON  perfiles.`perfil_id`= usuarios.`rela_perfil`"
    . " WHERE empleados.`empleado_id`=".$empleadoid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
        $json[] = array(
        "personaid"=>$row['persona_id'],
        "empleadoid"=>$empleadoid,
        "fechaalta"=>$row['empleado_fecha_alta'],       
        "perfilid"=>$row['perfil_id'],
        "perfildescripcion"=>$row['perfil_descripcion'],
            
        );     
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?><?php
//     require '../../php/conexion.php';

//     session_start();
      
//     // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
//     if (!isset($_SESSION["logueado"])) {
//       header("location: ../../index.php?error=debe_loguearse");
//       exit;
//     }

//     $empleadoid = $_POST['id'];
    

//     $sql = "SELECT * FROM personas"
//     . " INNER JOIN personas_fisicas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
//     . " INNER JOIN empleados ON empleados.`rela_persona_fisica`= personas_fisicas.`persona_fisica_id`"
//     . " INNER JOIN usuarios ON  usuarios.`rela_persona`= personas.`persona_id`"
//     . " INNER JOIN perfiles ON  perfiles.`perfil_id`= usuarios.`rela_perfil`"
//     . " WHERE empleados.`empleado_id`=".$empleadoid;

//     echo $sql;
//     exit();

//     $rs = mysqli_query($conexion, $sql);

//     $json = array();

//     while($row = mysqli_fetch_array($rs)){
//         $json[] = array(
//         "empleadoid"=>$empleadoid,              
//         "fechaAlta"=>$row['empleado_fecha_alta'],
//         "perfilid"=>$row['rela_perfil'],
//         "perfildescripcion"=>preg_replace('([^A-Za-z0-9 ])', '', $row['perfil_descripcion'])
            
//         );
      
        
//     }
//     $jsonstring = json_encode($json);
//     // switch(json_last_error()) {
//     // case JSON_ERROR_NONE:
//     //     echo ' - Sin errores';
//     // break;
//     // case JSON_ERROR_DEPTH:
//     //     echo ' - Excedido tamaño máximo de la pila';
//     // break;
//     // case JSON_ERROR_STATE_MISMATCH:
//     //     echo ' - Desbordamiento de buffer o los modos no coinciden';
//     // break;
//     // case JSON_ERROR_CTRL_CHAR:
//     //     echo ' - Encontrado carácter de control no esperado';
//     // break;
//     // case JSON_ERROR_SYNTAX:
//     //     echo ' - Error de sintaxis, JSON mal formado';
//     // break;
//     // case JSON_ERROR_UTF8:
//     //     echo ' - Caracteres UTF-8 malformados, posiblemente codificados de forma incorrecta';
//     // break;
//     // default:
//     //     echo ' - Error desconocido';
// //     break;
// // }
//     echo $jsonstring;




?>
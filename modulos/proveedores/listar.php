<?php

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../index.php?error=debe_loguearse");
    exit;
}

$sql = "SELECT COUNT(*) FROM proveedores WHERE estado = 1";
// echo $sql;

$rs_con = $conexion->query($sql) or die ($conexion->error);

$json = array();
      
if($rs_con !== 0){
    $sql1="SELECT 
        personas.`persona_id` AS personaid,  
	    proveedores.`proveedor_id` AS proveedorid,
	    personas_juridicas.`razon_social` AS proveedor,
	    personas_juridicas.`cuit` AS cuit, 
	    proveedores.`categoria` AS categoria,
	    proveedores.`proveedor_website` AS website"
    ." FROM proveedores"
    ." INNER JOIN personas_juridicas ON proveedores.`rela_persona_juridica`= personas_juridicas.`persona_juridica_id`"
    ." INNER JOIN personas ON personas.`persona_id`= personas_juridicas.`rela_persona`"
    ." WHERE proveedores.`estado`=1 ";
    // echo $sql1;
    // exit;

    $rs_per = $conexion->query($sql1) or die ($conexion->error);

    while($data = mysqli_fetch_assoc($rs_per)){
        $json["data"][]=$data;
    }
 
}else{
    $json[] = array();
}

$jsonstring = json_encode($json);
echo $jsonstring;



?>
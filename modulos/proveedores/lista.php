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
    $sql1="SELECT * FROM proveedores"
    . " INNER JOIN personas_juridicas ON proveedores.`rela_persona_juridica`= personas_juridicas.`persona_juridica_id`"
    . " INNER JOIN personas ON personas.`persona_id`= personas_juridicas.`rela_persona`"
    . " WHERE proveedores.`estado`=1 ";
    echo $sql1;
    exit;

    $rs_per = $conexion->query($sql1) or die ($conexion->error);

    while($row = mysqli_fetch_array($rs_per)){
        $json[]=array(
            "personaId"=>$row['persona_id'],
            "proveedorid"=>$row['proveedor_id'],
            "proveedor"=>$row['razon_social'],
            "cuit"=>$row['cuit'],
            "categoria"=>$row['categoria'],
            "website"=>$row['proveedor_website']
        );
    }
 
}else{
    $json[] = array();
}

$jsonstring = json_encode($json);
echo $jsonstring;



?>
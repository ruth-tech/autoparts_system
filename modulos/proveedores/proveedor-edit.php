<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

    $proveedorid = $_POST['proveedorid'];
    

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_juridicas ON personas.`persona_id`= personas_juridicas.`rela_persona`"
    . " INNER JOIN proveedores ON proveedores.`rela_persona_juridica`= personas_juridicas.`persona_juridica_id`"
    . " WHERE proveedores.`proveedor_id`=".$proveedorid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
        $json[] = array(
        
        'proveedorid'=>$proveedorid,       
        'fechaAlta'=>$row['proveedor_fecha_alta'],
        'website'=>$row['proveedor_website'],
        'categoria'=>$row['categoria']            
        );
      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
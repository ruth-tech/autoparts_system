<?php
    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) { 
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT * FROM tipo_contacto";

    $rs_con = mysqli_query($conexion,$sql);

    $json = array();
    while($row=mysqli_fetch_array($rs_con)){
        $json[]=array(
            'id'=>$row['tipo_contacto_id'],
            'descripcion'=>$row['tipo_contacto_descripcion']
        );
    };
    $jsonstring = json_encode($json);
    echo $jsonstring;

?>
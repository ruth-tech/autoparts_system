<?php

    include('../../php/conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT COUNT(*) FROM clientes WHERE estado = 1";
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();

    if($rs !== 0){

        $sql1="SELECT * FROM clientes"
        . " INNER JOIN personas_fisicas
        ON clientes.`rela_persona_fisica`=
        personas_fisicas.`persona_fisica_id`"
        . " INNER JOIN personas ON personas.`persona_id`=
        personas_fisicas.`rela_persona`"
        . " WHERE clientes.`estado`=1 ";

        $rs = $conexion->query($sql1) or die($conexion->error);

        

        while($row = mysqli_fetch_array($rs)){
            $json[]= array(
                'personaId' => $row['persona_id'],
                'clienteId' => $row['cliente_id'],
                'cliente' => $row['apellidos_persona'].", ".$row['nombres_persona'],
                'cuil' => $row['persona_cuil'],
                'nro_cuenta' => $row['cliente_nro_cuenta']
            );
        }
        
        
    }else{
        $json[] = array('No existen registros');
        
        
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;


   
?>
<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

    $clienteid = $_POST['clienteid'];

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_fisicas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
    . " INNER JOIN clientes ON clientes.`rela_persona_fisica`= personas_fisicas.`persona_fisica_id`"
    . " WHERE clientes.`cliente_id`=".$clienteid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       'personaid'=>$row['persona_id'],
       'clienteid'=>$clienteid,
       
       'fechaAlta'=>$row['cliente_fecha_alta'],
       'nroCuenta'=>$row['cliente_nro_cuenta'],
           
      );
      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
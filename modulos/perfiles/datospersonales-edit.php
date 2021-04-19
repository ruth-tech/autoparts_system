<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

    $personaid = $_POST['personaid'];

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_fisicas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
    . " WHERE personas.`persona_id`=".$personaid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       "personaid"=>$personaid,
       "apellido"=>$row['apellidos_persona'],
       "nombre"=>$row['nombres_persona'],       
       "dni"=>$row['persona_dni'],
       "cuil"=>$row['persona_cuil'],
       "fechaNac"=>$row['persona_fecha_nac'],
       "nacionalidad"=>$row['persona_nacionalidad'],
           
      );
      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
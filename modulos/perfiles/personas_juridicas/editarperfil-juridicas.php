<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

    
    $personaid = $_GET['personaid'];

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_fisicas ON personas.`persona_id`= personas_fisicas.`rela_persona`"
    . " INNER JOIN persona_contacto ON persona_contacto.`rela_persona`= personas.`persona_id`"
    . " INNER JOIN tipo_contacto ON persona_contacto.`rela_tipo_contacto`= tipo_contacto.`tipo_contacto_id`"
    . " INNER JOIN persona_domicilio ON persona_domicilio.`rela_persona`= personas.`persona_id`"
    . " INNER JOIN tipo_domicilios ON persona_domicilio.`rela_tipo_domicilio`= tipo_domicilios.`tipo_domicilio_id`"
    . " WHERE personas.`persona_id`=".$personaid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       'personaid'=>$personaid,
       'clienteid'=>$clienteid,
       'nombre'=>$row['nombres_persona'],
       'apellido'=>$row['apellidos_persona'],
       'dni'=>$row['persona_dni'],
       'cuil'=>$row['persona_cuil'],
      //  'sexo'=>$row['persona_sexo'],
       'fchNac'=> $row['persona_fecha_nac'],
       'nacionalidad'=>$row['persona_nacionalidad'],
       'fechaAlta'=>$row['cliente_fecha_alta'],
       'nroCuenta'=>$row['cliente_nro_cuenta'],
      //  'tipo_domiclio_descripcion'=>$row['tipo_domicilio_descripcion'],
      //  'barrio'=>$row['barrio'],
      //  'calle'=>$row['calle'],
      //  'altura'=>$row['altura'],
      //  'piso'=>$row['piso'],
      //  'torre'=>$row['torre'],
      //  'manzana'=>$row['manzana'],
      //  'sector'=>$row['sector'],
      //  'parcela'=>$row['parcela'],
      //  'tipo_contacto_descripcion'=>$row['tipo_contacto_descripcion'],
      //  'valor_contacto'=>$row['valor_contacto']          
      );
      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;




?>
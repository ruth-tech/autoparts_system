<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

 
    $contactoid = $_POST['contactoid'];

    $sql = "SELECT * FROM persona_contacto "
    ." INNER JOIN tipo_contacto ON persona_contacto.rela_tipo_contacto = tipo_contacto.tipo_contacto_id"
    ." WHERE persona_contacto.estado = 1 AND persona_contacto_id =". $contactoid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       'contactoid'=>$contactoid,
       'tipocontactoid'=>$row['rela_tipo_contacto'],
       'tipocontactodescripcion'=>$row['tipo_contacto_descripcion'],
       'valorcontacto'=>$row['valor_contacto']          
      );
      
        
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
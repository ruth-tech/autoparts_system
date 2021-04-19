<?php
    require '../../php/conexion.php'; 

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }

 
    $domicilioid = $_POST['domicilioid'];

    $sql = "SELECT * FROM persona_domicilio "
    ." INNER JOIN tipo_domicilios ON persona_domicilio.rela_tipo_domicilio = tipo_domicilios.tipo_domicilio_id"
    ." INNER JOIN localidades ON localidades.id = persona_domicilio.rela_localidad"
    ." WHERE persona_domicilio_id =". $domicilioid;

    // echo $sql;
    // exit();

    $rs = mysqli_query($conexion, $sql);

    $json = array();

    while($row = mysqli_fetch_array($rs)){
      $json[] = array(
       "domicilioid"=>$domicilioid,
       "tipodomicilioid"=>$row['rela_tipo_domicilio'],
       "tipodomiciliodescripcion"=>$row['tipo_domicilio_descripcion'],
       "localidadid"=>$row['rela_localidad'],
       "localidaddescripcion"=>$row['localidad'],
       "barrio"=>$row['barrio'],          
       "calle"=>$row['calle'],          
       "altura"=>$row['altura'],          
       "piso"=>$row['piso'],          
       "torre"=>$row['torre'],          
       "manzana"=>$row['manzana'],          
       "sector"=>$row['sector'],          
       "parcela"=>$row['parcela'],          
      );       
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>
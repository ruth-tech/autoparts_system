<?php 

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) { 
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }
    $personaid = $_GET['personaid'];
    $sql = "SELECT COUNT(*) FROM persona_contacto"
    ." WHERE estado = 1 AND rela_persona =".$personaid;
    
    $rs = $conexion->query($sql) or die ($conexion->error);
    $json = array();
    if($rs !== 0){

        $sql1="SELECT * FROM personas"
        . " INNER JOIN persona_contacto ON 
        personas.`persona_id`= persona_contacto.`rela_persona`"
        . " INNER JOIN tipo_contacto ON 
        persona_contacto.`rela_tipo_contacto`=tipo_contacto.`tipo_contacto_id`"
        . " WHERE persona_contacto.`estado`=1 
        AND personas.`persona_id`=".$personaid;
        $rs_con = $conexion->query($sql1) or die($conexion->error);
        while($row = mysqli_fetch_array($rs_con)){
            $json[]= array(     
                "personaid"=>$personaid,
                "contactoid"=>$row['persona_contacto_id'],           
                "tipo_contacto_descripcion" => $row['tipo_contacto_descripcion'],
                "valor_contacto" => $row['valor_contacto']
            );
        }
    }else{
        $json[]=array();
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
   
?>
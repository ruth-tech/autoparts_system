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

        $sql1="SELECT 
                    personas.persona_id AS personaid,
                    persona_contacto.persona_contacto_id AS contactoid,
                    tipo_contacto.tipo_contacto_descripcion AS descripcion,
                    persona_contacto.valor_contacto AS valor"
                ." FROM personas "
                ." INNER JOIN persona_contacto ON personas.`persona_id`= persona_contacto.`rela_persona`"
                ." INNER JOIN tipo_contacto ON persona_contacto.`rela_tipo_contacto`=tipo_contacto.`tipo_contacto_id`"
                ." WHERE persona_contacto.`estado`=1" 
                ." AND personas.`persona_id`=".$personaid;

        $rs_con = $conexion->query($sql1) or die($conexion->error);

        while($data = mysqli_fetch_assoc($rs_con)){
            $json["data"]= $data;
        }
    }else{
        $json[]=array("No existen registros.");
    }
    
    $jsonstring=json_encode($json);
    echo $jsonstring;
   
?>
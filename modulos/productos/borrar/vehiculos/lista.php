<?php 

    require '../../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) { 
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }
    $categoria = $_GET['categoria'];
    
    $json = array();  

    $sql = "SELECT * FROM categoriaxvehiculo "
    ." INNER JOIN vehiculos ON categoriaxvehiculo.`rela_vehiculo` = vehiculos.`vehiculo_id`"
    ." WHERE categoriaxvehiculo.estado=1 AND categoriaxvehiculo.`rela_prod_categoria`=".$categoria
    . " ORDER BY vehiculos.vehiculo_descripcion asc";

    // echo $sql;
    // exit;    
    $rs_vehiculo = $conexion->query($sql) or die($conexion->error);

        while($row = mysqli_fetch_array($rs_vehiculo)){
            $json[]= array(     
                "categoria"=>$categoria,
                "vehiculoid"=>$row['vehiculo_id'],           
                "vehiculodescripcion" => $row['vehiculo_descripcion']
            );
        }
   
    $jsonstring=json_encode($json);
    echo $jsonstring;
   
?>
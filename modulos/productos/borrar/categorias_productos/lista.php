<?php

    require '../../php/conexion.php';


    
    $sql = "SELECT * FROM prod_categorias"
    ." WHERE estado = 1 "
    ." ORDER BY prod_categoria_descripcion ASC";
    // echo $sql;
    // exit;

    $result = mysqli_query($conexion, $sql);

    if(!$result){
        die('Query failed'.mysqli_error($conexion));
    }


    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array(
            "id" => $row['prod_categoria_id'],
            "descripcion" => $row['prod_categoria_descripcion']
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;


?>
<?php
include '../../../php/conexion.php';
    if($_POST['action'] == 'infoProducto'){
        // print_r($_POST);
        $return_arr = array();
        // echo "BUSCAR CLIENTE";
        if(!empty($_POST['producto'])){
            $producto = $_POST['producto'];
            
            $sql ="CALL proc_lista_productos(".$producto.")";
            
             
            $res = $conexion->query($sql);
            
            $result = mysqli_num_rows($res);
            
            if($result > 0){
                while($row = mysqli_fetch_array($res)){
                    $arr['id'] = $row['producto_id'];
                    $arr['descripcion'] = $row['producto_descripcion'];
                    $arr['detalle'] = $row['producto_detalle_descripcion'];
                    $arr['existencia'] = $row['stock'];
                    $arr['precio'] = $row['precio_venta'];
                    
                    array_push($return_arr,$arr);
                }
                $jsonstring = json_encode($return_arr);
                echo $jsonstring;
                exit;
               

            }else{
                echo 0;
                exit;  
            }
                    
        }
    }
?>
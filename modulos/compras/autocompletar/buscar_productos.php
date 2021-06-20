<?php
include '../../../php/conexion.php';
    if($_POST['action'] == 'infoProducto'){
        // print_r($_POST);
        $return_arr = array();
        // echo "BUSCAR CLIENTE";
        if(!empty($_POST['producto'])){
            $producto = $_POST['producto'];
            
            $sql ="SELECT p.producto_id AS id, p.producto_descripcion AS nombre, pd.producto_detalle_descripcion AS detalle
            FROM productos p
            INNER JOIN producto_detalles pd ON p.producto_id = pd.rela_producto
            WHERE p.producto_id =$producto";
            
             
            $res = $conexion->query($sql);
            
            $result = mysqli_num_rows($res);
            
            if($result > 0){
                while($row = mysqli_fetch_array($res)){
                    $arr['id'] = $row['id'];
                    $arr['descripcion'] = $row['nombre'];
                    $arr['detalle'] = $row['detalle'];
                    
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
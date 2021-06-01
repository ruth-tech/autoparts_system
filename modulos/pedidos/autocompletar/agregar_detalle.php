<?php
session_start();
include '../../../php/conexion.php';
    //extrae datos del detalle_temp
    if($_POST['action'] == 'searchForDetalle'){
        if(empty($_POST['user'])){
            echo '0';
            exit;
        }else{
            $user       = $_SESSION['id'];

            $query = mysqli_query($conexion,"SELECT 
                                            tmp.correlativo,
                                            tmp.rela_user,
                                            tmp.cantidad,
                                            tmp.precio_venta,
                                            p.producto_descripcion,
                                            tmp.rela_producto"                      
                                            ." FROM detalle_temp tmp"
                                            ." INNER JOIN productos p
                                            ON tmp.rela_producto = p.producto_id"
                                            ." WHERE tmp.rela_user=$user");
                                            
            
            $result = mysqli_num_rows($query);

            $query_iva = mysqli_query($conexion,"SELECT parametro_valor FROM parametros_impositivos WHERE parametro_descripcion = 'IVA'");
            $result_iva = mysqli_num_rows($query_iva);

            // $sql = "CALL add_detalle_temp($id,$cantidad,$user)";
            // echo $sql;
            // exit;
           
            
            
            

            $detalleTabla   = '';
            $subtotal       =0;
            $iva            =0;
            $total          =0;
            $arrayData      =array();

            if($result > 0){
                if($result_iva > 0){
                    $info_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $info_iva['parametro_valor'];
                }

                while($data = mysqli_fetch_assoc($query)){
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $subtotal = round($subtotal + $precioTotal, 2);
                    $total = round($total + $precioTotal,2);

                    $detalleTabla .= '<tr>
                                        <td>'.$data["rela_producto"].'</td>
                                        <td colspan="2">'.$data["producto_descripcion"].'</td>
                                        <td align="center">'.$data["cantidad"].'</td>
                                        <td colspan="2" align="right">$ '.$data["precio_venta"].'</td>
                                        <td align="right">$ '.$precioTotal.'</td>
                                        <td><a class="btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"><i class="far fa-trash-alt" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"></i></a></td>
                                    </tr>';

                }

                $impuesto       = round($subtotal * ($iva / 100), 2);
                $total_siniva   = round($subtotal - $impuesto, 2);
                $total          =round($total_siniva + $impuesto, 2);

                $detalleTotales = ' <tr>
                                        <td colspan="6" align="right">SUBTOTAL $</td>
                                        <td align="right">'.$total_siniva.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">IVA ('.$iva.'%)</td>
                                        <td align="right">$ '.$impuesto.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">TOTAL $</td>
                                        <td align="right">'.$total.'</td>
                                    </tr>';

                $arrayData['detalle'] =$detalleTabla;
                $arrayData['totales'] =$detalleTotales;

                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
            }else {
                echo '0';
            }
            mysqli_close($conexion);


        }
        exit;
    }
    //agregar productos al detalle temporal
    if($_POST['action'] == 'addProductoDetalle'){
        // print_r($_POST);
        // exit;

        if(empty($_POST['producto']) || empty($_POST['cantidad'])){
            echo '0';
            exit;
        }else{
            $id         = $_POST['producto'];
            $cantidad   = $_POST['cantidad'];
            $user       = $_SESSION['id'];

            $query_iva = mysqli_query($conexion,"SELECT parametro_valor FROM parametros_impositivos WHERE parametro_descripcion = 'IVA'");
            $result_iva = mysqli_num_rows($query_iva);

            // $sql = "CALL add_detalle_temp($id,$cantidad,$user)";
            // echo $sql;
            // exit;
            $query_detalle = mysqli_query($conexion,"CALL add_detalle_temp($id,$cantidad,$user)");
            
            $result = mysqli_num_rows($query_detalle);
            

            $detalleTabla   = '';
            $subtotal       =0;
            $iva            =0;
            $total          =0;
            $arrayData      =array();

            if($result > 0){
                if($result_iva > 0){
                    $info_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $info_iva['parametro_valor'];
                }

                while($data = mysqli_fetch_assoc($query_detalle)){
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $subtotal = round($subtotal + $precioTotal, 2);
                    $total = round($total + $precioTotal,2);

                    $detalleTabla .= '<tr>
                                        <td>'.$data["rela_producto"].'</td>
                                        <td colspan="2">'.$data["producto_descripcion"].'</td>
                                        <td align="center">'.$data["cantidad"].'</td>
                                        <td colspan="2" align="right">$ '.$data["precio_venta"].'</td>
                                        <td align="right">$ '.$precioTotal.'</td>
                                        <td><a class="btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"><i class="far fa-trash-alt" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"></i></a></td>
                                    </tr>';

                }

                $impuesto       = round($subtotal * ($iva / 100), 2);
                $total_siniva   = round($subtotal - $impuesto, 2);
                $total          =round($total_siniva + $impuesto, 2);

                $detalleTotales = ' <tr>
                                        <td colspan="6" align="right">SUBTOTAL $</td>
                                        <td align="right">'.$total_siniva.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">IVA ('.$iva.'%)</td>
                                        <td align="right">$ '.$impuesto.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">TOTAL $</td>
                                        <td align="right">'.$total.'</td>
                                    </tr>';

                $arrayData['detalle'] =$detalleTabla;
                $arrayData['totales'] =$detalleTotales;

                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
            }else {
                echo '0';
            }
            mysqli_close($conexion);


        }
        exit;
       
    }

    //eliminar productos del detalle temporal
    if($_POST['action'] == 'delProductoDetalle'){
        // print_r($_POST);
        // exit;

        if(empty($_POST['id_detalle'])){
            echo '0';
            exit;
        }else{
            
            $id_detalle   = $_POST['id_detalle'];
            $user       = $_SESSION['id'];

            $query_iva = mysqli_query($conexion,"SELECT parametro_valor FROM parametros_impositivos WHERE parametro_descripcion = 'IVA'");
            $result_iva = mysqli_num_rows($query_iva);

            // $sql = "CALL add_detalle_temp($id,$cantidad,$user)";
            // echo $sql;
            // exit;
            $query_detalle = mysqli_query($conexion,"CALL del_detalle_temp($id_detalle,$user)");
            
            $result = mysqli_num_rows($query_detalle);
            

            $detalleTabla   = '';
            $subtotal       =0;
            $iva            =0;
            $total          =0;
            $arrayData      =array();

            if($result > 0){
                if($result_iva > 0){
                    $info_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $info_iva['parametro_valor'];
                }

                while($data = mysqli_fetch_assoc($query_detalle)){
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $subtotal = round($subtotal + $precioTotal, 2);
                    $total = round($total + $precioTotal,2);

                    $detalleTabla .= '<tr>
                                        <td>'.$data["rela_producto"].'</td>
                                        <td colspan="2">'.$data["producto_descripcion"].'</td>
                                        <td align="center">'.$data["cantidad"].'</td>
                                        <td colspan="2" align="right">$ '.$data["precio_venta"].'</td>
                                        <td align="right">$ '.$precioTotal.'</td>
                                        <td><a class="btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"><i class="far fa-trash-alt" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"></i></a></td>
                                    </tr>';

                }

                $impuesto       = round($subtotal * ($iva / 100), 2);
                $total_siniva   = round($subtotal - $impuesto, 2);
                $total          =round($total_siniva + $impuesto, 2);

                $detalleTotales = ' <tr>
                                        <td colspan="6" align="right">SUBTOTAL $</td>
                                        <td align="right">'.$total_siniva.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">IVA ('.$iva.'%)</td>
                                        <td align="right">$ '.$impuesto.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">TOTAL $</td>
                                        <td align="right">'.$total.'</td>
                                    </tr>';

                $arrayData['detalle'] =$detalleTabla;
                $arrayData['totales'] =$detalleTotales;

                echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
            }else {
                echo '0';
            }
            mysqli_close($conexion);


        }
        exit;
       
    }

    //ANULAR pedido
    if($_POST['action'] == 'anularPedido'){
        
        $user = $_SESSION['id'];
        $query_del = mysqli_query($conexion,"DELETE FROM detalle_temp WHERE rela_user=$user");
        mysqli_close();
        if($query_del){
            echo 'Ok';
        }else{
            echo '0';
        }
        exit;
    }

    //procesar pedido
    if($_POST['action'] == 'procesarPedido'){
        if(empty($_POST['cliente'])){
            $idcliente = 1;
        }else {
            $idcliente = $_POST['cliente'];
        }

        $usuario = $_SESSION['id'];

        $query = mysqli_query($conexion,"SELECT * FROM detalle_temp where rela_user = $usuario");
        $result = mysqli_num_rows($query);

        if ($result > 0) {
            $query_procesar = mysqli_query($conexion,"CALL procesar_pedido($idcliente,$usuario)");
            $result_detalle = mysqli_num_rows($query_procesar);

            if ($result_detalle > 0) {
                
                echo 'Pedido agregado correctamente';
            }else {
                echo "0";
            }
        }else {
            echo "0";
        }
        mysqli_close($conexion);
        exit;
    }
?>
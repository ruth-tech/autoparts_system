<?php
    session_start();
    include '../../../php/conexion.php';

    //EXTRAER DATOS DEL CLIENTE
    if($_POST['action']== 'datosCliente'){
        $id = $_POST['id'];
        $query = mysqli_query($conexion,"SELECT c.idcliente,p.pedido_fecha"
        ." FROM pedidos p"
        ." INNER JOIN vw_cliente_nombre c ON c.`idcliente`=p.`rela_cliente`"
        . " WHERE p.pedido_id = $id");
        $r =  mysqli_fetch_assoc($query);
        
        $res  = mysqli_num_rows($query);
        $cliente = $r['idcliente'];
        // echo $cliente;
        // exit;  
        $return_array=array();  
        if($res > 0){
            $sql = mysqli_query($conexion,"SELECT 
                                    c.cliente_id AS id, pf.persona_dni AS dni,
                                    CONCAT(pf.apellidos_persona,', ',pf.nombres_persona) AS cliente,
                                    pc.valor_contacto AS contacto, pd.barrio,pd.calle,pd.altura,pd.piso,pd.torre,pd.manzana,pd.sector,pd.parcela" 
                                ." FROM clientes c"
                                ." INNER JOIN personas_fisicas pf ON c.rela_persona_fisica = pf.persona_fisica_id"
                                ." INNER JOIN persona_contacto pc ON pf.rela_persona = pc.rela_persona"
                                ." INNER JOIN tipo_contacto tc ON pc.rela_tipo_contacto = tc.tipo_contacto_id"
                                ." INNER JOIN persona_domicilio pd ON pf.rela_persona = pd.rela_persona"
                                ." WHERE c.estado=1 
                                    AND tc.tipo_contacto_descripcion = 'telefono celular'
                                    AND pc.estado = 1
                                    AND pd.estado = 1
                                    AND c.cliente_id = $cliente");

            $datosCliente= mysqli_fetch_assoc($sql);
            $row_array['fecha']=$r['pedido_fecha'];
            $row_array['id']=(!empty($datosCliente['id']))   ?  $datosCliente['id'] : "-" ;
            $row_array['dni']=(!empty($datosCliente['dni']))   ?  $datosCliente['dni'] : "-" ;
            $row_array['cliente']=(!empty($datosCliente['cliente']))   ?  $datosCliente['cliente'] : "CF" ;
            $row_array['contacto']=(!empty($datosCliente['contacto']))   ?  $datosCliente['contacto'] : "-" ;
            $calle = (!empty($datosCliente['calle']))   ?  'Calle:'.$datosCliente['calle'] : "" ;
            $altura = (!empty($datosCliente['altura']))   ?  'Altura:'.$datosCliente['altura'] : "" ;
            $torre = (!empty($datosCliente['torre']))   ?  'Torre:'.$datosCliente['torre'] : "" ;
            $piso = (!empty($datosCliente['piso']))   ?  'Piso:'.$datosCliente['piso'] : "";
            $manzana = (!empty($datosCliente['manzana']))   ?  'Mz:'.$datosCliente['manzana'] : "";
            $sector = (!empty($datosCliente['sector']))   ?  'Sector:'.$datosCliente['sector'] : "" ;
            $parcela = (!empty($datosCliente['parcela']))   ?  'Casa:'.$datosCliente['parcela'] : "" ;            
            $row_array['domicilio']=(!empty($datosCliente['barrio']))   ?  $datosCliente['barrio']." ".$calle." ".$altura." ".$piso." ".$torre." ".$manzana." ".$sector." ".$parcela : "-" ;
            ;

            array_push($return_array,$row_array);
            
            $cli = json_encode($return_array);
            echo $cli;
            exit;

        }else{
            echo '0';
            exit;
        }
    }
    
    // EXTRAER DATOS DEL PEDIDO
    if($_POST['action'] == 'datosPedido'){
        if(empty($_POST['id'])){
            echo '0';
            exit;
        }else{
            $pedidoid = $_POST['id'];

            $user       = $_SESSION['id'];

            $query = mysqli_query($conexion,"SELECT dp.detalle_pedido_id AS correlativo,pedido_cantidad as cantidad, precio_venta,
                                                p.producto_id,producto_descripcion"               
                                                ." FROM detalle_pedido dp"
                                                ." INNER JOIN productos p
                                                ON dp.rela_producto = p.producto_id"
                                                ." WHERE dp.rela_pedido = $pedidoid");

            $result = mysqli_num_rows($query);
            

            //borrar datos de tabla detalle_pedido
            $delete = mysqli_query($conexion,"DELETE FROM detalle_pedido where rela_pedido=$pedidoid");
            //borrar datos de tabla pedidos
            $delete = mysqli_query($conexion,"DELETE FROM pedidos where pedido_id=$pedidoid");

            $query_iva = mysqli_query($conexion,"SELECT parametro_valor FROM parametros_impositivos WHERE parametro_descripcion = 'IVA'");
            $result_iva = mysqli_num_rows($query_iva);

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
                    //extraigo el precio actual de los productos del detalle
                    $pre = mysqli_query($conexion,"SELECT precio_venta 
                    FROM productos p
                    INNER JOIN (
                        SELECT producto_precio.rela_producto, MAX(producto_precio.precio_fecha) AS Fecha
                        FROM producto_precio
                        GROUP BY producto_precio.rela_producto
                    ) precios2 ON p.producto_id = precios2.`rela_producto`
                    INNER JOIN (
                        SELECT producto_precio.`rela_producto`, producto_precio.`precio_venta`, producto_precio.precio_fecha
                        FROM producto_precio
                    ) producto_precio ON producto_precio.`precio_fecha` = precios2.Fecha 
                    AND producto_precio.rela_producto = precios2.rela_producto 
                    WHERE p.producto_id=".$data['producto_id']);

                    $res = mysqli_fetch_assoc($pre);
                    $precio_actual=$res['precio_venta'];

                    $insert = mysqli_query($conexion,"INSERT INTO detalle_temp(rela_user,rela_producto,cantidad,precio_venta) VALUES($user,".$data['producto_id'].",".$data['cantidad'].",".$precio_actual.")");

                    $precioTotal = round($data['cantidad'] * $precio_actual, 2);
                    $subtotal = round($subtotal + $precioTotal, 2);
                    $total = round($total + $precioTotal,2);

                    $detalleTabla .= '<tr>
                                        <td>'.$data["producto_id"].'</td>
                                        <td colspan="2">'.$data["producto_descripcion"].'</td>
                                        <td align="center">'.$data["cantidad"].'</td>
                                        <td colspan="2" align="right">$ '.$precio_actual.'</td>
                                        <td align="right">$ '.$precioTotal.'</td>
                                        <td><a class="btn btn-danger" href="#" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"><i class="far fa-trash-alt" onclick="event.preventDefault(); del_product_detalle('.$data["correlativo"].')"></i></a></td>
                                    </tr>';

                }

                $impuesto       = round($subtotal * ($iva / 100), 2);
                $total_siniva   = round($subtotal - $impuesto, 2);
                $total          =round($total_siniva + $impuesto, 2);

                $detalleTotales = ' <tr>
                                        <td colspan="6" align="right">SUBTOTAL </td>
                                        <td align="right">$ '.$total_siniva.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">IVA ('.$iva.'%)</td>
                                        <td align="right">$ '.$impuesto.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">TOTAL</td>
                                        <td align="right">$ '.$total.'</td>
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

    //ANULAR PEDIDO
       if($_POST['action'] == 'anularPedido'){
        
        $user = $_SESSION['id'];
        $query_del = mysqli_query($conexion,"DELETE FROM detalle_temp WHERE rela_user=$user");
        mysqli_close($conexion);
        if($query_del){
            echo 'Ok';
        }else{
            echo '0';
        }
        exit;
    }


    //PROCESAR PEDIDO
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
            // echo $query_procesar;exit;
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
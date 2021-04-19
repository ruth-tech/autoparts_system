<?php

    require '../../php/conexion.php' ;


    $sql1="SELECT p.`pedido_id`, 
    p.pedido_fecha,
    p.pedido_subtotal,
    p.pedido_descuento,
    p.pedido_total,
    dp.pedido_cantidad,
    dp.rela_producto,
    pe.pedido_estado_descripcion,
    c.`nombreCliente`,
    e.`nombreEmpleado`" 
    ." FROM pedidos p" 
    ." INNER JOIN detalle_pedido dp ON p.`pedido_id`=dp.`rela_pedido`" 
    ." INNER JOIN pedidos_estados pe ON p.`rela_pedido_estado`=pe.`pedido_estado_id`" 
    ." INNER JOIN vw_cliente_nombre c ON c.`idcliente`=p.`rela_cliente`" 
    ." INNER JOIN vw_empleado_nombre e ON e.`idempleado`=p.`rela_empleado` ";
    // echo $sql1;
    // exit;

    $rs_pedidos = $conexion->query($sql1) or die($conexion->error);

    

    $sql4 = "SELECT * FROM productos p" 
    ." INNER JOIN (
        SELECT producto_precio.rela_producto, MAX(producto_precio.precio_fecha) AS Fecha
        FROM producto_precio
        GROUP BY producto_precio.rela_producto
    ) precios2 ON p.producto_id = precios2.`rela_producto`"
    ." INNER JOIN (
        SELECT producto_precio.`rela_producto`, producto_precio.`precio_venta`, producto_precio.precio_fecha
        FROM producto_precio
    ) producto_precio ON producto_precio.`precio_fecha` = precios2.Fecha 
    AND producto_precio.rela_producto = precios2.rela_producto";

    $rs_productos = $conexion->query($sql4) or die($conexion->error);

    // $productos = $rs_productos->fetch_assoc();
    

?>

<div class="card-body-todos text-danger">
<table class="table table-striped table-responsive" id="listado-head">
    <thead >
        <tr>
            <th >ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Detalles</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

    </thead>
    <tbody>
    <?php while ($row = $rs_pedidos->fetch_assoc()): ?>
        <?php 
            if($row['pedido_estado_descripcion']=='PENDIENTE'){
                $class='badge-warning';
            }elseif($row['pedido_estado_descripcion']=='ANULADO'){
                $class='badge-danger';
            }elseif($row['pedido_estado_descripcion']=='FINALIZADO'){
                $class='badge-success';
            }elseif($row['pedido_estado_descripcion']=='EN COLA'){
                $class='badge-primary';
            }
        ?>
        <tr>
            <td><?php echo $row['pedido_id']; ?></td>
            <td><?php echo $row['pedido_fecha']; ?></td>
            <td><?php echo $row['nombreCliente']?></td>            
            <td><?php echo $row['nombreEmpleado']?></td>            
            <td>
                <a href="#">Ver</a>
                <!-- <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Descripcion producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //while($detalle = $rs_productos->fetch_assoc()):?>
                            <tr>
                                <?php //if ($row['rela_producto']===$detalle['producto_id']):?>
                                <td>
                                    <?php
                                    //echo $detalle['producto_descripcion'].', '.$detalle['producto_detalle_fabricante'];
                                    ?>
                                </td>
                                <td>
                                    <?php //echo $row['pedido_cantidad'];?>
                                </td>
                                <td>
                                    <?php //echo $detalle['precio_venta'];?>
                                </td>
                                <td>
                                    <?php 
                                    //$subtotal = $row['pedido_cantidad']*$detalle['precio_venta'];
                                    //echo $subtotal;
                                    ?>
                                </td>
                                <?php //endif;?>
                            </tr>
                        <?php //endwhile;?>

                    </tbody>
                </table> -->
            </td>
            <td>total</td>
            <td><span class="badge badge-pill <?php echo $class?>">
                <?php echo $row['pedido_estado_descripcion']; ?>
            </span>
            </td>
            <td>
                <button class="cliente-edit btn btn-warning" data-toggle="modal" data-target="#editarCliente" personaId="${lista.personaId}" ><i class="far fa-edit"></i></button>
                <button class="deleteCliente btn btn-danger"><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>
<?php
session_start();
    require '../../php/conexion.php';

    

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    if(!isset($_SESSION['carrito'])){
        if(isset($_SESSION['carrito'])){
            $arreglo=$_SESSION['carrito'];
            $encontro=false;
            $numero=0;
            for($i=0;$i<count($arreglo);$i++){
                if($arreglo[$i]['Id']==$_GET['productoId']){
                    $encontro=true;//utilizo una bandera para determinar que si encontro ese id en el arreglo
                    $numero=$i;//para capturar la posicion del arreglo en donde estaba ese id
                }
            }
            if($encontro==true){
                $arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']+1;
                $_SESSION['carrito']=$arreglo;
            }else{
                $id="";
                $nombre="";
                $detalle="";
                $precio=0;
                $sql="SELECT * FROM productos p"
                ." INNER JOIN `productoxcategoriaxmodelo` pcm ON pcm.`rela_producto`=p.`producto_id`"
                ." INNER JOIN 
                    ( SELECT producto_precio.rela_producto, MAX(producto_precio.precio_fecha) AS Fecha 
                    FROM producto_precio GROUP BY producto_precio.rela_producto )
                    precios2 ON p.producto_id = precios2.`rela_producto` "
                ." INNER JOIN 
                    ( SELECT producto_precio.`rela_producto`, producto_precio.`precio_venta`, producto_precio.precio_fecha 
                    FROM producto_precio ) 
                    producto_precio ON producto_precio.`precio_fecha` = precios2.Fecha 
                    AND producto_precio.rela_producto = precios2.rela_producto" 
                ." INNER JOIN producto_detalles pd ON p.producto_id=pd.rela_producto WHERE pcm.`productoxcategoria_id`=".$_GET['productoId'];
                // echo $sql;
                // exit;
                
                $res=mysqli_query($conexion,$sql);
                while($f=mysqli_fetch_array($res)){
                    $id=$f['producto_id'];
                    $nombre=$f['producto_descripcion'];
                    $detalle=$f['producto_detalle_descripcion'];
                    $precio=$f['precio_venta'];
                }
                $datosNuevos=array('Id'=>$_GET['productoId'],
                                    'Nombre'=>$nombre,
                                    'Detalles'=>$detalle,
                                    'Precio'=>$precio,
                                    'Cantidad'=>1);
                array_push($arreglo, $datosNuevos);
                $_SESSION['carrito']=$arreglo;
            }
        }else{
            if(isset($_GET['productoId'])){
                $nombre="";
                $detalle="";
                $precio=0;
                $sql="SELECT * FROM productos p"
                ." INNER JOIN `productoxcategoriaxmodelo` pcm ON pcm.`rela_producto`=p.`producto_id`"
                ." INNER JOIN 
                    ( SELECT producto_precio.rela_producto, MAX(producto_precio.precio_fecha) AS Fecha 
                    FROM producto_precio GROUP BY producto_precio.rela_producto )
                    precios2 ON p.producto_id = precios2.`rela_producto` "
                ." INNER JOIN 
                    ( SELECT producto_precio.`rela_producto`, producto_precio.`precio_venta`, producto_precio.precio_fecha 
                    FROM producto_precio ) 
                    producto_precio ON producto_precio.`precio_fecha` = precios2.Fecha 
                    AND producto_precio.rela_producto = precios2.rela_producto" 
                ." INNER JOIN producto_detalles pd ON p.producto_id=pd.rela_producto WHERE pcm.`productoxcategoria_id`=".$_GET['productoId'];
                // echo $sql;
                // exit;
                
                $consulta=mysqli_query($conexion,$sql);
                while($f=mysqli_fetch_array($consulta)){
                    $nombre=$f['producto_descripcion'];
                    $detalle=$f['producto_detalle_descripcion'];
                    $precio=$f['precio_venta'];
                }
                $arreglo[]=array('Id'=>$_GET['productoId'],
                            'Nombre'=>$nombre,
                            'Detalles'=>$detalle,
                            'Precio'=>$precio,
                            'Cantidad'=>1);

                $_SESSION['carrito']=$arreglo;

            }        
        }
    }else{
        echo '<script>alert("Funciona el alert")</script>';
    }

    // OBTENGO DESDE LA BASE DE DATOS LAS MARCAS DE LOS VEHICULOS REGISTRADOS PARA AGREGAR UN PRODUCTO A UN PEDIDO
    $sql = "SELECT * FROM vehiculos";
    $rs_vehiculos=mysqli_query($conexion,$sql);
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo pedido</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <script src="nuevo.js"></script>

    <script>
    
    </script>
    
</head>
<body>

    

    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="container">

            <div class="card" id="card-main">
                <div class="card-header">                    
                    <h3><i class="far fa-edit"></i>Nuevo pedido</h3>
                </div>
                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                <form>
                    <div class="form-horizontal">
                        <br>
                        <div class="col-6">
                            <select name='consumidor' id='consumidor'>
                                <option value="1" selected>Consumidor Final</option>
                                <option value="2">Cliente</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group row">                            
                            <div class="col-6">
                                <label >Cliente</label>
                                <input type="text" id="cliente" class="form-control" placeholder="Seleccione un Cliente" disabled>                 
                            </div>
                            <div class="col-6">
                                <label >Domicilio</label>
                                <input type="text" id="domicilio" class="form-control" placeholder="Password" disabled>
                            </div>
                        </div>
                        <div class="form group row">
                            <div class="col-6">
                                <label >Email</label>
                                <input type="text" id="email" class="form-control" placeholder="Email" disabled>
                            </div>
                            <div class="col-6">
                                <label>Telefono</label>
                                <input type="text" id="telefono" class="form-control" placeholder="Telefono" disabled>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-12">
                        <div align="right">
                            
                            <button type="button" id="nuevo_cliente" class="btn btn-outline-danger" data-toggle="modal" data-target="#nuevoCliente" disabled>
                            <i class="fas fa-user"></i> Nuevo cliente
                            </button>
                            <button type="button" class="btn btn-outline-danger agregarproductos" data-toggle="modal" data-target="#agregarProductos">
                            <i class="fas fa-search"></i> Agregar productos
                            </button>
                            
                        </div>	
				    </div>
                </form>

                <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                <div class="card-body">                    
                    <div class="producto">
                        <table class="table responsive productos">
                            <thead>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Detalle</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </thead>
                            <?php
                                $total=0;
                                if(isset($_SESSION['carrito'])){
                                    $datos=$_SESSION['carrito'];
                                for($i=0;$i<count($datos);$i++): ?>
                            <tbody>                                    
                                <td><?php echo $datos[$i]['Id']?></td>
                                <td><?php echo $datos[$i]['Nombre']?></td>
                                <td><?php echo $datos[$i]['Detalles']?></td>
                                <td><?php echo $datos[$i]['Precio']?></td>
                                <td><?php echo $datos[$i]['Cantidad']?></td>
                                <td><?php echo $datos[$i]['Cantidad']*$datos[$i]['Precio']?></td>
                                
                            </tbody>
                        </table>
                    </div>
                    <?php
                        $total=($datos[$i]['Cantidad']*$datos[$i]['Precio'])+$total;
                            endfor;
                            echo '<center><h2>Total: '.$total.'</h2></center>';
                            echo '<center><a href="/autoparts_system/modulos/productos/index.php" class="btn btn-danger">Confirmar pedido</a></center>';
                        }else{
                            echo '<center><h4>El pedido esta vacio! Seleccione los productos desde el <a href="/autoparts_system/modulos/productos/index.php">Listado</a></h4></center>';
                            
                        }

                        
                    ?>

                </div>
            </div> 

            <!-- Modal AGREGAR PRODUCTOS-->
            <div class="modal fade" id="agregarProductos" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese los datos del cliente</h3>
                                <p>
                                <div class="form-group">
                                    <label>Marca de vehiculo:
                                    <select name="marcavehiculo" id="marcavehiculo" class="form-control col-10">
                                    <option value="">--SELECCIONE--</option>
                                        <?php 
                                            while ($row = $rs_vehiculos->fetch_assoc()) {
                                            echo '<option VALUE="'.$row['vehiculo_id'].'">'.$row['vehiculo_descripcion'].'</option>' ;
                                            };
                                        ?>
                                    </select>
                                    </label>

                                    <label>Modelos de la marca:
                                    <select name="modelos" id="modelos" class="form-control col-10">
                                    <option value="" >--SELECCIONE--</option>
                                    </select>
                                    </label>

                                    <label>Año:
                                    <select name="anio" id="anio" class="form-control col-10">
                                    <option value="" >--SELECCIONE--</option>
                                    </select>
                                    </label>
                                </div>
                                    
                                </p> 
                                <p>
                                <div class="form-group">
                                <label>Escriba su apellido </label>
                                    <input type="text" id="apellido" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Escriba su DNI:</label>
                                    <input type="text" id="dni" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                 <p>
                                <div class="form-group">
                                    <label>Escriba su Cuil:</label>
                                    <input type="text" id="cuil" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                
                                <p>
                                <div class="form-group">
                                <label>Genero:</label>
                                <select name="sexo" id="sexo">
                                    <option value="">--SELECCIONE--</option>
                                    <?php 
                                    while ($row = $sexo->fetch_assoc()) {
                                    echo '<option VALUE="'.$row['id_sexo'].'">'.$row['descripcion_sexo'].'</option>'  ;
                                    }

                                    ?>
                                </select>
                                    
                                </div>                            
                                </p>
                                
                                
                                <p>
                                <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                    <input type="date" id="fchNac" placeholder="
                                    AAAA/MM/DD">
                                    </label>
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidad" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Nro. de cuenta</label>
                                    <input type="text" id="nro_cuenta" >
                                    </label>
                                </div>
                                
                                </p> 
                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal AGREGAR-->

        </div>

        


        <?php require "../../php/footer.php"; ?>
    </div> 
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> -->
    

</body>
</html>
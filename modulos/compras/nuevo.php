<?php
session_start();
    require '../../php/conexion.php';

    

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }
    
    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        
    }

    $proveedores = mysqli_query($conexion,"SELECT
        p.proveedor_id AS id,
        pj.razon_social AS nombre
    FROM proveedores p INNER JOIN personas_juridicas pj ON p.rela_persona_juridica = pj.persona_juridica_id");

    $documento = mysqli_query($conexion,"SELECT * FROM tipo_documento");
    // $tipo_fac = mysqli_fetch_assoc($query);

    $query1 = mysqli_query($conexion,"SELECT * FROM tipo_pago");
    // $tipo_pago = mysqli_fetch_assoc($query1);

    $vehiculos = mysqli_query($conexion,"SELECT vehiculo_id AS id,
    vehiculo_descripcion AS nombre
    FROM vehiculos
    ");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva compra</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <script src="js/nuevo.js"></script>

    <style>
    input#txt_cod_producto{
        width: 50%;
        border-radius: 25px;
    }
    input#text_cant_producto{
        width: 50%;
        border-radius: 25px;
    }
    input#txt_precio{
        width: 50%;
        border-radius: 25px;
    }

    
    </style>
    
</head>
<body>
    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="container">

            <div class="card" id="card-main">
                <div class="card-header">                    
                    <h3><i class="far fa-edit"></i>Nueva compra</h3>
                </div>
                <div class="card">                    
                    <!-- +++++ -->
                    <div class="card-body">
                        <form>
                            <div class="form-horizontal">
                                
                                <div class="col-12">
                                    <!-- <select name='consumidor' id='consumidor'>
                                        <option value="1" selected>Consumidor Final</option>
                                        <option value="2">Cliente</option>
                                    </select> -->
                                    <div class="fa-pull-right"> 
                                        <p>
                                        Usuario: <?php echo $usuario;?>                                        
                                        </p>
                                        <p>
                                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#nuevoProveedor"><i class="fas fa-user-plus"></i>
                                            Nuevo Proveedor
                                        </button>
                                        </p>
                                        <p>
                                        <button type="button" class="producto-add btn btn-outline-danger" data-toggle="modal" data-target="#nuevoProducto"><i class="fas fa-plus"></i>
                                            Nuevo Producto
                                        </button>
                                        </p>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="form-group row">                           
                                    <div class="col-4">
                                    <label>Documentación:</label>
                                        <select name="doc" id="doc" required>
                                            <option value="">--SELECCIONE--</option>
                                            <?php 
                                            while ($row = $documento->fetch_assoc()) {
                                            echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>'  ;
                                            }
                                            ?>
                                        </select>               
                                    </div>
                                    <br>
                                    <div class="col-4">
                                    <label>Proveedor:</label>
                                        <select name="proveedor" id="proveedor" required>
                                            <option value="">--SELECCIONE--</option>
                                            <?php 
                                            while ($row = $proveedores->fetch_assoc()) {
                                            echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>'  ;
                                            }
                                            ?>
                                        </select> 
                                    </div>
                                                         
                                </div>
                                    
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <!-- +++++ -->
                    <div class="card-header">Agregar Producto</div>
                    <!-- <div class="card-body">    -->
                    <div class="buscar-producto">
                        <table class=" table table-bordered responsive">
                            <thead>
                                <tr style="background:#c3c3c3">
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th colspan="2">Detalle</th>
                                            
                                    <th>Cantidad</th>
                                    <th>Precio compra</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="txt_cod_producto" placeholder="Ingresar codigo" id="txt_cod_producto" ></td>
                                    <td id="txt_descripcion">-</td>
                                    <td id="txt_detalle"colspan="2">-</td>
                                   
                                    <td><input type="text" name="text_cant_producto" id="text_cant_producto" value="0" min="1" disabled></td>
                                    <td ><input type="text" id="txt_precio" align="right" value="0" min="1" disabled></td>
                                    <td id="txt_subtotal" align="right">$ 0.00</td>
                                    <td><a href="#" id="add_product_compra" class="agregarproductos" style="display:none;color:green" title="Agregar a compra" ><i class="fas fa-plus" ></i>Agregar</a></td> <!-- ""-->
                                </tr>
                            
                                <tr style="background:#c3c3c3">
                                    <th>Codigo</th>
                                    <th colspan="2">Nombre</th>
                                    <th>Cantidad</th>
                                    <th colspan="2" align="right">Precio</th>
                                    <th align="right">Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            
                            </thead>
                            <tbody id="detalle_compra">  
                                <!-- CONTENIDO AJAX                      -->
                            </tbody>
                            <tfoot id="detalle_totales">
                            <!-- CONTENIDO AJAX   
                                                -->
                            </tfoot>
                        </table>
                        <div class="text-center">
                            <a href="#" id="anular_pedido" style="display:none;" class="btn btn-secondary"><i class="fas fa-ban"></i> Anular compra</a>
                            <a href="#" id="continuar" style="display:none;" class="btn btn-success" data-toggle="modal" data-target="#modal_fac"><i class="far fa-edit" ></i> confirmar compra</a>
                            <!-- <a href="#" id="confirma_pedido" style="display:none;" class="btn btn-success"><i class="far fa-edit" ></i> Facturar venta</a> -->
                        </div>
                    </div>  
                </div>

                <!-- Modal AGREGAR PROVEEDOR-->
                <div class="modal fade" id="nuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>

                            <div class="modal-body">
                                <form role="form" method="post" id="agregar">
                                    <h3>Ingrese los datos del Proveedor</h3>
                                    <p>
                                    <div class="form-group">
                                        <label>Cuit: </label>
                                        <input type="text" id="cuit">
                                        </label>
                                        
                                    </div>
                                        
                                    </p>    
                                    <p>
                                    <div class="form-group">
                                    <label>Razon Social</label>
                                        <input type="text" id="razonsocial" >
                                        </label>
                                        
                                    </div>
                                        
                                    </p>
                                    

                                    <p>
                                    <div class="form-group">
                                    <label>N° habilitacion:</label>
                                        <input type="text" id="nrohabilitacion" >
                                        </label>
                                        
                                    </div>                                    
                                    </p>

                                    <p>
                                    <div class="form-group">
                                    <label>Web-site oficial:</label>
                                        <input type="text" id="website" >
                                        </label>
                                        
                                    </div>                                    
                                    </p>
                                    
                                    
                                    <button type="submit" class="btn btn-danger">Agregar</button>

                                </form>
                            </div> 

                        </div> <!--/.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal AGREGAR PROVEEDOR-->

                <!-- Modal AGREGAR PRODUCTO-->
                <div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>

                            <div class="modal-body text-dark">
                                <form role="form" method="post" id="agregar">
                                    <h3>Ingrese los datos del producto</h3>

                                    <p>
                                        <div class="form-group">
                                            <label>Vehiculo:
                                            <select name="vehiculo" id="vehiculo" class="form-control col-10">
                                            <option value="" >--SELECCIONE--</option>
                                                <?php 
                                                    while ($row = $vehiculos->fetch_assoc()) {
                                                    echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>' ;
                                                    };
                                                ?>
                                            </select>
                                            </label>

                                            <label>Modelos:
                                            <select name="modelos" id="modelos" class="form-control col-10">
                                            <option value="" >--SELECCIONE--</option>
                                            </select>
                                            </label>

                                            <label>Año:
                                            <select name="anio" id="anio" class="form-control col-10">
                                            <option value="" >--SELECCIONE--</option>
                                            </select>
                                            </label>

                                            <label>Categorias:
                                            <select name="categoria" id="categoria" class="form-control col-10">
                                            <option value="" >--SELECCIONE--</option>
                                            </select>
                                            </label>
                                        </div>
                                        
                                    </p>                               
                                    
                                    <p>
                                        <div class="form-group">
                                            <label>Descripcion: </label>
                                            <input type="text" id="descripcion" style="text-transform:uppercase">                        
                                        </div>                                    
                                    </p>   
                                    <p>
                                        <div class="form-group">
                                            <label>Fabricante: </label>
                                            <input type="text" id="fabricante" style="text-transform:uppercase">                        
                                        </div>                                    
                                    </p> 
                                    <p>
                                        <div class="form-group">
                                            <label>Cantidad: </label>
                                            <input type="text" id="cantidad" style="text-transform:uppercase">                        
                                        </div>                                    
                                    </p> 
                                    
                                    <p>
                                        <div class="form-group">
                                            <label>Precio venta: </label>
                                            <input type="text" id="precioventa" style="text-transform:uppercase">                        
                                        </div>                                    
                                    </p> 
                                    <p>
                                        <div class="form-group">
                                            <label>Detalles: </label>
                                            <input type="text" id="detalles" style="text-transform:uppercase" placeholder="Color, Material, Lado, etc.">                        
                                        </div>                                    
                                    </p> 
                                    
                                                                    
                                    <button type="submit" class="btn btn-danger">Agregar</button>

                                </form>
                            </div> 

                        </div><!-- /.modal-content -->
                    </div><!--  /.modal-dialog -->
                </div><!-- /.modal AGREGAR PRODUCTO --> 
                
                <!-- Modal SELECCIONAR TIPO FACTURA Y TIPO DE PAGO-->
                <div class="modal fade" id="modal_fac" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>

                            <div class="modal-body">
                                <form role="form" method="post" id="modal_fac">
                                    <strong><h3>Seleccione los datos correspondientes</h3></strong>
                                        
                                    <p>
                                        <div class="form-group">
                                            <label>Tipo de Pago:</label>
                                            <select name="pago" id="pago">
                                                <option value="">--SELECCIONE--</option>
                                                <?php 
                                                while ($row = $query1->fetch_assoc()) {
                                                echo '<option VALUE="'.$row['tipo_pago_id'].'">'.$row['tipo_pago_descripcion'].'</option>'  ;
                                                }
                                                ?>
                                            </select>                                    
                                        </div>                            
                                    </p>
                                        
                                    <a href="#" id="confirma_pedido" class="btn btn-success"><i class="fas fa-check"></i> Finalizar compra</a>

                                    </form>
                                </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal Seleccionar tipo_pago -->
                
            </div> 

        </div>

    
    </div> 
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> -->
    
    <?php require "../../php/footer.php"; ?>

    <script>
        $(document).ready(function(){
            var usuarioid = '<?php echo $_SESSION['id']?>';
            searchForDetalle(usuarioid);
        })
    </script>
</body>
</html>
<?php

    require '../../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location:../../index.php?error=debe_loguearse");
      exit;
    }

    $categoriaid = $_GET['categoriaid'];
    $modeloid = $_GET['modeloid'];

    $sql = "SELECT * FROM categorias WHERE prod_categoria_id=".$categoriaid;

    $rs = $conexion->query($sql) or die($conexion->error);

    $cat = $rs->fetch_assoc();
    // echo $cat['prod_categoria_descripcion'];
    // exit;

    // echo $categoriaid, $modeloid;

    // $sql = "SELECT * FROM productoxcategoriaxmodelo"
    // ." INNER JOIN productos ON productoxcategoriaxmodelo.rela_producto = productos.producto_id"
    // ." INNER JOIN categorias ON productoxcategoriaxmodelo.rela_categoria = categorias.prod_categoria_id"
    // ." INNER JOIN modelos_vehiculos ON productoxcategoriaxmodelo.rela_modelo = modelos_vehiculos.modelo_vehiculo_id"
    // ." WHERE categorias.prod_categoria_id = ".$categoriaid
    // ." AND modelos_vehiculos.modelo_vehiculo_id =".$modeloid;
    // echo $sql;
    // exit();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <?php require '../../../php/head_link.php'; ?>
    <?php require '../../../php/head-datatables-link.php';?>
    <?php require '../../../php/head_script.php'; ?>
    <?php require '../../../php/head-datatables-script.php';?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\marcas.css"> -->
    <script src="productos.js"></script>
   

<?php 

?>
    
</head>
<body>    

    <?php require '../../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nuevoProducto"><i class="fas fa-plus"></i>
                            Agregar
                    </button>
                    

                </div>
                <h3>Productos</h3>     
                <h5> Categoria: <?php echo $cat['prod_categoria_descripcion']?></h5> 
                <input type="hidden" id="categoria" categoriaid="<?php echo $categoriaid?>">
                <input type="hidden" id="modelo" modeloid="<?php echo $modeloid?>">         
            </div>
            <div class="card-body-productos text-danger ">
                
                <table class="table table-striped" id="listado-productos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Fabricante</th>
                            <th>Detalles</th>
                            <th>Precio</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <!-- <tbody id="productoslista">

                    </tbody> -->

                </table>
            </div>
            <!-- Modal AGREGAR -->
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
                                        <label>Precio proveedor: </label>
                                        <input type="text" id="precioproveedor" style="text-transform:uppercase">                        
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
            </div><!-- /.modal AGREGAR -->

            <!-- Modal EDITAR PRODUCTOS-->
           <div class="modal fade" id="editarProducto" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editar-producto">
                            <strong><h3>Modificar datos del Producto </h3></strong>
                                <div class="card border-danger" >
                                    <div class="card-body text-danger">
                                        <h5 class="card-title text-center"><i class="fas fa-exclamation-triangle"></i>Advertencia<i class="fas fa-exclamation-triangle"></i></h5>
                                        <p class="card-text">¡Si se desea modificar el precio se debe acceder al precio actual!</p>
                                    </div>
                                </div>
                                <input type="hidden" name="productoid" id="productoidedit">                           
                                <p>
                                <div class="form-group">
                                <label>Descripcion:</label>
                                    <input type="text" id="descripcionedit" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Fecha de ingreso:</label>
                                    <input type="text" id="fechaedit" >                                    
                                </div>
                                <p>
                                <div class="form-group">
                                <label>Fabricante:</label>
                                    <input type="text" id="fabricanteedit" >                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Detalles:</label>
                                    <input type="text" id="detallesedit" >                                    
                                </div>
                                </p>
                               
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal EDITAR -->

            <!-- Modal EDITAR PRECIO-->
           <div class="modal fade" id="editarPrecio" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editar-precio">
                            <strong><h3>Modificar Precio del Producto </h3></strong>
                              
                                
                                <input type="hidden" name="productoid" id="productoprecioidedit">                           
                                <p>
                                <div class="form-group">
                                <label>Descripcion:</label>
                                    <input type="text" id="descripcionprecioedit" readonly>
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Fabricante:</label>
                                    <input type="text" id="fabricanteprecioedit" readonly>                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Precio del Proveedor:</label>
                                    <input type="text" id="precioproveedoredit" readonly>                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Precio:</label>
                                    <input type="text" id="precioedit" >                                    
                                </div>
                                </p>
                               
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal EDITAR -->

           
                                                           

            </div>
        </div>
        <?php require "../../../php/footer.php"; ?>
    </div> 
</html>
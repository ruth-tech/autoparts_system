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

    <style>
    input#txt_cod_producto{
        width: 50%;
        border-radius: 25px;
    }
    input#text_cant_producto{
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
                    <h3><i class="far fa-edit"></i>Nuevo pedido</h3>
                </div>
                <div class="card">                    
                    <!-- +++++ -->
                    <div class="card-body">
                        <form>
                            <div class="form-horizontal">
                                
                                <div class="col-12">
                                    <select name='consumidor' id='consumidor'>
                                        <option value="1" selected>Consumidor Final</option>
                                        <option value="2">Cliente</option>
                                    </select>
                                    <div class="fa-pull-right">
                                    Vendedor: <?php echo $usuario;?>
                                </div>
                                </div>
                                
                                <br>
                                <div class="form-group row">
                                <input type="hidden" name="idcliente" id="idcliente">                            
                                    <div class="col-6">
                                        <label >DNI</label>
                                        <input type="number" id="buscarCliente" class="form-control" placeholder="Ingrese DNI del cliente registrado" disabled>                 
                                    </div>
                                    <div class="col-6">
                                        <label >Nombre</label>
                                        <input type="text" id="nombre" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="form group row">
                                    <div class="col-6">
                                        <label >Telefono</label>
                                        <input type="text" id="telefono"  class="form-control"  disabled required>
                                    </div>
                                    <div class="col-6">
                                        <label>Dirección</label>
                                        <input type="text" id="direccion"  class="form-control" disabled required>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-secondary" role="alert" style="display:none">El cliente no está registrado! Agreguelo al sistema como nuevo cliente o Seleccione consumidor final.</div>
                            <br>
                            <div class="col-12">
                                <div align="right">
                                    
                                    <button type="button" id="nuevo_cliente" style="display:none" class="btn btn-outline-danger" data-toggle="modal" data-target="#nuevoCliente" disabled>
                                    <i class="fas fa-user"></i> Nuevo cliente
                                    </button>                         
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
                                    <th>Detalle</th>
                                    <th>Existencia</th>          
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="txt_cod_producto" placeholder="Ingresar codigo" id="txt_cod_producto" ></td>
                                    <td id="txt_descripcion">-</td>
                                    <td id="txt_detalle">-</td>
                                    <td id="txt_existencia">-</td>
                                    <td><input type="text" name="text_cant_producto" id="text_cant_producto" value="0" min="1" disabled></td>
                                    <td id="txt_precio" align="right">$ 0.00</td>
                                    <td id="txt_subtotal" align="right">$ 0.00</td>
                                    <td><a href="#" id="add_product_venta" class="agregarproductos" style="color:green" title="Agregar a pedido"><i class="fas fa-plus" ></i>Agregar</a></td> <!-- ""-->
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
                            <tbody id="detalle_pedido">  
                                <!-- CONTENIDO AJAX                      -->
                            </tbody>
                            <tfoot id="detalle_totales">
                            <!-- CONTENIDO AJAX   
                                                -->
                            </tfoot>
                        </table>
                        <div class="text-center">
                            <a href="#" id="anular_pedido" style="display:none;" class="btn btn-secondary"><i class="fas fa-ban"></i> Anular pedido</a>
                            <a href="#" id="confirma_pedido" style="display:none;" class="btn btn-danger"><i class="far fa-edit" ></i> Confirmar pedido</a>
                        </div>
                    </div>  
                </div>
 
                
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
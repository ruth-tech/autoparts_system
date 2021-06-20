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
    <title>Visualizar venta</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <!-- <script src="pedidos.js"></script> -->
    <script>
        function cargarCliente(){
            var id = $('#pedidoid').val();  
            var action = 'datosCliente';   
            
            $.ajax({
                url: 'autocompletar/pedido-edit.php',
                type: 'POST',
                async: true,
                data: {id:id,action:action},

                success: function(response){
                    console.log(response);
                    const dato = JSON.parse(response);
                        console.log(dato);
                        $('#idcliente').val(dato[0].id);
                        $('#dniCliente').val(dato[0].dni);
                        $('#fecha').val(dato[0].fecha);
                        $('#nombre').val(dato[0].cliente);
                        $('#telefono').val(dato[0].contacto);
                        $('#direccion').val(dato[0].domicilio);
    
                        $('#nombre').attr('disabled','disabled');
                        $('#telefono').attr('disabled','disabled');
                        $('#direccion').attr('disabled','disabled');
                        // $('#nuevo_cliente').hide("fast");
                },
                error: function(error){
                    console.log(error);
                }

            });
        }
        function cargarDetalle(){                      
            var id = $('#pedidoid').val();  
            var action = 'datosPedido';          
                
            // console.log('el pedido es el n°'+id);
            $.ajax({
                url: 'autocompletar/pedido-edit.php',
                type: 'POST',
                async: true,
                data: {id:id,action:action},

                success: function(response){
                    console.log(response);
                    if(response != 0){
                        
                        var info = JSON.parse(response);
                        // console.log(info);
                        $('#detalle_pedido').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                    //     $('#txt_cod_producto').val('')
                    //     $('#txt_descripcion').html('-');
                    //     $('#txt_detalle').html('-');
                    //     $('#txt_existencia').html('-');
                    //     $('#text_cant_producto').val('0');
                    //     $('#txt_precio').html('$ 0.00');
                    //     $('#txt_subtotal').html('$ 0.00');
                    //     $('#add_product_venta').hide('fast');
                    //     // BLOQUEAR CANTIDAD
                    //     $('#text_cant_producto').attr('disabled','disabled');

                    }else{
                        console.log('No data');
                    }
                    viewButton();
                },
                error: function(error){
                    console.log(error);
                }

            });
        }

        //MOSTRAR/OCULTAR BOTON CONFIRMAR PEDIDO
        function viewButton(){
            if($('#detalle_pedido tr').length > 0){
                $('#confirma_pedido').show();
                $('#anular_pedido').show();
            }else{
                $('#confirma_pedido').hide();
                $('#anular_pedido').hide();
            }
        }

        function del_product_detalle(correlativo){
            var action = 'delProductoDetalle';
            var id_detalle = correlativo;

            $.ajax({
                url: 'autocompletar/agregar_detalle.php',
                type: 'POST',
                async: true,
                data: {action:action,id_detalle:id_detalle},

                success: function(response){
                    console.log(response);
                    
                    if(response != 0){
                                
                        var info = JSON.parse(response);
                        // console.log(info);
                        $('#detalle_pedido').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('')
                        $('#txt_descripcion').html('-');
                        $('#txt_detalle').html('-');
                        $('#txt_existencia').html('-');
                        $('#text_cant_producto').val('0');
                        $('#txt_precio').html('$ 0.00');
                        $('#txt_subtotal').html('$ 0.00');
                        $('#add_product_venta').hide('fast');
                        // BLOQUEAR CANTIDAD
                        $('#text_cant_producto').attr('disabled','disabled');

                    }else{
                        $('#detalle_pedido').html('');
                        $('#detalle_totales').html('');
                    }
                    viewButton();

                    
                },
                error: function(error){
                    console.log(error);
                }
            
            });


        }

        function searchForDetalle(id){
            var action = 'searchForDetalle';
            var user = id;

            $.ajax({
                url: 'autocompletar/agregar_detalle.php',
                type: 'POST',
                async: true,
                data: {action:action,user:user},

                success: function(response){
                    console.log(response);
                    if(response != 0){
                                
                        var info = JSON.parse(response);
                        console.log(info);
                        $('#detalle_pedido').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                    }else{
                        console.log('No data');
                    }
                    viewButton();
                },
                error: function(error){
                    console.log(error);
                }
            
            });


        }
    </script>
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
                <h3><i class="fas fa-paste"></i> Venta N° <?php echo $_GET['pedidoid']?></h3>
                </div>
                <div class="card">                    
                    <!-- +++++ -->
                    <div class="card-body">
                    <!-- <script>cargarDatos();</script> -->
                        <input type="hidden" name="pedidoid" id="pedidoid" value="<?php echo $_GET['pedidoid']?>">
                        <form>
                            <div class="form-horizontal">
                                <div>
                                    <input type="datetime" name="fecha" id="fecha" disabled>
                                </div>
                                <div class="col-12">
                                    
                                    <div class="fa-pull-right">
                                    Vendedor: <?php echo $usuario;?>
                                </div>
                                </div>
                                
                                <br>
                                <div class="form-group row">
                                <input type="hidden" name="idcliente" id="idcliente">                            
                                    <div class="col-6">
                                        <label >DNI</label>
                                        <input type="text" id="dniCliente" class="form-control" disabled>                 
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
                    <div class="card-header">Detalle de la venta</div>
                    <div class="buscar-producto">
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                        <td><a href="#" id="add_product_venta" class="agregarproductos" style="color:green" title="Agregar a pedido"><i class="fas fa-plus" ></i>Agregar</a></td> 
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
                                    <!-- CONTENIDO AJAX -->
                                </tbody>
                                <tfoot id="detalle_totales">
                                <!-- CONTENIDO AJAX -->
                                </tfoot>
                            </table>
                            <div class="text-center">
                                <a href="#" id="anular_pedido" style="display:none;" class="btn btn-secondary"><i class="fas fa-ban"></i> Anular venta</a>
                                <a href="#" id="confirma_pedido" style="display:none;" class="btn btn-danger"><i class="far fa-edit" ></i> Confirmar venta</a>
                                
                            </div>                        
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
           
            var usuarioid = "<?php echo $_SESSION['id']?>";
            searchForDetalle(usuarioid);
            //rellenar campos de vizualizar pedidos
            cargarCliente();
            cargarDetalle();
            // OCULTAR BOTON AGREGAR
            $('#add_product_venta').hide('fast');

            //ANULAR PEDIDO
            $('#anular_pedido').on('click',function(e){
                e.preventDefault();

                var rows = $('#detalle_pedido tr').length;
                if(rows > 0){
                    var action = 'anularPedido';

                    $.ajax({
                        url: 'autocompletar/pedido-edit.php',
                        type: 'POST',
                        async: true,
                        data: {action:action},

                        success: function(response){
                            console.log(response);
                            if(response != 0){
                                location.reload();
                            }
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                }
            });

            //PROCESAR PEDIDO
            $('#confirma_pedido').on('click',function(e){
                e.preventDefault();

                var rows = $('#detalle_pedido tr').length;
                if(rows > 0){
                    var action = 'procesarPedido';
                    var cliente = $('#idcliente').val();

                    $.ajax({
                        url: 'autocompletar/pedido-edit.php',
                        type: 'POST',
                        async: true,
                        data: {action:action,cliente:cliente},

                        success: function(response){
                            console.log(response);
                            if(response != 0){
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-info'
                                    },
                                    buttonsStyling: false
                                })
                                swalWithBootstrapButtons.fire({
                                    text:response,
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ir al Listado',
                                    cancelButtonText: 'Nuevo Pedido',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    var href = '/autoparts_system/modulos/pedidos/index.php';
                                    window.open(href,"_self");
                                        
                                    } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        location.reload();
                                    }
                                })

                            }else{
                                console.log('No data');
                            }
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                }
            });

            //BUSCAR PRODUCTO
            $('#txt_cod_producto').keyup(function(e){
                    e.preventDefault();
                    var producto = $(this).val();
                    var action = 'infoProducto';
                    
                    console.log(producto, action);
                    if(producto != ''){
                        $.ajax({
                            url: 'autocompletar/buscar_productos.php',
                            type: 'POST',
                            async: true,
                            data: {action:action,producto:producto},

                            success: function(response){
                                console.log(response);

                                if(response != 0){
                                    var info = JSON.parse(response);
                                    console.log(info);

                                    $('#txt_descripcion').html(info[0].descripcion);
                                    $('#txt_detalle').html(info[0].detalle);
                                    $('#txt_existencia').html(info[0].existencia);
                                    $('#text_cant_producto').val('1');
                                    $('#txt_precio').html(info[0].precio);
                                    $('#txt_subtotal').html('$ '+info[0].precio);
                                    // MOSTRAR BOTON AGREGAR
                                    $('#add_product_venta').show('fast');
                                    // ACTIVAR CANTIDAD
                                    $('#text_cant_producto').removeAttr('disabled');

                
                                }else{
                                    console.log('No hay registros');
                                    $('#txt_descripcion').html('-');
                                    $('#txt_detalle').html('-');
                                    $('#txt_existencia').html('-');
                                    $('#text_cant_producto').val('0');
                                    $('#txt_precio').html('$ 0.00');
                                    $('#txt_subtotal').html('$ 0.00');
                                    $('#add_product_venta').hide('fast');
                                    // BLOQUEAR CANTIDAD
                                    $('#text_cant_producto').attr('disabled','disabled');
                                }
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                    
            });

            //VALIDAR CANTIDAD DEL PRODUCTO ANTES DE AGREGAR
            $('#text_cant_producto').keyup(function(e){
                    e.preventDefault();

                    var precio_total = $(this).val() * $('#txt_precio').html();
                    var existencia = parseInt($('#txt_existencia').html());
                    $('#txt_subtotal').html('$ '+precio_total);

                    // OCULTA EL BOTON AGREGAR SI LA CANTIDAD ES MENOR QUE 1
                    if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia)  ){
                        $('#add_product_venta').hide('fast');
                    }else{
                        $('#add_product_venta').show('fast');
                    }
            });

            //AGREGAR PRODUCTO AL DETALLE
            $('#add_product_venta').on('click',function(e){
                e.preventDefault();
                if($('#text_cant_producto').val() > 0){
                    var producto = $('#txt_cod_producto').val();
                    var cantidad = $('#text_cant_producto').val();
                    var action = 'addProductoDetalle';

                    $.ajax({
                        url: 'autocompletar/agregar_detalle.php',
                        type: 'POST',
                        async: true,
                        data: {action:action,producto:producto,cantidad:cantidad},

                        success: function(response){
                            if(response != 0){
                                
                                var info = JSON.parse(response);
                                // console.log(info);
                                $('#detalle_pedido').html(info.detalle);
                                $('#detalle_totales').html(info.totales);

                                $('#txt_cod_producto').val('')
                                $('#txt_descripcion').html('-');
                                $('#txt_detalle').html('-');
                                $('#txt_existencia').html('-');
                                $('#text_cant_producto').val('0');
                                $('#txt_precio').html('$ 0.00');
                                $('#txt_subtotal').html('$ 0.00');
                                $('#add_product_venta').hide('fast');
                                // BLOQUEAR CANTIDAD
                                $('#text_cant_producto').attr('disabled','disabled');

                            }else{
                                console.log('No data');
                            }
                            viewButton();
                        },
                        error: function(error){
                            console.log(error);
                        }
                    
                    });
                }
            });
            
            
        });
        
        
    </script>
</body>
</html>
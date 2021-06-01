$(document).ready(function() {
    console.log('Nuevo JS esta funcionando');
    
    // OCULTAR BOTON AGREGAR
    $('#add_product_venta').hide('fast');

    //ELEGIR CLIENTE O CONSUMIDOR FINAL
    $( function() {
        $("#consumidor").on('click', function() {
            if ($(this).val() === "1") {
                $("#id_input").val('');
                $('#idcliente').val('');
                $("#buscarCliente").val('');
                $("#nombre").val('');
                $("#telefono").val('');
                $("#direccion").val('');
                $("#id_input").prop("disabled", true);
                $("#buscarCliente").prop("disabled", true);
                $("#nombre").prop("disabled", true);
                $("#telefono").prop("disabled", true);
                $("#direccion").prop("disabled", true);
                $("#nuevo_cliente").hide('fast');
                $('.alert').hide("fast");
            }
            if($(this).val()=="2"){
                $("#buscarCliente").prop("disabled", false);
                $("#nombre").prop("disabled", false);
                $("#telefono").prop("disabled", false);
                $("#direccion").prop("disabled", false);
                $("#nuevo_cliente").prop("disabled", false);
                
            }
        });
    });

    //BUSCAR CLIENTE
    $('#buscarCliente').keyup(function(e){
        e.preventDefault();
        var cli = $(this).val();
        var action = 'searchCliente';

        if(cli !== ''){
            $.ajax({
                url: 'cargar_clientes.php',
                type: "POST",
                async: true,
                data: {action:action,cliente:cli},
    
                success: function(response){
                    console.log(response);
                    if(response == 0){
                        $('#idcliente').val('');
                        $('#nombre').val('');
                        $('#telefono').val('');
                        $('#direccion').val('');
                        $('.alert').show("fast");
                        $('#nuevo_cliente').show("fast");
                    }else{
                       
                        $('.alert').hide("fast");
                        const dato = JSON.parse(response);
                        console.log(dato);
                        $('#idcliente').val(dato[0].id);
                        $('#nombre').val(dato[0].cliente);
                        $('#telefono').val(dato[0].contacto);
                        $('#direccion').val(dato[0].domicilio);
    
                        $('#nombre').attr('disabled','disabled');
                        $('#telefono').attr('disabled','disabled');
                        $('#direccion').attr('disabled','disabled');
                        $('#nuevo_cliente').hide("fast");
                        
                        console.log(dato[0].cliente);
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

    //ANULAR PEDIDO
    $('#anular_pedido').on('click',function(e){
        e.preventDefault();

        var rows = $('#detalle_pedido tr').length;
        if(rows > 0){
            var action = 'anularPedido';

            $.ajax({
                url: 'autocompletar/agregar_detalle.php',
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
                url: 'autocompletar/agregar_detalle.php',
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


}); //EndReady

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
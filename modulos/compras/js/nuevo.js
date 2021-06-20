$(document).ready(function() {
    console.log('Nuevo JS esta funcionando');


    // Agregar PROVEEDOR
    $('#agregar').submit(function(e){
        //usa e.preventDefault() evita la accion del submit
        e.preventDefault()
        const dataAgregar = {
            cuit: $('#cuit').val(),
            razonsocial: $('#razonsocial').val(),
            nrohabilitacion: $('#nrohabilitacion').val(),
            website: $('#website').val()           
        }
    console.log(dataAgregar);
    $.ajax({
            url: '/autoparts_system/modulos/proveedores/proveedor-add.php',
            type: 'post',
            data: dataAgregar,
        beforeSend: function (){
            //opcional
        //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
        }

        }).done(function(response){
            console.log(response);
            Swal.fire(response);            
            
        // Se resetea el formulario luego de haber enviado los datos
        $('#agregar').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
        //en caso de que haya un error muestras un mensaje con el error
        console.log(thrownError);
        });
        //Con esta linea se esconde el modal de agregar
        $('#nuevoProveedor').modal('hide');
        
    });

     // AGREGAR PRODUCTOS
    $(".producto-add").on('click', function(){
        //SELECT MODELOS
        $("#vehiculo").change(function(){
            let action = 'modelos';
            let vehiculoid= $("#vehiculo").val();
            console.log(vehiculoid);
            $.ajax({
               data:  {vehiculoid:vehiculoid,action:action},
               url:   '/autoparts_system/modulos/compras/autocompletar/ajax.php',
               type:  'POST',
               success:  function (response) {  
                   console.log(response);
                   let datos = JSON.parse(response) ;
                   console.log(datos)
                   for(let i = 0; i < datos.length; i++){
                        $("#modelos").append(`<option value="${datos[i].id}">${datos[i].nombre}</option>`)
                   }
               },
               error:function(){
                   alert("error")
               }
           });
        });
        //SELECT MODELOS-AÑO
        $("#modelos").change(function(){
            let action = 'modelos_anio';
            let id=$("#modelos").val();
            console.log(id);
            $.ajax({
               data:  {id:id,action:action},
               url:   '/autoparts_system/modulos/compras/autocompletar/ajax.php',
               type:  'POST',
               success:  function(response) {   
                console.log(response);             	
                let datos = JSON.parse(response);
                console.log(datos);
                for(let i = 0; i < datos.length; i++){
                 $("#anio").append(`<option value="${datos[i].id}">${datos[i].nombre}</option>`)
                }
               },
               error:function(){
                   alert("error");
               }
           });
        });
        //SELECT PRODUCTOS_CATEGORIAS
        $("#anio").change(function(){
            let action = 'categorias';
            let id=$("#anio").val();
            console.log(id);
            $.ajax({
               data:  {id:id,action:action},
               url:   '/autoparts_system/modulos/compras/autocompletar/ajax.php',
               type:  'POST',
               success:  function(response) {   
                console.log(response);             	
                let datos = JSON.parse(response);
                console.log(datos);
                for(let i = 0; i < datos.length; i++){
                 $("#categoria").append(`<option value="${datos[i].id}">${datos[i].nombre}</option>`)
                }
               },
               error:function(){
                   alert("error");
               }
           });
        });

        $('#agregar').submit(function(e){  
            //se utiliza para detener una accion por omision
            //Llamar a preventDefault en cualquier momento durante la ejecución, cancela el evento, lo que significa que cualquier acción por defecto que deba producirse como resultado de este evento, no ocurrirá.
            e.preventDefault();          
            const dataAgregar = {
                categoriaxmodelo:$('#categorias').val(),
                descripcion: $('#descripcion').val(),
                fabricante: $('#fabricante').val(),
                cantidad: $('#cantidad').val(),
                precioventa: $('#precioventa').val(),
                detalles: $('#detalles').val()
            }
            console.log(dataAgregar);
            $.ajax({
                url: '/autoparts_system/modulos/productos/productos/producto_add.php',
                type: 'POST',
                data: dataAgregar,
                beforeSend: function (){
                    //opcional
                //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
                }
            }).done(function(response){
                console.log(response);
                Swal.fire(response);
                location.reload();
                           
    
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                console.log(thrownError);
            });
            $('#agregar').trigger('reset');
            $('#nuevoProducto').modal('hide');    
            
        });

    });

     //BUSCAR PRODUCTO
    $('#txt_cod_producto').keyup(function(e){
        e.preventDefault();
        var producto = $(this).val();
        var action = 'infoProducto';
        
        console.log(producto, action);
        if(producto != ''){
            $.ajax({
                url: '/autoparts_system/modulos/compras/autocompletar/buscar_productos.php',
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

            var precio_total = $(this).val() * $('#txt_precio').val();
           
            $('#txt_subtotal').html('$ '+precio_total);

            // OCULTA EL BOTON AGREGAR SI LA CANTIDAD ES MENOR QUE 1
            if( ($(this).val() < 1 || isNaN($(this).val()))){
                $('#add_product_compra').hide('fast');
            }else{
                // MOSTRAR BOTON AGREGAR
                $('#add_product_compra').show('fast');
                // ACTIVAR CANTIDAD
                $('#txt_precio').removeAttr('disabled');
            }
    });

     //CALCULAR SUBTOTAL
    $('#txt_precio').keyup(function(e){
        e.preventDefault();

        var precio_total = $(this).val() * $('#text_cant_producto').val();
       
        $('#txt_subtotal').html('$ '+precio_total);
    });

    //AGREGAR PRODUCTO AL DETALLE
    $('#add_product_compra').on('click',function(e){
        e.preventDefault();
        if($('#text_cant_producto').val() > 0){
            var producto = $('#txt_cod_producto').val();
            var cantidad = $('#text_cant_producto').val();
            var precio = $('#txt_precio').val();
            var action = 'addProductoDetalle';

            $.ajax({
                url: '/autoparts_system/modulos/compras/autocompletar/agregar_detalle.php',
                type: 'POST',
                async: true,
                data: {action:action,producto:producto,cantidad:cantidad,precio:precio},

                success: function(response){
                    if(response != 0){
                        console.log(response);
                        var info = JSON.parse(response);
                        console.log(info);
                        $('#detalle_compra').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('')
                        $('#txt_descripcion').html('-');
                        $('#txt_detalle').html('-');
                        
                        $('#text_cant_producto').val('0');
                        $('#txt_precio').val('$ 0.00');
                        $('#txt_subtotal').html('$ 0.00');
                        $('#add_product_compra').hide('fast');
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

    // //ANULAR PEDIDO
    // $('#anular_pedido').on('click',function(e){
    //     e.preventDefault();

    //     var rows = $('#detalle_pedido tr').length;
    //     if(rows > 0){
    //         var action = 'anularPedido';

    //         $.ajax({
    //             url: 'autocompletar/agregar_detalle.php',
    //             type: 'POST',
    //             async: true,
    //             data: {action:action},

    //             success: function(response){
    //                 console.log(response);
    //                 if(response != 0){
    //                     location.reload();
    //                 }
    //             },
    //             error: function(error){
    //                 console.log(error);
    //             }
    //         });
    //     }
    // });

    //PROCESAR COMPRA
    $('#confirma_pedido').on('click',function(e){
        e.preventDefault();
        if ($('#doc').val() == '' && $('#proveedor').val() == '') {
            // SE COMPRUEBA QUE LOS SELECT DE DOCUMENTACION Y PROVEEDOR NO INGRESEN VACIOS
            swal.fire('Debe seleccionar el tipo de documentación y/o proveedor de la compra.');
        } else {

            var rows = $('#detalle_compra tr').length;
            if(rows > 0){
                var action = 'procesarPedido';
                var proveedor = $('#proveedor').val();
                var tipo_doc = $('#doc').val();
                var tipo_pago = $('#pago').val();

                $.ajax({
                    url: '/autoparts_system/modulos/compras/autocompletar/agregar_detalle.php',
                    type: 'POST',
                    async: true,
                    data: {action:action,proveedor:proveedor,tipo_doc:tipo_doc,tipo_pago:tipo_pago},

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
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Ir al Listado',
                                cancelButtonText: 'Nuevo Pedido',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                var href = '/autoparts_system/modulos/compras/index.php';
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
            
        }
    });


});//end ready
//MOSTRAR/OCULTAR BOTON CONFIRMAR PEDIDO
function viewButton(){
    if($('#detalle_compra tr').length > 0){
        // $('#confirma_pedido').show();
        $('#continuar').show();
        $('#anular_pedido').show();
    }else{
        // $('#confirma_pedido').hide();
        $('#continuar').hide();
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
                $('#detalle_compra').html(info.detalle);
                $('#detalle_totales').html(info.totales);

                $('#txt_cod_producto').val('')
                $('#txt_descripcion').html('-');
                $('#txt_detalle').html('-');
                $('#txt_existencia').html('-');
                $('#text_cant_producto').val('0');
                $('#txt_precio').html('$ 0.00');
                $('#txt_subtotal').html('$ 0.00');
                $('#add_product_compra').hide('fast');
                // BLOQUEAR CANTIDAD
                $('#text_cant_producto').attr('disabled','disabled');

            }else{
                $('#detalle_compra').html('');
                $('#detalle_totales').html('');
            }
            viewButton();

            
        },
        error: function(error){
            console.log(error);
        }
     
    });


}
// BUSCAR SI EXISTE UN DETALLE DE COMPRAS QUE SE ESTA REALIZANDO POR EL USUARIOO ACTIVO
function searchForDetalle(id){
    var action = 'searchForDetalle';
    var user = id;

    $.ajax({
        url: '/autoparts_system/modulos/compras/autocompletar/agregar_detalle.php',
        type: 'POST',
        async: true,
        data: {action:action,user:user},

        success: function(response){
            console.log(response);
            if(response != 0){
                        
                var info = JSON.parse(response);
                console.log(info);
                $('#detalle_compra').html(info.detalle);
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



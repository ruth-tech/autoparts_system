$(document).ready(function(){
    console.log('Jquery en pedidos todos JS');
    listartodos();


    // COMPROBAR CAJA ABIERTA  
    $(document).on('click', '.nuevo-pedido', function () {
        var action = 'comprobar_caja';
        $.ajax({
            url: 'autocompletar/agregar_detalle.php',
            type: 'POST',
            async: true,
            data: {action:action},

            success: function(response){
                console.log(response);
                if(response > 0){
                    swal.fire('Debe abrir una caja para agregar una venta!');
                    
                }else{  
                    var  href="/autoparts_system/modulos/pedidos/nuevo.php";
                    window.open(href,"_SELF");                  
                   
                }
            },
            error: function(error){
                console.log(error);
            }
        });
        // var href = '/autoparts_system/modulos/pedidos/editarPedido.php'; 
        // let element = $(this)[0];                                                                 
        // let pedido = $(element).attr('pedidoid');
        // // Save information

        // // Check if any ID is aviable 
        // if (pedido) {
        //     // Save the url and perform a page load
        //     var direccion = href + '?pedidoid=' + pedido; 
        //     // + '&clienteId='+ clienteId;
        //     window.open(direccion);
        //     //,"ventana1","height=900,width=800,left=300,location=yes,menubar=no,resizable=no,scrollbars=yes,status=no,titlebar=yes,top=500" 
            
        // } else {
        //     // Error handling
        //     Swal.fire({
        //         position: 'center',
        //         icon: 'error',
        //         title: '¡Ha ocurrido un error al intentar extraer los datos del pedido seleccionado!',
        //         showConfirmButton: true,
        //         confirmButtonColor:"#d63030",
        //       })
        // }
    }); 

    //Eliminar
    $(document).on('click', '.deletePedido', function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        
        swalWithBootstrapButtons.fire({
            text:'¿Estas seguro que desea dar de baja a este Pedido?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let element = $(this)[0];
                let id = $(element).attr('pedidoid');
                $.post('pedido-delete.php', {id}, function(response){
                    console.log(response);
                    
                    swalWithBootstrapButtons.fire(
                    response
                    )
                    resetearDatatables();
                })
            } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
            ) {
            swalWithBootstrapButtons.fire(
                'Se cancelo exitosamente.'
            )
            }
        })
            
    });

     //FACTURAR PEDIDO
     $(document).on('click','.ver_pedido',function(e){
        e.preventDefault();

        let element = $(this)[0];                                                                 
        let pedido = $(element).attr('pedidoid');
        var action = 'facturarPedido';

        $.ajax({
            url: 'autocompletar/agregar_detalle.php',
            type: 'POST',
            async: true,
            data: {action:action,pedido:pedido},

            success: function(response){
                console.log(response);
                if(response != 0){
                    var info = JSON.parse(response);
                    // console.log(info);
                    generarPDF(info.rela_cliente,info.pedido_id);
                    // location.reload();
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

});

function generarPDF(cliente,factura){
    var ancho = 1000;
    var alto = 800;

    //CALCULAR POSICION X,Y PARA CENTRAR LA VENTANA
    var x = parseInt((window.screen.width/2) * (ancho/2));
    var y = parseInt((window.screen.width/2) * (alto/2));

    $url = '../../factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+", height="+alto+", width="+ancho+", scrollbar=si,location=no")
}

function buttons(){
    if($('#').length > 0){
        $('#confirma_pedido').show();
        $('#anular_pedido').show();
    }else{
        $('#confirma_pedido').hide();
        $('#anular_pedido').hide();
    }
};

var resetearDatatables = function(){
    $('#lista-pedidos-datatables').dataTable().fnDestroy(); 
    listartodos();
};

var listartodos = function(){
    var table = $('#lista-pedidos-datatables').dataTable({
        "ajax":{
            "method":"POST",
            "url":"todos/lista.php"
        },
        "columns":[
            {"data":"pedido_id"},
            {"data":"pedido_fecha"},
            {"data":"tipo"},
            {"data":"no_factura"},
            {"data":"nombreCliente"},
            {"data":"nombreEmpleado"},
            {"data":"total"},
            {"data":"pedido_estado_descripcion",
                render: function(data, type, row){
                    sev='';
                    switch (data){
                    case 'PENDIENTE':
                        sev = '<span class="badge badge-warning">'+data+'</span>';
                        break;
                    case 'ANULADO':
                        sev = '<span class="badge badge-danger">'+data+'</span>';
                        break;
                    case 'FACTURADO':
                        sev = '<span class="badge badge-success">'+data+'</span>';
                        break;
                    
                    }
                    // console.log('Content of sev is : '+sev);
                    return sev;
                }
            },
            {"data":"pedido_id",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol){
                    $(nTd).html("<button class='ver_pedido btn btn-info' title='Visualizar factura' pedidoid="+oData.pedido_id+"><i class='fas fa-eye' pedidoid="+oData.pedido_id+"></i></button>  <button class='deletePedido btn btn-danger' title='Anular factura'  pedidoid="+oData.pedido_id+"><i class='fas fa-times-circle' pedidoid="+oData.pedido_id+"></i></button>")
                    
                    
                }
            }
        ],
        "language":idioma_espaniol
    });
}

// var listarpendientes = function(){
//     var tableP = $('#lista-pedidos-pendientes').dataTable({
//         "ajax":{
//             "method":"POST",
//             "url":"pendientes/listaPendientes.php",
//             "dataSrc":'datos'
//         },
//         "columns":[
//             {"datos":"pedido_id"},
//             {"datos":"pedido_fecha"},
//             {"datos":"nombreCliente"},
//             {"datos":"nombreEmpleado"},
//             {"datos":"pedido_total"},
//             {"datos":"pedido_estado_descripcion",
//                 render: function(data, type, row){
//                     console.log('El contenido de datos es : '+data);
//                     sev='';
//                     switch (data){
//                     case 'PENDIENTE':
//                         sev = '<span class="badge badge-warning badge-pill">'+data+'</span>';
//                         break;
                    
//                     }
//                     // console.log('Content of sev is : '+sev);
//                     return sev;
//                 }
//             },
//             {"datos":"pedido_id",
//                 "fnCreatedCell": function(nTd, sData, oData, iRow, iCol){
//                     $(nTd).html("<a href='autoparts_system/modulos/pedidos/individuales/index.php?pedidoid="+oData.pedido_id+"'>Ver</a>")
//                 }
//             },
//             {"defaultContent":"<button class='btn btn-warning'><i class='far fa-edit'></i></button> <button class='btn btn-danger'><i class='far fa-trash-alt'></i></button>"}
//         ],
//         "language":idioma_espaniol
//     });
// }

var idioma_espaniol = {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        } 


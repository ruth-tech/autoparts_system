$(document).ready(function(){
    console.log('Jquery en pedidos todos JS');
    listartodos();

    $(function () {
        $('[data-toggle="popover"]').popover({html:true})
      })

    // listarpendientes(); 

})

var listartodos = function(){
    var table = $('#lista-pedidos-datatables').dataTable({
        "ajax":{
            "method":"POST",
            "url":"todos/lista.php"
        },
        "columns":[
            {"data":"pedido_id"},
            {"data":"pedido_fecha"},
            {"data":"nombreCliente"},
            {"data":"nombreEmpleado"},
            {"data":"pedido_total"},
            {"data":"pedido_estado_descripcion",
                render: function(data, type, row){
                    sev='';
                    switch (data){
                    case 'PENDIENTE':
                        sev = '<span class="badge badge-warning badge-pill">'+data+'</span>';
                        break;
                    case 'ANULADO':
                        sev = '<span class="badge badge-danger badge-pill">'+data+'</span>';
                        break;
                    case 'FINALIZADO':
                        sev = '<span class="badge badge-success badge-pill">'+data+'</span>';
                        break;
                    case 'EN COLA':
                        sev = '<span class="badge badge-primary badge-pill">'+data+'</span>';
                        break;
                    }
                    // console.log('Content of sev is : '+sev);
                    return sev;
                }
            },
            {"data":"pedido_id",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol){
                    $(nTd).html("<a href='autoparts_system/modulos/pedidos/individuales/index.php?pedidoid="+oData.pedido_id+"'>Ver</a>")
                }
            },
            {"defaultContent":"<button class='btn btn-warning'><i class='far fa-edit'></i></button> <button class='btn btn-danger'><i class='far fa-trash-alt'></i></button>"}
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


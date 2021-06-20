$(document).ready(function(){
    console.log('Jquery en pedidos todos JS');
    listarcompras();

});

var resetearDatatables = function(){
    $('#lista-compras').dataTable().fnDestroy(); 
    listarcompras();
};

var listarcompras = function(){
    var table = $('#lista-compras').dataTable({
        "ajax":{
            "method":"POST",
            "url":"lista.php"
        },
        "columns":[
            {"data":"id"},
            {"data":"fecha"},
            {"data":"documento"},
            {"data":"proveedor"},
            {"data":"empleado"},
            {"data":"total"},
            {"data":"id",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol){
                    $(nTd).html("<button class='ver_pedido btn btn-info' title='Visualizar compra' compra="+oData.id+"><i class='fas fa-eye' compra="+oData.id+"></i></button>")
                    
                    
                }
            }
        ],
        "language":idioma_espaniol
    });
}

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

$(document).ready(function(){
    
    console.log('Funciona jquery de categorias');
    listarCategorias();
   
    

});//fin js

var listarCategorias = function(){
    let modelo = $('#modelo').attr('modeloid');
    var table = $('#listado-categoriasProductos').dataTable({        
        "ajax":{            
            "method":"POST",
            "url":"/autoparts_system/modulos/productos/ajax_categorias.php",
            "data":{modelo}
        },
        "columns":[
            {"data":"id"},
            {"data":"categoria"},
            {"data":"detalle"},
            {"data":"id",
                "fnCreatedCell":function(nTd,sData,oData,iRow,iCol){
                    $(nTd).html("<a class='btn btn-danger' href='/autoparts_system/modulos/productos/productos/index.php?categoriaxmodelo="+oData.id+"'>Ver productos</a>")
                }
            }
        ],
        "language": idioma_espaniol  
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
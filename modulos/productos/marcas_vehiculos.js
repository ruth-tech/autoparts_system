$(document).ready(function(){
    
    console.log('Funciona jquery marcas de vehiculos');
    listarVehiculos();
   
    

});//fin js

var listarVehiculos = function(){
    var table = $('#listado-vehiculos').dataTable({
        
        "ajax":{            
            "method":"POST",
            "url":"/autoparts_system/modulos/productos/ajax_vehiculos.php",
        },
        "columns":[
            {"data":"id"},
            {"data":"descripcion"},
            {"data":"img", 
                "render":function(data,type,row){
                    var data_n = data.split("/");
                    return '<img src="'+data_n[1]+"/"+data_n[2]+"/"+data_n[3]+"/"+data_n[4]+"/"+data_n[5]+'" width="75" height="75" />'
                }
            },
            {"data":"id",
                "fnCreatedCell":function(nTd,sData,oData,iRow,iCol){
                    $(nTd).html("<a class='btn btn-danger' href='/autoparts_system/modulos/productos/modelos_vehiculos.php?marcaid="+oData.id+"'>Ver modelos</a>")
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
$(document).ready(function(){
    let modelo = $('#modelo').attr('modeloid');
    console.log('Funciona jquery de categorias');
    listarCategorias();

    //ASIGNAR
    $('#asignarCategoria').submit(function(e){
        e.preventDefault();
        // Obtener checkboxes por nombre y solo los que están marcados
        var checkbox = $('[name^="check_lista"]:checked').map(function() {
            return $(this).val();
        }).get();
        console.log(checkbox);
        const dataAsignar = {
            modelo,
            checkbox
        }
        console.log(dataAsignar);
        $.ajax({
            url: '/autoparts_system/modulos/productos/categorias_abm/categorias_asigned.php',
            type: 'POST',
            data: dataAsignar,
            beforeSend: function(){
                //opcional
            }
        }).done(function(response){
            console.log(response);
            swal.fire(response)
            resetearDatatables();
            $('#asignarCategorias').trigger('reset');
            $('#asignarCategoria').modal('hide');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
            console.log(thrownError);
        })
        
          
    });
    // $('#asignarCategoria').submit(function(e){
    //     e.preventDefault();
       
        // const dataAgregar = {
        //     modelo,
        //     checklista: new FormData($("#asignarCategorias")[0])
        // }
        // console.log(dataAgregar);
        // $.ajax({
        //     url: '/autoparts_system/modulos/productos/categorias_abm/categorias_asigned.php',
        //     type: 'POST',
        //     data: dataAgregar,
        //     beforeSend: function (){
        //         //opcional
        //     //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
        //     }
        // }).done(function(response){
        //     console.log(response);
        //     // Swal.fire(response);
        //     // listarCategorias();
            

        // }).fail(function(jqXHR, ajaxOptions, thrownError){
        //     console.log(thrownError);
        // });
        // $('#asignarCategorias').trigger('reset');
        // $('#agregarCategoria').modal('hide');   

    // });

   
    

});//fin js

var resetearDatatables = function(){
    $('#listado-categoriasProductos').dataTable().fnDestroy(); 
    listarCategorias();
};

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
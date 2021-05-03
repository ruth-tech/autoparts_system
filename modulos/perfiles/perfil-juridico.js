
$(document).ready(function(){
    console.log('Jquery is working in perfiles juridicos');
    let personaid = $("#persoid").attr('personaid');
    console.log(personaid);
    listarDatosJuridicos();
    // listadatosjur();
    

    // function listadatosjur(){
    //     $.ajax({
    //         url:"lista-juridica.php",
    //         type:"GET",
    //         //datatype:"json",//SI DEFINO EL DATATYPE COMO JSON NO HACE FALTA PARSEARLO, PORQUE AJAX YA LO TOMA COMO JSON A LA RESPUESTA
    //         data:{personaid:personaid},
    //         success: function(response){
    //             console.log(response)
    //             let lista = JSON.parse(response);                
    //             console.log(lista);

    //             let template = '';

    //                 lista.forEach(lista =>{
    //                     template +=
    //                     `<tr>
    //                         <td>${lista.personaid}</td>
    //                         <td>${lista.cuit}</td>
    //                         <td>${lista.razonsocial}</td>
    //                         <td>${lista.nrohabilitacion}</td>
    //                         <td><span data-placement="top" title="Editar datos" data-toggle="tooltip" ><button type="button" class="editar-juridico btn btn-warning" data-toggle="modal" data-target="#editardatosperjuridicas" personaid="${lista.personaid}"><i class="far fa-edit"></i></button></td> 
                                             
    //                     </tr>`
    //                 });
    //                 $("#listadodatosper").html(template);
                
                    
    //         },
    //         error: function(xhr,ajaxOptions,thrownError){
    //             console.log(thrownError);
    //         }
    //     });
    // }

    //Editar
    $(document).on('click', '.editar-juridico', function(){
        let element2 = $(this)[0];
        let personaid = $(element2).attr('personaid');

        $.post('datosjuridicos-edit.php', {personaid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#personaidedit').val(datos.personaid);
            $('#cuitedit').val(datos.cuit);            
            $('#razonsocialedit').val(datos.razonsocial);
            $('#habilitacionedit').val(datos.habilitacion);
        });

        $('#editardatosjuridicos').submit(function(e){
            e.preventDefault();
            const postData = {
                personaid: $('#personaidedit').val(),
                cuit: $('#cuitedit').val(),                
                razonsocial: $('#razonsocialedit').val(),
                habilitacion: $('#habilitacionedit').val()
    
            };
    
            $.ajax({
                url: 'datosjuridicos-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    listadatosper();
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#editardatosperjuridicas').modal('hide');           
        });


    

        
    });
});//fin js

var listarDatosJuridicos = function(){
    var table = $('#listado-personajuridica').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/perfiles/lista-juridica.php"
        },
        "columns":[
            {"data":"cuit"},
            {"data":"razonsocial"},
            {"data":"habilitacion"},
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='editar-juridico btn btn-warning' data-toggle='modal' data-target='#editardatosperjuridicas' personaId="+oData.id+"><i class='far fa-edit'></i></button>")
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

  

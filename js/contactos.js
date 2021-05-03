

$(document).ready(function(){
    console.log('Jquery is working in contactos');
    let personaid = $("#persoid").attr('personaid');
    console.log(personaid)
    listarContactos();
    // listacontacto();
   
    

    // function listacontactos(){
    //     $.ajax({
    //         url:"/autoparts_system/modulos/contactos/lista.php",
    //         type:"GET",
    //         //datatype:"json",//SI DEFINO EL DATATYPE COMO JSON NO HACE FALTA PARSEARLO, PORQUE AJAX YA LO TOMA COMO JSON A LA RESPUESTA
    //         data:{personaid:personaid},
    //         success: function(response){ 
    //             console.log(response)
    //             let lista = JSON.parse(response);                 
    //             console.log(lista);

    //             let template = '';

    //             if(lista.length !== 0){

    //                 lista.forEach(lista =>{
    //                     template +=
    //                     `<tr contactoid="${lista.contactoid}">
    //                         <td>${lista.tipo_contacto_descripcion}</td>
    //                         <td>${lista.valor_contacto}</td>
    //                         <td><span data-placement="top" title="Editar datos" data-toggle="tooltip"><button type="button" class="editar-contacto btn btn-warning"  data-toggle="modal" data-target="#editarcontacto" personaid="${lista.personaid}"><i class="far fa-edit"></i></button> 
    //                         <button class="deletecontacto btn btn-danger" data-placement="top" title="Eliminar datos" data-toggle="tooltip"><i class="far fa-trash-alt"></i></button></td>               
    //                     </tr>`
    //                 });
    //                 $("#listadoContacto").html(template);
    //             }else{ 
    //                 $("#listado-contactos").hide();
    //                 template = '¡No se han encontrado registros de contactos activos de la persona en la base de datos, agregue al menos uno!';
    //                 $(".card-body-contactos").html(template);
    //             }
    //         },
    //         error: function(xhr,ajaxOptions,thrownError){
    //             console.log(thrownError);
    //         }
    //     });
    // }

    // MDOAL AGREGAR
    $('#contacto-add').submit(function(e){
        
        console.log('submit')
        // Se crea una constante que almacena los datos que llegan desde el formulario
        const postData = { 
            personaid:$('input#id').val(),
            tipocontacto: $('#tipocontacto').val(),
            valor: $('#valorcontacto').val()            
        };
        console.log(postData)

        // Se envia los datos a traves del metodo POST

        $.post('/autoparts_system/modulos/contactos/contacto-add.php', postData, function(response){
            console.log(response);
            Swal.fire(response);
            // if(response=='Exito'){
            //     Swal.fire('Exito al agregar');
               
            // }else{
            //     Swal.fire({
            //         position: 'center',
            //         icon: 'error',
            //         title: '¡Ha ocurrido un error al intentar agregar un contacto!',
            //         showConfirmButton: true,
            //         confirmButtonColor:"#d63030",
            //       })
                
            // }
            listacontactos();

            // Se resetea el formulario luego de haber enviado los datos

            $('#contacto-add').trigger('reset');
            
        });

        //Con esta linea se esconde el modal de agregar
        $('#agregarcontacto').modal('hide');
        


        //se utiliza para detener una accion por omision
        //Llamar a preventDefault en cualquier momento durante la ejecución, cancela el evento, lo que significa que cualquier acción por defecto que deba producirse como resultado de este evento, no ocurrirá.
        e.preventDefault();
    });

     //Eliminar
    $(document).on('click', '.deletecontacto', function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            text:'¿Estas seguro que desea dar de baja a este contacto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                let element = $(this)[0].parentElement.parentElement.parentElement;
                let contactoid = $(element).attr('contactoid');
                console.log(contactoid)
                $.post('/autoparts_system/modulos/contactos/contacto-delete.php', {contactoid}, function(response){
                    console.log(response);
                    listacontactos();
                    swalWithBootstrapButtons.fire(
                       response
                    )
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

    //Editar
    $(document).on('click', '.editar-contacto', function(){
        let element = $(this)[0].parentElement.parentElement.parentElement;
        let contactoid = $(element).attr('contactoid');
        console.log(contactoid)

        $.post('/autoparts_system/modulos/contactos/contacto-edit.php', {contactoid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#contactoidedit').val(datos.contactoid),
            $('#tipocontactoidedit').append(`<option value='` +datos.tipocontactoid+ `'>` +datos.tipocontactodescripcion+ `</option>`),
            $('#valoredit').val(datos.valorcontacto)
        });

        $('#modificarcontacto').submit(function(e){
            e.preventDefault();
            const postData = {
                contactoid: $('#contactoidedit').val(),                
                tipocontactoid: $('#tipocontactoidedit').val(),                
                valor: $('#valoredit').val()
    
            };
    
            $.ajax({
                url: '/autoparts_system/modulos/contactos/contacto-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    listacontactos();
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#editarcontacto').modal('hide');
            
        });   

        
    });

    
    
   
})//fin js

var listarContactos = function(){
    var table = $('#listado-contactos').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/contactos/listar.php"
        },
        "columns":[
            {"data":"contactoid"},
            {"data":"descricion"},
            {"data":"valor"},
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='contacto-edit btn btn-warning' data-toggle='modal' data-target='#editarContacto' personaId="+oData.id+"><i class='far fa-edit'></i></button><button class='deleteContacto btn btn-danger' personaId="+oData.id+"><i class='far fa-trash-alt'></i></button>")
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




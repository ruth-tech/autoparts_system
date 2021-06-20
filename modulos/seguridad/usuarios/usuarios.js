//Comprobar el funcionamiento de jquery
$(document).ready(function(){

    console.log('Jquery is working in Usuarios.js');
    listarUsuarios();
    
    // ACCESO AL PERFIL                                                                     
    // $(document).on('click', '.perfil', function () {
    //     var hrefperfilpersonal = '/autoparts_system/modulos/perfiles/index.php'; 
    //     let element = $(this)[0];                                                                 
    //     let personaId = $(element).attr('personaid');
    //     // let element1 = $(this)[0].parentElement.parentElement;
    //     // let clienteId = $(element1).attr('clienteId');

    //     // Save information

    //     // Check if any ID is aviable 
    //     if (personaId) {
    //         // Save the url and perform a page load
    //         var direccion = hrefperfilpersonal + '?personaId=' + personaId; 
    //         // + '&clienteId='+ clienteId;
    //         window.open(direccion);
            

    //     } else {
    //         // Error handling
    //         Swal.fire({
    //             position: 'center',
    //             icon: 'error',
    //             title: '¡Ha ocurrido un error al intentar ingresar al perfil de la persona seleccionada!',
    //             showConfirmButton: true,
    //             confirmButtonColor:"#d63030",
    //           })
    //     }
       


    // });                                          


    // Agregar

    $('#agregar').submit(function(e){
        //usa e.preventDefault() evita la accion del submit
        e.preventDefault()
        const dataAgregar = {
            persona: $('#empleado').val(),
            usuario: $('#usuario').val(),
            pass: $('#pass').val(),
            perfil: $('#perfil').val()
            
        }
      console.log(dataAgregar);
      $.ajax({
              url: '/autoparts_system/modulos/seguridad/usuarios/asignar.php',
              type: 'POST',
            data: dataAgregar,
          beforeSend: function (){
              //opcional
          //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
          }
  
        }).done(function(response){
              console.log(response);
              Swal.fire(response);
    
            resetearDatatables();
          // Se resetea el formulario luego de haber enviado los datos
          $('#agregar').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
          //en caso de que haya un error muestras un mensaje con el error
          console.log(thrownError);
        });
        //Con esta linea se esconde el modal de agregar
        $('#nuevoUsuario').modal('hide');
        
    });

    

//     //Eliminar
    $(document).on('click', '.deleteUsuario', function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });        
        swalWithBootstrapButtons.fire({
            text:'¿Estas seguro que desea dar de baja a este Usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let element = $(this)[0];
                let id = $(element).attr('usuarioId');
                $.post('/autoparts_system/modulos/seguridad/usuarios/baja_usuario.php', {id:id}, function(response){
                    console.log(response);
                    swalWithBootstrapButtons.fire(response)
                    resetearDatatables();
                    
                });
               
            } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
            ) {
            swalWithBootstrapButtons.fire(
                'Se cancelo exitosamente.'
            )
            }
        });
    });

//     //Editar usuario y clave
    $(document).on('click', '.password-edit', function(){
        let element = $(this)[0];
        let usuarioid = $(element).attr('usuarioid');
        // var action ='usuario-edit';

        $.ajax({
            url:'/autoparts_system/modulos/seguridad/usuarios/usuario-edit.php',
            type: 'POST',
            data: {usuarioid:usuarioid},
            success: function(response){
                console.log(response);                
                const datos = JSON.parse(response);
                console.log(datos);
                $('#usuario-edit').val(datos.user);
                $('#pass-edit').val(datos.pass);
            },
            error: function(error){
                console.log(error);
            }
        });
        $('#editar').submit(function(e){

            const postData = {
                usuarioid,
                user: $('#usuario-edit').val(),
                pass: $('#pass-edit').val()               
    
            };
    
            $.ajax({
                url: '/autoparts_system/modulos/seguridad/usuarios/usuario-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    resetearDatatables();
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#editarPass').modal('hide');

            e.preventDefault();
        });
        
    });

});
var resetearDatatables = function(){
    $('#listadoUsuarios').dataTable().fnDestroy(); 
    listarUsuarios();
};

var listarUsuarios = function(){
    var table = $('#listadoUsuarios').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/seguridad/usuarios/listar.php"
        },
        "columns":[
            {"data":"id"},
            {"data":"perfil"},
            {"data":"empleado"},
            {"data":"usuario"},
            {"data":"alta"},
            {"data":"id",
                "fnCreatedCell":function(nTd,sData,oData,iRow,iCol){
                    $(nTd).html("<a class='btn btn-outline-danger' href='/autoparts_system/modulos/seguridad/usuarios/historial_user.php?usuarioId="+oData.id+"'>Ver</a>")
                }
            },
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='password-edit btn btn-info' title='Cambiar contraseña' data-toggle='modal' data-target='#editarPass' usuarioId="+oData.id+"><i class='fas fa-key'></i></button><button class='deleteUsuario btn btn-danger' title='Eliminar usuario' usuarioId="+oData.id+"><i class='far fa-trash-alt'></i></button>")
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
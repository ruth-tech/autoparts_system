//Prueba de JS
console.log('Jquery funciona en EMpleados.js'); 

$(document).ready(function(){
    listarEmpleados();
    
    // ACCESO AL PERFIL
    $(document).on('click', '.perfil', function () {
        var href = '/autoparts_system/modulos/perfiles/index.php';
        let element = $(this)[0];                                                                 
        let personaId = $(element).attr('personaid');

        // Check if any ID is aviable 
        if (personaId) {
            // Save the url and perform a page load
            var direccion = href + '?personaId=' + personaId; 
            // + '&clienteId='+ clienteId;
            window.open(direccion,'_self');
            

        } else {
            // Error handling
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: '¡Ha ocurrido un error al intentar ingresar al perfil de la persona seleccionada!',
                showConfirmButton: true,
                confirmButtonColor:"#d63030",
              })
        }
       


    }); 

    // Agregar

    $('#agregar').submit(function(e){
        //usa e.preventDefault() evita la accion del submit
        e.preventDefault()
        const dataAgregar = {
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            dni: $('#dni').val(),
            cuil: $('#cuil').val(),
            sexo: $('#sexo').val(),
            fchNac: $('#fchNac').val(),
            nacionalidad: $('#nacionalidad').val(),
            cargo: $('#cargo').val(),
            nombreuser: $('#nombreuser').val(),
            passworduser: $('#passworduser').val()
        }
      console.log(dataAgregar);
      $.ajax({
              url: '/autoparts_system/modulos/empleados/empleado-add.php',
              type: 'post',
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
        $('#nuevoEmpleado').modal('hide');
        
    });
//Eliminar
$(document).on('click', '.deleteEmpleado', function(){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        text:'¿Estas seguro que desea dar de baja a este Empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            let element = $(this)[0];
            let id = $(element).attr('empleadoId');
            $.post('empleado-delete.php', {id}, function(response){
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

    //Editar
    $(document).on('click', '.empleado-edit', function(){
        let element = $(this)[0];
            let id = $(element).attr('empleadoId');
console.log(id);
        $.post('/autoparts_system/modulos/empleados/empleado-edit.php', {id}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#empleadoidedit').val(datos.empleadoid);
            $('#personaidedit').val(datos.personaid);
            $('#fechaaltaedit').val(datos.fechaalta);            
            $('#cargoedit').append('<option value="'+ datos.perfilid +'">'+ datos.perfildescripcion +'</option>');
           
        });

        $('#editar-empleado').submit(function(e){
            e.preventDefault();
            const postData = {
                personaid:$('#personaidedit').val(),
                empleadoid: $('#empleadoidedit').val(),
                fechaalta: $('#fechaaltaedit').val(),                
                perfilid: $('#cargoedit').val()    
            };
    
            $.ajax({
                url: '/autoparts_system/modulos/empleados/empleado-update.php',
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
            
            $('#editarEmpleado').modal('hide');            
        });        
    });   

});//finjs

var resetearDatatables = function(){
    $('#listado-empleados').dataTable().fnDestroy(); 
    listarEmpleados();
};

var listarEmpleados = function(){
    var table = $('#listado-empleados').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/empleados/listar.php"
        },
        "columns":[
            {"data":"id"},
            {"data":"dni"},
            {"data":"empleado"},
            {"data":"cargo"},
            {"data":"personaid",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='perfil btn btn-info' personaid="+oData.personaid+">Ver Perfil</button>")
                }
            },
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='empleado-edit btn btn-warning' data-toggle='modal' data-target='#editarEmpleado' empleadoId="+oData.id+"><i class='far fa-edit'></i></button><button class='deleteEmpleado btn btn-danger' empleadoId="+oData.id+"><i class='far fa-trash-alt'></i></button>")
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
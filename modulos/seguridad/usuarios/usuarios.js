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

//     $('#agregar').submit(function(e){
//         //usa e.preventDefault() evita la accion del submit
//         e.preventDefault()
//         const dataAgregar = {
//             nombre: $('#nombre').val(),
//             apellido: $('#apellido').val(),
//             dni: $('#dni').val(),
//             cuil: $('#cuil').val(),
//             sexo: $('#sexo').val(),
//             fchNac: $('#fchNac').val(),
//             nacionalidad: $('#nacionalidad').val(),
//             nro_cuenta: $('#nro_cuenta').val()
//         }
//       console.log(dataAgregar);
//       $.ajax({
//               url: '/autoparts_system/modulos/Clientes/cliente-add.php',
//               type: 'post',
//             data: dataAgregar,
//           beforeSend: function (){
//               //opcional
//           //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
//           }
  
//         }).done(function(response){
//               console.log(response);
//               Swal.fire(response);
//             //   if(response==='Exito'){
//             //     Swal.fire({
//             //         position: 'center',
//             //         icon: 'success',
//             //         title: '¡Agregado exitosamente!',
//             //         showConfirmButton: false,
//             //         timer: 2500
//             //     });
              
//             // }else{
//             //     Swal.fire({
//             //         position: 'center',
//             //         icon: 'error',
//             //         title: '¡Ha ocurrido un error al agregar!',
//             //         showConfirmButton: true,
//             //         confirmButtonColor:"#d63030",
//             //       })
                  
//             // }
//           listarClientes();
//           // Se resetea el formulario luego de haber enviado los datos
//           $('#agregar').trigger('reset');
//         }).fail(function(jqXHR, ajaxOptions, thrownError){
//           //en caso de que haya un error muestras un mensaje con el error
//           console.log(thrownError);
//         });
//         //Con esta linea se esconde el modal de agregar
//         $('#nuevoCliente').modal('hide');
        
//     });

    

//     //Eliminar
//     $(document).on('click', '.deleteCliente', function(){
        
//         if(
//             Swal.fire({
                
//                 icon: 'info',
//                 html:
//                   '¿Está seguro que desea dar de baja este Cliente?',
//                 showCloseButton: true,
//                 showCancelButton: true,
//                 focusConfirm: false,
//                 confirmButtonText:
//                   '<i class="fa fa-thumbs-up"></i> Eliminar',
//                 confirmButtonColor:"#d63030",
//                 cancelButtonText:
//                   '<i class="fa fa-thumbs-down"></i>Cancelar',
//               })
//         ){
//             let element = $(this)[0].parentElement.parentElement;
//             let id = $(element).attr('clienteId');
            
//             $.post('cliente-delete.php', {id:id}, function(response){
//                 console.log(response);
//                 Swal.fire(response);
                
//                 listarClientes();
                
//             });
//         }
//     });

//     //Editar-cliente
//     $(document).on('click', '.cliente-edit', function(){
//         let element = $(this)[0];
//         let clienteid = $(element).attr('clienteId');
        

//         $.post('cliente-edit.php', {clienteid}, function(response){
//             console.log(response);
           
//             const datos = JSON.parse(response);

//             $('#personaidedit').val(datos.personaid);
//             $('#clienteidedit').val(datos.clienteid);
            
//             $('#fechaaltaclienteedit').val(datos.fechaAlta);
//             $('#nrocuentaedit').val(datos.nroCuenta);
//         });

//         $('#editarCliente').submit(function(e){

//             const postData = {
//                 personaid: $('#personaidedit').val(),
//                 clienteid: $('#clienteidedit').val(),
                
//                 fechaalta: $('#fechaaltaclienteedit').val(),
//                 nrocuenta: $('#nrocuentaedit').val()
    
//             };
    
//             $.ajax({
//                 url: 'clientes-update.php',
//                 data: postData,
//                 type: 'POST',
//                 success: function(response){
//                     Swal.fire(response);
//                     console.log(response);
//                     listarClientes();
                    
//                 },
//                 error: function(XMLHttpRequest, textStatus, errorThrown) { 
//                     alert("Status: " + textStatus); alert("Error: " + errorThrown); 
//                 }
//             });
            
//             $('#editarCliente').modal('hide');

//             e.preventDefault();
//         });


    

        
//     });

});

var listarUsuarios = function(){
    var table = $('#listadoUsuarios').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/seguridad/usuarios/listar.php"
        },
        "columns":[
            {"data":"id"},
            {"data":"nombre"},
            {"data":"usuario"},
            {"data":"email"},
            {"data":"agregado"},
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button  title='Editar datos' class='usuario-edit btn btn-warning' data-toggle='modal' data-target='#editarUsuario' usuarioId="+oData.id+"><i class='far fa-edit'></i><button class='password-edit btn btn-info' title='Cambiar contraseña' data-toggle='modal' data-target='#editarPassword' usuarioId="+oData.id+"><i class='fas fa-key'></i></button><button class='deleteUsuario btn btn-danger' title='Eliminar usuario' usuarioId="+oData.id+"><i class='far fa-trash-alt'></i></button>")
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
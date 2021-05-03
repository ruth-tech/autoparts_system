$(document).ready(function(){
    console.log('Funciona JS de Proveedores');
    listarProveedores();//llamado y ejecucuion de la funcioon que muestra el listado 
    

    // Listado

    // function proveedoreslist(){
    //     $.ajax({
    //         url: 'lista.php',
    //         type: 'GET',
    //         success: function(response){
    //             console.log(response)
    //             let registros = JSON.parse(response);
    //             console.log(registros);
    //             let template ='';

    //             if(registros.length !== 0){

    //                 registros.forEach(registros=>{
    //                     template +=
    //                     `<tr proveedorId="${registros.proveedorid}">
    //                         <td>${registros.proveedorid}</td>
    //                         <td>${registros.proveedor}</td>
    //                         <td>${registros.cuit}</td>
    //                         <td>${registros.categoria}</td>
    //                         <td><a href="${registros.website}">${registros.website}</a></td>
    //                         <td><button class="perfil btn btn-warning"><a id="perfil" href="" personaId="${registros.personaId}" style="color: black" >Ver Perfil</a></button></td>
    //                         <td>
    //                             <button class="proveedor-edit btn btn-warning" data-toggle="modal" data-target="#editarProveedor" personaId="${registros.personaId}" ><i class="far fa-edit"></i></button>
    //                             <button class="deleteProveedor btn btn-danger"><i class="far fa-trash-alt"></i></button>
    //                         </td>
    //                     </tr>`
    //                 });
    //                 $("#listadoProveedores").html(template);
    //             }else{
    //                 $("#listado").hide();
    //                 template = '¡No se han encontrado registros de Proveedores activos en la base de datos, agregue al menos uno!';
    //                 $(".card-body").html(template);
    //             }                
    //         }
    //     });
    // } 

    // ACCESO AL PERFIL
    $(document).on('click', '.perfil', function () {
        var hrefperfil = '/autoparts_system/modulos/perfiles/index-juridica.php';
        let element = $(this)[0];                                                                 
        let personaId = $(element).attr('personaid');

        // Check if any ID is aviable 
        if (personaId) {
            // Save the url and perform a page load
            var direccion = hrefperfil + '?personaId=' + personaId; 
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
            cuit: $('#cuit').val(),
            razonsocial: $('#razonsocial').val(),
            categoria: $('#categoria').val(),
            nrohabilitacion: $('#nrohabilitacion').val(),
            website: $('#website').val()           
        }
      console.log(dataAgregar);
      $.ajax({
              url: '/autoparts_system/modulos/proveedores/proveedor-add.php',
              type: 'post',
            data: dataAgregar,
          beforeSend: function (){
              //opcional
          //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
          }
  
        }).done(function(response){
              console.log(response);
              Swal.fire(response);
            //   if(response!=="Exito"){
            //     Swal.fire({
            //         position: 'center',
            //         icon: 'success',
            //         title: '¡Agregado exitosamente!',
            //         showConfirmButton: false,
            //         timer: 5000
            //     });
              
            // }else{
            //     Swal.fire({
            //         position: 'center',
            //         icon: 'error',
            //         title: '¡Ha ocurrido un error al intentar agregar, inténtelo nuevamnete!',
            //         showConfirmButton: true,
            //         confirmButtonColor:"#d63030",
            //       })
                  
            // }
            listarProveedores();
          // Se resetea el formulario luego de haber enviado los datos
          $('#agregar').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
          //en caso de que haya un error muestras un mensaje con el error
          console.log(thrownError);
        });
        //Con esta linea se esconde el modal de agregar
        $('#nuevoProveedor').modal('hide');
        
    });

    //Eliminar
    $(document).on('click', '.deleteProveedor', function(){
        
        if(
            Swal.fire({
                
                icon: 'info',
                html:
                  '¿Está seguro que desea dar de baja este Empleado?',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                  '<i class="fa fa-thumbs-up"></i> Eliminar',
                confirmButtonColor:"#d63030",
                cancelButtonText:
                  '<i class="fa fa-thumbs-down"></i>Cancelar',
              })
        ){
            let element = $(this)[0];
            let id = $(element).attr('proveedorId');
            
            $.post('proveedor-delete.php', {id:id}, function(response){
                console.log(response);
                Swal.fire(response);
                // if(response!=="Exito"){
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'success',
                //         title: '¡Dado de baja exitosamente!',
                //         showConfirmButton: false,
                //         timer: 5000
                //     });
                  
                // }else{
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'error',
                //         title: '¡Ha ocurrido un error al dar de baja al proveedor seleccionado!',
                //         showConfirmButton: true,
                //         confirmButtonColor:"#d63030",
                //     })
                      
                // }
                listarProveedores();
                
            });
        }
    });

    //Editar-cliente
    $(document).on('click', '.proveedor-edit', function(){
        let element = $(this)[0];
        let proveedorid = $(element).attr('proveedorId');
        

        $.post('proveedor-edit.php', {proveedorid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#proveedoridedit').val(datos.proveedorid);
            $('#fechaaltaproveedoredit').val(datos.fechaAlta);            
            $('#websiteedit').val(datos.website);
            $('#categoriaedit').val(datos.categoria);
        });

        $('#editar-proveedor').submit(function(e){
            e.preventDefault();
            const postData = {
                proveedorid: $('#proveedoridedit').val(),
                fechaalta: $('#fechaaltaproveedoredit').val(),
                website: $('#websiteedit').val(),
                categoria: $('#categoriaedit').val()
    
            };
    
            $.ajax({
                url: 'proveedor-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    listarProveedores();
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#editarProveedor').modal('hide');

            
        });   

        
    });
});

var listarProveedores = function(){
    var table = $('#listadoProveedores').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/proveedores/listar.php"
        },
        "columns":[
            {"data":"proveedorid"},
            {"data":"proveedor"},
            {"data":"cuit"},
            {"data":"categoria"},
            {"data":"website"},
            {"data":"personaid",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='perfil btn btn-info' personaid="+oData.personaid+">Ver Perfil</button>")
                }
            },
            {"data":"proveedorid",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='proveedor-edit btn btn-warning' data-toggle='modal' data-target='#editarProveedor' proveedorId="+oData.proveedorid+"><i class='far fa-edit'></i></button><button class='deleteProveedor btn btn-danger' proveedorId="+oData.proveedorid+"><i class='far fa-trash-alt'></i></button>")
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
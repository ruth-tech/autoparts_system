//Prueba de JS
//console.log('Hello Word'); 

//Comprobar el funcionamiento de jquery
$(document).ready(function(){

    console.log('Jquery is working');
    listarClientes();
    // fetchList();//llamado y ejecucuion de la funcioon que muestra el listado de clientes

    // Listado

    // function fetchList(){
    //     $.ajax({
    //         url: 'lista.php',
    //         type: 'GET',
    //         success: function(response){
    //             let lista = JSON.parse(response);
    //             console.log(lista);
    //             let template = '';

    //             if(lista.length !== 0){

    //                 lista.forEach(lista => {
    //                     template +=
    //                     `<tr clienteId="${lista.clienteId}">
    //                         <td>${lista.clienteId}</td>
    //                         <td>${lista.cliente}</td>
    //                         <td>${lista.cuil}</td>
    //                         <td>${lista.nro_cuenta}</td>
    //                         <td><button class="perfil btn btn-warning"><a id="perfil" href="" personaId="${lista.personaId}" style="color: black" >Ver Perfil</a></button></td>
    //                         <td>
    //                             <button class="cliente-edit btn btn-warning" data-toggle="modal" data-target="#editarCliente" personaId="${lista.personaId}" ><i class="far fa-edit"></i></button>
    //                             <button class="deleteCliente btn btn-danger"><i class="far fa-trash-alt"></i></button>
    //                         </td>                    
    //                     </tr>`
    //                 });
    //                 $("#listadoClientes").html(template);
                    
    //             }else{
    //                 $("#listado-head").hide();
    //                 template = '¡No se han encontrado registros de clientes activos en la base de datos, agregue al menos uno!';
    //                 $(".card-body").html(template); 

    //             }
                
    //         }
    //     });
    // }   
    // ACCESO AL PERFIL                                                                     
    $(document).on('click', '.perfil', function () {
        var hrefperfilpersonal = '/autoparts_system/modulos/perfiles/index.php'; 
        let element = $(this)[0];                                                                 
        let personaId = $(element).attr('personaid');
        // let element1 = $(this)[0].parentElement.parentElement;
        // let clienteId = $(element1).attr('clienteId');

        // Save information

        // Check if any ID is aviable 
        if (personaId) {
            // Save the url and perform a page load
            var direccion = hrefperfilpersonal + '?personaId=' + personaId; 
            // + '&clienteId='+ clienteId;
            window.open(direccion,"_self");
            

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
            nro_cuenta: $('#nro_cuenta').val()
        }
        console.log(dataAgregar);
        $.ajax({
            url: '/autoparts_system/modulos/Clientes/cliente-add.php',
            type: 'post',
            data: dataAgregar,
            
        }).done(function(response){
            console.log(response);
            Swal.fire(response);
           
            // listarClientes();
            // Se resetea el formulario luego de haber enviado los datos
            $('#agregar').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
          //en caso de que haya un error muestras un mensaje con el error
          console.log(thrownError);
        });
        //Con esta linea se esconde el modal de agregar
        $('#nuevoCliente').modal('hide');
        
    });

    

    //Eliminar
    $(document).on('click', '.deleteCliente', function(){
        
        if(
            Swal.fire({
                
                icon: 'info',
                html:
                  '¿Está seguro que desea dar de baja este Cliente?',
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
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('clienteId');
            
            $.post('cliente-delete.php', {id:id}, function(response){
                console.log(response);
                Swal.fire(response);
                
                listarClientes();
                
            });
        }
    });

    //Editar-cliente
    $(document).on('click', '.cliente-edit', function(){
        let element = $(this)[0];
        let clienteid = $(element).attr('clienteId');
        

        $.post('cliente-edit.php', {clienteid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#personaidedit').val(datos.personaid);
            $('#clienteidedit').val(datos.clienteid);
            
            $('#fechaaltaclienteedit').val(datos.fechaAlta);
            $('#nrocuentaedit').val(datos.nroCuenta);
        });

        $('#editarCliente').submit(function(e){

            const postData = {
                personaid: $('#personaidedit').val(),
                clienteid: $('#clienteidedit').val(),
                
                fechaalta: $('#fechaaltaclienteedit').val(),
                nrocuenta: $('#nrocuentaedit').val()
    
            };
    
            $.ajax({
                url: 'clientes-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    listarClientes();
                    Swal.fire(response);
                    console.log(response);
                    
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            listarClientes();
            $('#editarCliente').modal('hide');

            e.preventDefault();
        });


    

        
    });

});

var listarClientes = function(){
    var table = $('#listado-clientes').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/Clientes/listar.php"
        },
        "columns":[
            {"data":"id"},
            {"data":"cliente"},
            {"data":"cuil"},
            {"data":"cuenta"},
            {"data":"persona_id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='perfil btn btn-info' personaid="+oData.persona_id+">Ver Perfil</button>")
                }
            },
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='cliente-edit btn btn-warning' data-toggle='modal' data-target='#editarCliente' clienteId="+oData.id+"><i class='far fa-edit'></i></button><button class='deleteCliente btn btn-danger' clienteId="+oData.id+"><i class='far fa-trash-alt'></i></button>")
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
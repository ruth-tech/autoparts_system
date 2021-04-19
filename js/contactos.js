

$(document).ready(function(){
    console.log('Jquery is working in contactos');
    let personaid = $("#persoid").attr('personaid');
    console.log(personaid)
    listacontactos();
   
    

    function listacontactos(){
        $.ajax({
            url:"/autoparts_system/modulos/contactos/lista.php",
            type:"GET",
            //datatype:"json",//SI DEFINO EL DATATYPE COMO JSON NO HACE FALTA PARSEARLO, PORQUE AJAX YA LO TOMA COMO JSON A LA RESPUESTA
            data:{personaid:personaid},
            success: function(response){ 
                console.log(response)
                let lista = JSON.parse(response);                 
                console.log(lista);

                let template = '';

                if(lista.length !== 0){

                    lista.forEach(lista =>{
                        template +=
                        `<tr contactoid="${lista.contactoid}">
                            <td>${lista.tipo_contacto_descripcion}</td>
                            <td>${lista.valor_contacto}</td>
                            <td><span data-placement="top" title="Editar datos" data-toggle="tooltip"><button type="button" class="editar-contacto btn btn-warning"  data-toggle="modal" data-target="#editarcontacto" personaid="${lista.personaid}"><i class="far fa-edit"></i></button> 
                            <button class="deletecontacto btn btn-danger" data-placement="top" title="Eliminar datos" data-toggle="tooltip"><i class="far fa-trash-alt"></i></button></td>               
                        </tr>`
                    });
                    $("#listadoContacto").html(template);
                }else{ 
                    $("#listado-contactos").hide();
                    template = '¡No se han encontrado registros de contactos activos de la persona en la base de datos, agregue al menos uno!';
                    $(".card-body-contactos").html(template);
                }
            },
            error: function(xhr,ajaxOptions,thrownError){
                console.log(thrownError);
            }
        });
    }

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
        
        if(
            Swal.fire({
                
                icon: 'info',
                html:
                  '¿Estas seguro que desea dar de baja este contacto?',
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
            let element = $(this)[0].parentElement.parentElement.parentElement;
            let contactoid = $(element).attr('contactoid');
            console.log(contactoid)
            $.post('/autoparts_system/modulos/contactos/contacto-delete.php', {contactoid}, function(response){
               console.log(response);
               Swal.fire(response);
                // if(response=="Exito"){
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'success',
                //         title: '¡Dado de baja exitosamente!',
                //         showConfirmButton: false,
                //         timer: 2500
                //     });
                  
                // }else{
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'error',
                //         title: '¡Ha ocurrido un error al dar de baja el contacto seleccionado!',
                //         showConfirmButton: true,
                //         confirmButtonColor:"#d63030",
                //       })
                      
                // }
                listacontactos();
            });

        }
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




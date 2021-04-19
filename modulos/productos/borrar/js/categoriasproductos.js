
// prueba de javascript 
$(document).ready(function(){
    console.log('Jquery is working in Categorias-productos.');
    categorialist();

    function categorialist(){
        $.ajax({
            url: 'lista.php',
            type: 'GET',
            success:function(response){
                console.log(response);
                let lista = JSON.parse(response);
                console.log(lista);
                let template ='';

                lista.forEach(lista => {
                    template+=
                    `<tr categoriaid="${lista.id}">
                            <td>${lista.id}</td>
                            <td>${lista.descripcion}</td>
                            <td><button class="vehiuclos btn btn-info"><a href='/autoparts_system/modulos/categorias_productos/vehiculos/index.php?categoriaid=${lista.id}' style="color:white">Ver todos</a></button></td>
                            <td>
                                <button class="categoria-edit btn btn-warning" data-toggle="modal" data-target="#editarCategoria"><i class="far fa-edit"></i></button>
                                <button class="deleteCategoria btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            </td>                    
                        </tr>`
                });
                $("#listadoCategorias").html(template);
            }
        })
    }
//ACCESO A MODELOS DE VEHICULOS POR CADA CATEGORIA
    // $(document).on('click', '.vehiuclos', function () {
    //     var href = '/autoparts_system/modulos/categorias_productos/vehiculos/index.php';
    //     let element = $(this)[0].parentElement.parentElement;
    //     console.log(element)                                                                 
    //     let categoriaid = $(element).attr('categoriaid');

    //     // Check if any ID is aviable 
    //     if (categoriaid) {
    //         // Save the url and perform a page load
    //         var direccion = href + '?categoriaid=' + categoriaid; 
    //         // + '&clienteId='+ clienteId;
    //         window.open(direccion);
    //     } 
    // }); 

    $('#agregar').submit(function(e){
        e.preventDefault();
        const dataAgregar = {
            descripcion: $('#descripcion').val()
        }
        console.log(dataAgregar);
        $.ajax({
            url: '/autoparts_system/modulos/categorias_productos/categoria-add.php',
            type: 'POST',
            data: dataAgregar,
            beforeSend: function (){
                //opcional
            //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
            }
        }).done(function(response){
            console.log(response);
            Swal.fire(response);
            // if(response==='Exito'){
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
            //         title: '¡Ha ocurrido un error al agregar!',
            //         showConfirmButton: true,
            //         confirmButtonColor:"#d63030",
            //     });
            // }
            categorialist();
            $('#agregar').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
            console.log(thrownError);
        });
        $('#nuevaCategoria').modal('hide');   

    });

    //Eliminar
    $(document).on('click', '.deleteCategoria', function(){
        
        if(
            Swal.fire({
                
                icon: 'info',
                html:
                  '¿Está seguro que desea dar de baja esta Categoria?',
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
            let id = $(element).attr('categoriaid');
            console.log(id)
            
            $.post('/autoparts_system/modulos/categorias_productos/categoria-delete.php', {id:id}, function(response){
                console.log(response);
                Swal.fire(response);
                // if(response=="Exito"){
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'success',
                //         title: '¡Dado de baja exitosamente!',
                //         showConfirmButton: false,
                //         timer: 500
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
                categorialist();
                
            });
        }
    });

    //Editar
    $(document).on('click', '.categoria-edit', function(){
        let element = $(this)[0].parentElement.parentElement;
        let categoriaid = $(element).attr('categoriaid');
       
        $.post('/autoparts_system/modulos/categorias_productos/categoria-edit.php', {categoriaid}, function(response){
            console.log(response);           
            const datos = JSON.parse(response);
            $('#categoriaidedit').val(datos.categoriaid);
            $('#descripcionedit').val(datos.descripcion);
        });

        $('#editar-categoria').submit(function(e){
            e.preventDefault();
            const postData = {
                categoriaid: $('#categoriaidedit').val(),
                descripcion: $('#descripcionedit').val()
            };    
            $.ajax({
                url: '/autoparts_system/modulos/categorias_productos/categoria-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    categorialist();                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });            
            $('#editarCategoria').modal('hide');           
        });       
    });
});//fin js





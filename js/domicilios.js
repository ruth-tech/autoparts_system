$(document).ready(function(){
    console.log('Jquery is working in domicilios');
    let personaid = $("#persoid").attr('personaid');
    console.log(personaid)
    listadomicilios();
    

    function listadomicilios(){ 
        $.ajax({
            url:"/autoparts_system/modulos/domicilios/lista.php",
            type:"GET",
            //datatype:"json",//SI DEFINO EL DATATYPE COMO JSON NO HACE FALTA PARSEARLO, PORQUE AJAX YA LO TOMA COMO JSON A LA RESPUESTA
            data:{personaid:personaid},
            success: function(response){
                console.log(response)
                let lista = JSON.parse(response);                
                console.log(lista);

                let template = '';

                if(lista.length != 0){

                    lista.forEach(lista =>{
                        template +=
                        `<tr domicilioid="${lista.domicilioid}">
                            <td>${lista.tipo_domicilio_descripcion}</td>
                            <td>${lista.barrio}</td>
                            <td>${lista.calle}</td>
                            <td>${lista.altura}</td>
                            <td>${lista.torre}</td>
                            <td>${lista.piso}</td>
                            <td>${lista.manzana}</td>
                            <td>${lista.sector}</td>
                            <td>${lista.parcela}</td>
                            <td><span data-placement="top" title="Editar datos" data-toggle="tooltip"><button type="button" class="editar-domicilio btn btn-warning" data-toggle="modal" data-target="#editardomicilio" personaid="${lista.personaid}"><i class="far fa-edit"></i></button>
                            <button class="deletedomicilio btn btn-danger" data-placement="top" title="Eliminar datos" data-toggle="tooltip"><i class="far fa-trash-alt"></i></button></td> 
                                             
                        </tr>`
                    });
                    $("#listadodomicilio").html(template);
                }else{
                    $("#listado-domicilio").hide();
                    template = '¡No se han encontrado registros de Domicilios activos de la persona en la base de datos, agregue al menos uno!';
                    $(".card-body-domicilios").html(template);
                }
            },
            error: function(xhr,ajaxOptions,thrownError){
                console.log(thrownError);
            }
        });
    }

    // AGREGAR
    $(".domicilio-add").on('click', function(){
        //SELECT PROVINCIAS
        $("#paises").change(function(){
            let paisid= $("#paises").val();
            console.log(paisid);
            $.ajax({
               data:  {paisid},
               url:   '/autoparts_system/modulos/domicilios/ajax_provincias.php',
               type:  'POST',
               success:  function (response) {  
                   console.log(response);
                   let datos = JSON.parse(response) ;
                   console.log(datos)
                   for(let i = 0; i < datos.length; i++){
                        $("#provincias").append(`<option value="${datos[i].id}">${datos[i].provincia}</option>`)
                   }
               },
               error:function(){
                   alert("error")
               }
           });
        });
        //SELECT LOCALIDADES
        $("#provincias").change(function(){
            let provinciaid=$("#provincias").val();
            console.log(provinciaid);
            $.ajax({
               data:  {provinciaid},
               url:   '/autoparts_system/modulos/domicilios/ajax_localidades.php',
               type:  'POST',
               success:  function(response) {   
                console.log(response);             	
                let datos = JSON.parse(response);
                console.log(datos);
                for(let i = 0; i < datos.length; i++){
                 $("#localidades").append(`<option value="${datos[i].id}">${datos[i].localidad}</option>`)
                }
               },
               error:function(){
                   alert("error");
               }
           });
        });

        $('#agregardomi').submit(function(e){
            
            const postData = { 
                personaid:$('#idpersona').val(),
                tipodomicilio: $('#tipodomicilio').val(),
                localidad: $('#localidades').val(),            
                barrio: $('#barrio').val(),            
                calle: $('#calle').val(),            
                altura: $('#altura').val(),            
                torre: $('#torre').val(),            
                piso: $('#piso').val(),            
                manzana: $('#manzana').val(),            
                sector: $('#sector').val(),            
                parcela: $('#parcela').val(),            
            };
            console.log(postData);
            $.post('/autoparts_system/modulos/domicilios/domicilio-add.php', postData, function(response){
                console.log(response);
                Swal.fire(response);
                // if(response==='Exito'){
                //     Swal.fire('Exito al agregar');
                   
                // }else{
                //     Swal.fire({
                //         position: 'center',
                //         icon: 'error',
                //         title: '¡Ha ocurrido un error al intentar agregar un domicilio!',
                //         showConfirmButton: true,
                //         confirmButtonColor:"#d63030",
                //       })
                    
                // }
                listadomicilios();
    
                // Se resetea el formulario luego de haber enviado los datos
    
                $('#agregardomi').trigger('reset');
                
            });
    
            //Con esta linea se esconde el modal de agregar
            $('#agregardomicilio').modal('hide');
            
    
    
            //se utiliza para detener una accion por omision
            //Llamar a preventDefault en cualquier momento durante la ejecución, cancela el evento, lo que significa que cualquier acción por defecto que deba producirse como resultado de este evento, no ocurrirá.
            e.preventDefault();
        });

    });

    //Eliminar
    $(document).on('click', '.deletedomicilio', function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            text:'¿Estas seguro que desea dar de baja este domicilio?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                let element = $(this)[0].parentElement.parentElement.parentElement;
                let domicilioid = $(element).attr('domicilioid');
                console.log(domicilioid);
                $.post('/autoparts_system/modulos/domicilios/domicilio-delete.php', {domicilioid}, function(response){
                    console.log(response);
                    listadomicilios();
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


    //EDITAR
    $(document).on('click', '.editar-domicilio', function(){
        let element = $(this)[0].parentElement.parentElement.parentElement;
        let domicilioid = $(element).attr('domicilioid');
        console.log(domicilioid);

        $.post('/autoparts_system/modulos/domicilios/domicilio-edit.php', {domicilioid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#id_domi').val(datos.domicilioid),
            $('#tipo_domi').append(`<option value="` +datos.tipodomicilioid+ `">` +datos.tipodomiciliodescripcion+ `</option>`),
            $('#localidad_domi').append(`<option value="`+datos.localidadid+`">`+datos.localidaddescripcion+`</option>`),
            $('#barrio_domi').val(datos.barrio),
            $('#calle_domi').val(datos.calle),
            $('#altura_domi').val(datos.altura),
            $('#torre_domi').val(datos.torre),
            $('#piso_domi').val(datos.piso),
            $('#manzana_domi').val(datos.manzana),
            $('#sector_domi').val(datos.sector),
            $('#parcela_domi').val(datos.parcela)
        });

        $('#editardomi').submit(function(e){
            e.preventDefault();
            const postData = {
                domicilioid: $('#id_domi').val(),
                tipodomicilioid: $('#tipo_domi').val(),
                localidadid: $('#localidad_domi').val(),
                barrio: $('#barrio_domi').val(),
                calle: $('#calle_domi').val(),
                altura: $('#altura_domi').val(),                
                torre: $('#torre_domi').val(),
                piso: $('#piso_domi').val(),
                manzana: $('#manzana_domi').val(),
                sector: $('#sector_domi').val(),
                parcela: $('#parcela_domi').val()
    
            };
    
            $.ajax({
                url: '/autoparts_system/modulos/domicilios/domicilio-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    listadomicilios();
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#editardomicilio').modal('hide');            
        });        
    });
   
    

});
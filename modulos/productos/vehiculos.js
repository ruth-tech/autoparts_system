$(document).ready(function(){
    
    console.log('Funciona jquery de vehiculos');
    listarModelos();
   
    

});//fin js

var listarModelos = function(){
    let marca = $('#marca').attr('marcaid');
    var table = $('#listado-modelos').dataTable({
        
        "ajax":{            
            "method":"POST",
            "url":"/autoparts_system/modulos/productos/ajax_modelos.php",
            "data":{marca}
        },
        "columns":[
            {"data":"id"},
            {"data":"vehiculo"},
            {"data":"anio"},
            {"data":"id",
                "fnCreatedCell":function(nTd,sData,oData,iRow,iCol){
                    $(nTd).html("<a class='btn btn-danger' href='/autoparts_system/modulos/productos/categorias_productos.php?modeloid="+oData.id+"'>Ver</a>")
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

    // $('#modelos, #vehiculo').empty();
        // var href = '/autoparts_system/modulos/productos/modelos_vehiculos.php';
        // let element = $(this)[0].parentElement;
        // let vehiculoid = $(element).attr('id')
        // console.log(vehiculoid);

        // $.ajax({
        //     data:  {vehiculoid},
        //     url:   'ajax_modelos.php',
        //     type:  'POST',
        //     success:  function (response) {  
        //         console.log(response);
        //         let datos = JSON.parse(response) ;
        //         console.log(datos)
        //         $('#vehiculoid').val(datos.vehiculo_id)
        //         for(let i = 0; i < datos.length; i++){
        //             $("#modelos").append(`<option value="${datos[i].id}">${datos[i].modelo} -  ${datos[i].anio}</option>`)
        //         }
                
        //     },
        //     error:function(){
        //         alert("error")
        //     }
        // });

        // $('#modelos_vehiculos').submit(function(e){
        //     e.preventDefault();

        //     $.post('modelos_vehiculos.php',{vehiculoid:$('#vehiculoid').val(),modeloid:$('#modelos').val()},function(){
        //         window.location = 'modelos_vehiculos.php';
        //     })

        //     $.redirect('modelos_vehiculos.php', {modeloid:$('#modelos').val()});
        // }); 
            
            

    // let categoria = $("#categoria").attr('categoriaid');
    // console.log(categoria);
    // listaVehiculos();

    // function listaVehiculos(){
    //     $.ajax({
    //         url:"lista.php",
    //         type: "GET",
    //         data:{categoria},
    //         success:function(response){
    //             console.log(response);
    //             let lista = JSON.parse(response);
    //             console.log(lista);
    //             let template = '';

    //             lista.forEach(lista => {
    //                 template +=
    //                     `<tr vehiculoid="${lista.vehiculoid}">
    //                         <td>${lista.vehiculoid}</td>
    //                         <td>${lista.vehiculodescripcion}</td>
    //                         <td><button class="btn btn-info"><a href="/autoparts_system/modulos/categorias_productos/vehiculos/modelos_vehiculos/index.php?categoriaid=${lista.categoria}&vehiculoid=${lista.vehiculoid}" style="color:white" >Ver todos</a></button></td>
    //                         <td>
    //                             <button class="vehiculo-edit btn btn-warning" data-toggle="modal" data-target="#editarVehiculo"categoria="${lista.categoria}"><i class="far fa-edit"></i></button>
    //                             <button class="deleteVehiculo btn btn-danger" categoria="${lista.categoria}"><i class="far fa-trash-alt"></i></button>
    //                         </td>               
    //                     </tr>`
    //             });
    //             $('#listadoVehiculos').html(template);
    //         }
    //     });
    // }

    // //AGREGAR
    // $('#agregar').submit(function(e){
    //     e.preventDefault();
    //     const dataAgregar = {
    //         categoriaid: $('#categoria-add').val(),
    //         descripcion: $('#descripcion').val()
    //     }
    //     console.log(dataAgregar);
    //     $.ajax({
    //         url: '/autoparts_system/modulos/categorias_productos/vehiculos/vehiculo-add.php',
    //         type: 'POST',
    //         data: dataAgregar,
    //         beforeSend: function (){
    //             //opcional
    //         //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
    //         }
    //     }).done(function(response){
    //         console.log(response);
    //         if(response==='Exito'){
    //             Swal.fire({
    //                 position: 'center',
    //                 icon: 'success',
    //                 title: '¡Agregado exitosamente!',
    //                 showConfirmButton: false,
    //                 timer: 5000
    //             });
              
    //         }else{
    //             Swal.fire({
    //                 position: 'center',
    //                 icon: 'error',
    //                 title: '¡Ha ocurrido un error al agregar!',
    //                 showConfirmButton: true,
    //                 confirmButtonColor:"#d63030",
    //             });
    //         }
    //         listaVehiculos();
    //         $('#agregar').trigger('reset');
    //     }).fail(function(jqXHR, ajaxOptions, thrownError){
    //         console.log(thrownError);
    //     });
    //     $('#nuevoVehiculo').modal('hide');   

    // });

    // //Eliminar
    // $(document).on('click', '.deleteVehiculo', function(){        
    //     if(
    //         Swal.fire({                
    //             icon: 'info',
    //             html:
    //               '¿Está seguro que desea dar de baja este Vehiculo?',
    //             showCloseButton: true,
    //             showCancelButton: true,
    //             focusConfirm: false,
    //             confirmButtonText:
    //               '<i class="fa fa-thumbs-up"></i> Eliminar',
    //             confirmButtonColor:"#d63030",
    //             cancelButtonText:
    //               '<i class="fa fa-thumbs-down"></i>Cancelar',
    //           })
    //     ){
    //         let element = $(this)[0].parentElement.parentElement;
    //         let idvehiculo = $(element).attr('vehiculoid');
    //         console.log(idvehiculo)
    //         let element2 = $(this)[0];
    //         let idcategoria = $(element2).attr('categoria');
    //         console.log(idcategoria)
            
    //         $.post('/autoparts_system/modulos/categorias_productos/vehiculos/vehciulo-delete.php', {idvehiculo,idcategoria}, function(response){ 
    //             console.log(response);
    //             Swal.fire(response);
    //             // if(response=="Exito"){
    //             //     Swal.fire({
    //             //         position: 'center',
    //             //         icon: 'success',
    //             //         title: '¡Dado de baja exitosamente!',
    //             //         showConfirmButton: false,
    //             //         timer: 500
    //             //     });
                  
    //             // }else{
    //             //     Swal.fire({
    //             //         position: 'center',
    //             //         icon: 'error',
    //             //         title: '¡Ha ocurrido un error al dar de baja el vehiculo seleccionado!',
    //             //         showConfirmButton: true,
    //             //         confirmButtonColor:"#d63030",
    //             //     })                      
    //             // }
    //             listaVehiculos();                
    //         });
    //     }
    // });

    // //Editar
    // $(document).on('click', '.vehiculo-edit', function(){
    //     let element = $(this)[0].parentElement.parentElement;
    //     let idvehiculo = $(element).attr('vehiculoid');
    //     console.log(idvehiculo)
    //     let element2 = $(this)[0];
    //     let idcategoria = $(element2).attr('categoria');
    //     console.log(idcategoria)
       
    //     $.post('/autoparts_system/modulos/categorias_productos/vehiculos/vehiculo-edit.php', {idvehiculo,idcategoria}, function(response){
    //         console.log(response);           
    //         const datos = JSON.parse(response);
    //         $('#categoriaidedit').val(datos.idcategoria);
    //         $('#vehiculoidedit').val(datos.idvehiculo);
    //         $('#descripcionedit').val(datos.descripcion);
    //     });

    //     $('#editar-vehiculo').submit(function(e){
    //         e.preventDefault();
    //         const postData = {
    //             categoriaid: $('#categoriaidedit').val(),
    //             vehiculoid: $('#vehiculoidedit').val(),
    //             descripcion: $('#descripcionedit').val()
    //         };    
    //         $.ajax({
    //             url: '/autoparts_system/modulos/categorias_productos/vehiculos/vehiculo-update.php',
    //             data: postData,
    //             type: 'POST',
    //             success: function(response){
    //                 Swal.fire(response);
    //                 console.log(response);
    //                 listaVehiculos();                    
    //             },
    //             error: function(XMLHttpRequest, textStatus, errorThrown) { 
    //                 alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    //             }
    //         });            
    //         $('#editarVehiculo').modal('hide');           
    //     });       
    // });

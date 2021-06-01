$(document).ready(function(){
    console.log('Jquery en Productos.js');

    let categoriaxmodelo = $('#categoriaxmodelo').attr('categoriaxmodelo');
    listarProductos();
    // productosList();

    // function productosList(){
    //     $.ajax({
    //         url:'/autoparts_system/modulos/productos/productos/lista.php',
    //         type:'POST',
    //         data:{categoria,modelo}
    //     }).done(function(response){
    //         console.log(response)
    //         let datos = JSON.parse(response);
    //         let template = '';

    //         if(datos.length != 0){

    //             datos.forEach(datos =>{
    //                 template +=
    //                 `<tr productoxcategoria_id="${datos.id}">
    //                     <td>${datos.id}</td>
    //                     <td>${datos.descripcion}</td>
    //                     <td>${datos.fabricante}</td>                        
    //                     <td>${datos.detalles}</td>                        
    //                     <td><span data-placement="top" title="Editar precio" data-toggle="tooltip"><button class="edit-precio text-dark" data-toggle="modal" data-target="#editarPrecio" style="border:none; background:none">${datos.precio}</button></span></td>                        
    //                     <td>
    //                         <span data-placement="top" title="Informacion de Producto" data-toggle="tooltip"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#productoInfo" categoria="${datos.categoria} modelo="${datos.modelo}">Ver más</button>
    //                     </td> 
    //                     <td>
    //                         <span data-placement="top" title="Editar datos" data-toggle="tooltip"><button type="button" class=" edit-producto btn btn-warning" data-toggle="modal" data-target="#editarProducto"><i class="far fa-edit"></i></button>
    //                         <span data-placement="top" title="Eliminar datos" data-toggle="tooltip"><button type="button" class="deleteProducto btn btn-danger"><i class="far fa-trash-alt"></i></button>
    //                     </td> 
                                         
    //                 </tr>`
    //             });
    //             $("#productoslista").html(template);
    //         }else{
    //             $("#listado-productos").hide();
    //             template = '¡No se han encontrado registros de productos activos del modelo de vehiculo en la categoria seleccionada en la base de datos, agregue al menos uno!';
    //             $(".card-body-productos").html(template);
    //         }

    //     }).fail(function(jqXHR, ajaxOptions, thrownError){
    //         //en caso de que haya un error muestras un mensaje con el error
    //         console.log(thrownError);
    //       });

    // }
      //Eliminar
      $(document).on('click', '.deleteProducto', function(){
       
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          
          swalWithBootstrapButtons.fire({
            text:'¿Estas seguro que desea dar de baja a este Producto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                let element3 = $(this)[0];
                let productoid =$(element3).attr('productoId')
                console.log(productoid)
                $.post('producto-delete.php', {productoid}, function(response){
                    console.log(response);
                    resetearDatatables();
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
    //ELIMINAR
    // $(document).on('click', '.deleteProducto', function(){
        
    //     if(
    //         Swal.fire({
                
    //             icon: 'info',
    //             html:
    //               '¿Está seguro que desea dar de baja este Producto?',
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
            
    //         let element3 = $(this)[0];
    //         let productoid =$(element3).attr('productoId')
    //         console.log(productoid)
            
    //         $.post('producto-delete.php', {productoid}, function(response){
    //             console.log(response);
    //             Swal.fire(response);
                
    //             listarProductos();
                
    //         });
    //     }else{
    //         listarProductos();
    //     }
    // });

    //AGREGAR
    $('#agregar').submit(function(e){
        e.preventDefault();
        const dataAgregar = {
            categoriaxmodelo,
            descripcion: $('#descripcion').val(),
            fabricante: $('#fabricante').val(),
            cantidad: $('#cantidad').val(),
            precioventa: $('#precioventa').val(),
            detalles: $('#detalles').val()
        }
        console.log(dataAgregar);
        $.ajax({
            url: '/autoparts_system/modulos/productos/productos/producto_add.php',
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
                       

        }).fail(function(jqXHR, ajaxOptions, thrownError){
            console.log(thrownError);
        });
        $('#agregar').trigger('reset');
        $('#nuevoProducto').modal('hide');   

    });


    //Editar producto
    $(document).on('click', '.producto-edit', function(){
        let element3 = $(this)[0];
        let productoid =$(element3).attr('productoId')
        console.log(productoid)

        $.post('producto-edit.php', {productoid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#productoidedit').val(datos.productoid);
            $('#descripcionedit').val(datos.producto_descripcion);
            
            $('#fechaedit').val(datos.producto_fecha_ingreso);
            $('#fabricanteedit').val(datos.producto_detalle_fabricante);
            $('#detallesedit').val(datos.producto_detalle_descripcion);
        });

        $('#editar-producto').submit(function(e){
            e.preventDefault();
            const postData = {
                productoid: $('#productoidedit').val(),
                descripcion: $('#descripcionedit').val(),
                
                fechaingreso: $('#fechaedit').val(),
                fabricante: $('#fabricanteedit').val(),
                detalles: $('#detallesedit').val()
    
            };
    
            $.ajax({
                url: 'producto-update.php',
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
            
            $('#editarProducto').modal('hide');
        });  

        
    });

    //editar precio
    $(document).on('click','.edit-precio',function(e){
        e.preventDefault();
        let element3 = $(this)[0];
        let productoid =$(element3).attr('productoId')
        console.log(productoid);

        $.post('precio-edit.php', {productoid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#productoprecioidedit').val(datos.productoid);
            $('#descripcionprecioedit').val(datos.descripcion);
            $('#fabricanteprecioedit').val(datos.fabricante);
            $('#precioproveedoredit').val(datos.precioproveedor);
            $('#precioedit').val(datos.precio);
        });

        $('#editar-precio').submit(function(e){
            e.preventDefault();
            const postData = {
                productoid: $('#productoprecioidedit').val(),
                precioproveedor: $('#precioproveedoredit').val(),
                precio: $('#precioedit').val()
    
            };
    
            $.ajax({
                url: 'precio-update.php',
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
            
            $('#editarPrecio').modal('hide');
        }); 


    });

    //ACTUALIZAR EXISTENCIA Y PRECIO
    $(document).on('click','.add-existencia',function(e){
        e.preventDefault();
        let element4 = $(this)[0];
        let productoid =$(element4).attr('productoId')
        console.log(productoid);

        $('#add_Existencia').submit(function(e){
            e.preventDefault();
            const postData = {
                productoid,
                existencia: $('#nuevaExistencia').val(),
                precio: $('#precio_nuevo').val()
    
            };
            console.log(postData);
    
            $.ajax({
                url: 'addExistencia.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    
                    resetearDatatables();
                    $('#add_Existencia').trigger('reset');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#addExistencia').modal('hide');
        }); 


    });

});

var resetearDatatables = function(){
    $('#listado-productos').dataTable().fnDestroy(); 
            listarProductos();
};

var listarProductos = function(){
    let categoriaxmodelo = $('#categoriaxmodelo').attr('categoriaxmodelo');
    
    // let modelo = $('#modelo').attr('modeloid');
    var table = $('#listado-productos').dataTable({
        // retrieve:true,
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/productos/productos/listar.php",
            "data":{categoriaxmodelo}

        },
        "columns":[
            {"data":"id"},
            {"data":"producto"},
            {"data":"fabricante"},
            {"data":"detalles"},
            {"data":"existencia"},
            {"data":"precio",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol){
                    $(nTd).html("<span data-placement='top' title='Editar precio' data-toggle='tooltip'><button class='edit-precio text-dark' data-toggle='modal' data-target='#editarPrecio' style='border:none; background:none' productoId="+oData.id+">"+oData.precio+"</button></span>")
                }
            },
            {"data":"id",
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<span data-placement='top' title='Agregar existencia' data-toggle='tooltip'><button class='add-existencia btn btn-info' data-toggle='modal' data-target='#addExistencia' productoId="+oData.id+"><i class='fas fa-plus' productoId="+oData.id+"></i></button></span><span data-placement='top' title='Editar' data-toggle='tooltip'><button class='producto-edit btn btn-warning' data-toggle='modal' data-target='#editarProducto' productoId="+oData.id+"><i class='far fa-edit' productoId="+oData.id+"></i></button></span><span data-placement='top' title='Eliminar' data-toggle='tooltip'><button class='deleteProducto btn btn-danger' productoId="+oData.id+"><i class='far fa-trash-alt' productoId="+oData.id+"></i></button></span>")
                }
            }
        ],
        "language":idioma_espaniol
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
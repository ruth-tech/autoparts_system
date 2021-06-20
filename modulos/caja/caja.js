$(document).ready(function(){
    // alert('Funciona el Jquery');
    resetearDatatables();

    // GENERAR GASTO/INGRESO
    $('#gas_ingre').submit(function(e){
        //usa e.preventDefault() evita la accion del submit
        e.preventDefault()

        const dataAgregar = {
            monto: $('#monto').val(),
            tipo: $('#tipo').val(),
            tipo_pago: $('#tipo_pago').val(),
        }
        console.log(dataAgregar);
        $.ajax({
            url: '/autoparts_system/modulos/caja/generar_gasto_ingreso.php',
            type: 'post',
            data: dataAgregar,
            
        }).done(function(response){
            console.log(response);
            Swal.fire(response);
           
            resetearDatatables();
            // Se resetea el formulario luego de haber enviado los datos
            $('#gas_ingre').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
          //en caso de que haya un error muestras un mensaje con el error
          console.log(thrownError);
        });
        //Con esta linea se esconde el modal de agregar
        $('#gasto_ingreso').modal('hide');
        
    });

     // Agregar
    $('#abrir_caja').submit(function(e){
        //usa e.preventDefault() evita la accion del submit
        e.preventDefault()
        const dataAgregar = {
            monto_inicial: $('#inicial').val()
        }
        console.log(dataAgregar);
        $.ajax({
            url: '/autoparts_system/modulos/caja/iniciar_caja.php',
            type: 'post',
            data: dataAgregar,
            
        }).done(function(response){
            console.log(response);
            Swal.fire(response);
           
            resetearDatatables();
            // Se resetea el formulario luego de haber enviado los datos
            $('#abrir_caja').trigger('reset');
        }).fail(function(jqXHR, ajaxOptions, thrownError){
          //en caso de que haya un error muestras un mensaje con el error
          console.log(thrownError);
        });
        //Con esta linea se esconde el modal de agregar
        $('#abrirCaja').modal('hide');
        
    });

    //Eliminar
    $(document).on('click', '.cerrar_caja', function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })
            
            swalWithBootstrapButtons.fire({
            text:'¿Estás seguro que desea cerrar esta Caja?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Cerrar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                let element = $(this)[0];
                let id = $(element).attr('caja');
                $.post('cerrar_caja.php', {id}, function(response){
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

});//end ready
var resetearDatatables = function(){
    $('#listado-caja').dataTable().fnDestroy(); 
    listarCajas();
};

var listarCajas = function(){
    var table = $('#listado-caja').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/caja/listar.php"
        },
        "columns":[
            {"data":"caja_fecha_inicio"},
            {"data":"monto_inicial"},
            {"data":"caja_monto_total"},
            {"data":"caja_fecha_cierre"},
            {"data":"estado",
                render: function(data, type, row){
                    sev='';
                    switch (data){
                    case 'CERRADO':
                        sev = '<span class="badge badge-danger">'+data+'</span>';
                        break;
                    case 'ABIERTO':
                        sev = '<span class="badge badge-success">'+data+'</span>';
                        break;

                    
                    }
                    // console.log('Content of sev is : '+sev);
                    return sev;
                }
            },
            {
                "render": function (data, type, row) {
                let deshabilitado = "";
                if(row.estado === "CERRADO"){
                    deshabilitado  = "display:none"
                }
                
                return '<a type="button" id="boton" class="cerrar_caja btn btn-warning text-center" data-toggle="modal" data-target="#cerrarCaja" title="Cerrar caja" caja='+row.id+' style="color:black;'+deshabilitado+'"  ><i class="fas fa-business-time" caja='+row.id+'></i> </a >';
                }
            },
            {"data":"id",                  
                "fnCreatedCell":function(nTd, sData, oData, iRow,iCol){
                    $(nTd).html("<button class='cerrar_caja btn btn-info' data-toggle='modal' data-target='#cerrarCaja' title='Ver resumen' caja="+oData.id+"><i class='fas fa-calculator' caja="+oData.id+"></i> ")
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
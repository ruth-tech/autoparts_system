$(document).ready(function() {
    console.log('Nuevo JS esta funcionando');
    
    $( function() {
        $("#consumidor").change( function() {
            if ($(this).val() === "1") {
                $("#id_input").prop("disabled", true);
            } else {
                $("#cliente").prop("disabled", false);
                $("#domicilio").prop("disabled", false);
                $("#email").prop("disabled", false);
                $("#telefono").prop("disabled", false);
                $("#nuevo_cliente").prop("disabled", false);
            }
        });
    });

    // AGREGAR
    $(".agregarproductos").on('click', function(){
        //SELECT MARCAS DE VEHICULOS
        $("#marcavehiculo").change(function(){
            let marcaid= $("#marcavehiculo").val();
            console.log(marcaid);
            $.ajax({
               data:  {marcaid},
               url:   '/autoparts_system/modulos/pedidos/autocompletar/ajax_vehiculo.php',
               type:  'POST',
               success:  function (response) {  
                   console.log(response);
                   let datos = JSON.parse(response) ;
                   console.log(datos)
                   for(let i = 0; i < datos.length; i++){
                        $("#modelos").append(`<option value="${datos[i].id}">${datos[i].modelo}</option>`)
                   }
               },
               error:function(){
                   alert("error")
               }
           });
        });
        //SELECT LOCALIDADES
        $("#modelos").change(function(){
            let modelos=$("#modelos").val();
            console.log(modelos);
            $.ajax({
               data:  {modelos},
               url:   '/autoparts_system/modulos/pedidos/autocompletar/ajax_anio_vehiculos.php',
               type:  'POST',
               success:  function(response) {   
                console.log(response);             	
                let datos = JSON.parse(response);
                console.log(datos);
                for(let i = 0; i < datos.length; i++){
                 $("#anio").append(`<option value="${datos[i].id}">${datos[i].anio}</option>`)
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


}); 
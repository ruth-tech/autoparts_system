$(document).ready(function() {
    console.log('Nuevo JS esta funcionando');
    // funcion autocompletar
    function autoCompletar() {
        var minimo_letras = 1;//minimo de letras visibles en el input
        var palabra = $('#cliente').val();
        // contamos el valor del input mediante una condicional
        if(palabra.length >= minimo_letras){
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: {palabra:palabra},
                success: function(data){
                    $('#lista_id').show();
                    $('#lista_id').html(data);
                }
            });
        } else {
            // ocultamos la lista
            $('#lista_id').hide();
        }
    }

    // funcion mostrar valores
    function set_item(opciones){
        // cambiar el valor del foprmulario input
        $('#cliente').val(opciones);
        // ocultar la lista de proposiciones
        $('#lista_id').hide();
    }
    // $('#key').on('keyup', function() {
    //     var key = $(this).val();		
    //     var dataString = 'key='+key;
    // $.ajax({
    //         type: "POST",
    //         url: "ajax.php",
    //         data: dataString,
    //         success: function(data) {
    //             //Escribimos las sugerencias que nos manda la consulta
    //             $('#sugerencias').fadeIn(1000).html(data);
    //             //Al hacer click en alguna de las sugerencias
    //             $('.suggest-element').on('click', function(){
    //                     //Obtenemos la id unica de la sugerencia pulsada
    //                     var id = $(this).attr('personaId');
    //                     //Editamos el valor del input con data de la sugerencia pulsada
    //                     $('#key').val($('#'+id).attr('data'));
    //                     //Hacemos desaparecer el resto de sugerencias
    //                     $('#sugerencias').fadeOut(1000);
    //                     $('body').on('click', function() {
    //                         $('#sugerencias').slideUp('slow');
    //                     }); 
    //                     alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
    //                     return false;
    //             });
                                   
    //             // //Hacemos desaparecer el resto de sugerencias
    //             // $('#sugerencias').fadeOut(1000);

    //         }
    //     });
    // });
}); 
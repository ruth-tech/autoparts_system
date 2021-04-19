
$(document).ready(function(){
    console.log('Jquery is working in perfiles');
    let personaid = $("#persoid").attr('personaid');
    console.log(personaid)
    listadatosper();
    

    function listadatosper(){
        $.ajax({
            url:"/autoparts_system/modulos/perfiles/lista.php",
            type:"GET",
            //datatype:"json",//SI DEFINO EL DATATYPE COMO JSON NO HACE FALTA PARSEARLO, PORQUE AJAX YA LO TOMA COMO JSON A LA RESPUESTA
            data:{personaid},
            success: function(response){
                console.log(response)
                let lista = JSON.parse(response);                
                console.log(lista);

                let template = '';

                    lista.forEach(lista =>{
                        template +=
                        `<tr>
                            <td>${lista.persona}</td>
                            <td>${lista.dni}</td>
                            <td>${lista.cuil}</td>
                            <td>${lista.sexo}</td>
                            <td>${lista.fechanac}</td>
                            <td>${lista.nacionalidad}</td>
                            <td><span data-placement="top" title="Editar datos" data-toggle="tooltip"><button type="button" class="editardatosper btn btn-warning" data-toggle="modal" data-target="#editardatospersonales" personaid="${lista.personaid}"><i class="far fa-edit"></i></button></td> 
                                             
                        </tr>`
                    });
                    $("#listadodatosper").html(template);
                
                    
            },
            error: function(xhr,ajaxOptions,thrownError){
                console.log(thrownError);
            }
        });
    }

    //Editar
    $(document).on('click', '.editardatosper', function(){
        
        let element2 = $(this)[0];
        let personaid = $(element2).attr('personaid');

        $.post('datospersonales-edit.php', {personaid}, function(response){
            console.log(response);
           
            const datos = JSON.parse(response);

            $('#personaidedit').val(datos.personaid);
            $('#apellidoedit').val(datos.apellido);
            $('#nombreedit').val(datos.nombre);
            $('#dniedit').val(datos.dni);
            $('#cuiledit').val(datos.cuil);            
            $('#fechaedit').val(datos.fechaNac);
            $('#nacionalidadedit').val(datos.nacionalidad);
        });

        $('#editardatosper').submit(function(e){
            e.preventDefault();
            const postData = {
                personaid: $('#personaidedit').val(),
                apellido: $('#apellidoedit').val(),                
                nombre: $('#nombreedit').val(),
                dni: $('#dniedit').val(),
                cuil: $('#cuiledit').val(),
                fechaNac: $('#fechaedit').val(),
                nacionalidad: $('#nacionalidadedit').val()
    
            };
    
            $.ajax({
                url: 'datospersonales-update.php',
                data: postData,
                type: 'POST',
                success: function(response){
                    Swal.fire(response);
                    console.log(response);
                    listadatosper();
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }
            });
            
            $('#editardatospersonales').modal('hide');

           
        });


    

        
    });
});//fin js

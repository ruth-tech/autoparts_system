<?php
session_start();
    require '../../../php/conexion.php';

    

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    $perfil = $_GET['perfil'];
    $rs_perfil = mysqli_query($conexion,"SELECT * FROM perfiles p inner join perfilxmodulo pxm on p.perfil_id = pxm.rela_perfil inner join modulos m on pxm.rela_modulo = m.modulo_id where p.perfil_id = $perfil");

    $rs_modulos = mysqli_query($conexion,"SELECT modulo_id as id, modulo_descripcion as nombre from modulos");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos</title>
    <?php require '../../../php/head_link.php'; ?>
    <?php require '../../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <!-- <script src="usuarios.js"></script> -->


    
</head>
<body>
    <?php require '../../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="container">

            <div class="card" id="card-main">
                
                <div class="card-header">  
                    <div class="btn-group fa-pull-right">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add-permiso"><i class="fas fa-plus"></i>
                            Agregar permiso
                        </button>

                    </div>                  
                    <h3><i class="fas fa-key"></i> Permisos de accesos</h3>
                </div>
                
               <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Modulos</th>
                            <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row= $rs_perfil->fetch_assoc()):?>
                                <tr>
                                    <td><?php echo $row['modulo_id'];?></td>
                                    <td><?php echo $row['modulo_descripcion'];?></td>
                                    <td><button class='delete btn btn-danger' title='Eliminar permiso' perfil="<?php echo $row['perfil_id'];?>" moduloid="<?php echo $row['modulo_id'];?>"><i class='far fa-trash-alt'></i></button></td>
                                    
                                </tr>
                            <?php endwhile; ?>
                            
                        </tbody>
                    </table>
               </div>
                
            </div> 

            <!-- Modal EDITAR-->
            <div class="modal fade" id="add-permiso" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="add">
                                  
                                <input type="hidden" name="perfil" id="perfil" value="<?php echo $perfil ?>">                   
                                <p>
                                <div class="form-group">
                                <label>Seleccione el modulo que desea permitir al perfil:</label>
                                    <select name="modulo" id="modulo">
                                        <option value="">--SELECCIONE--</option>
                                        <?php 
                                        while ($row = $rs_modulos->fetch_assoc()) {
                                        echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>'  ;
                                        }
                                        ?>
                                    </select>
                                                                      
                                </div>
                                </p>                                                
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div> 
                    <!-- /.modal-content -->
                </div>
               <!-- - /.modal-dialog -->
            </div>
            <!-- /.modal EDITAR -->

        </div>

    
    </div> 
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> -->
    
    <?php require "../../../php/footer.php"; ?>
    <script>

    $(document).ready(function(){

        //Eliminar
        $(document).on('click', '.delete', function(){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });        
            swalWithBootstrapButtons.fire({
                text:'¿Estas seguro que desea quitar este permiso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Quitar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let element = $(this)[0];
                    let perfil = $(element).attr('perfil');
                    let element1 = $(this)[0];
                    let modulo = $(element).attr('moduloid');
                    $.post('/autoparts_system/modulos/seguridad/usuarios/quitar_permiso.php', {perfil:perfil,modulo:modulo}, function(response){
                        console.log(response);
                        swalWithBootstrapButtons.fire(response)
                        location.reload();
                        
                    });
                
                } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
                ) {
                swalWithBootstrapButtons.fire(
                    'Se cancelo exitosamente.'
                )
                }
            });
        });

        //ADD PERMISO DE MODULO AL PERFIL
        $('#add').submit(function(e){
                //usa e.preventDefault() evita la accion del submit
                e.preventDefault()
                const dataAgregar = {
                    perfil: $('#perfil').val(),
                    modulo: $('#modulo').val()                    
                }
            console.log(dataAgregar);
            $.ajax({
                    url: '/autoparts_system/modulos/seguridad/usuarios/add-permisos.php',
                    type: 'POST',
                    data: dataAgregar,
                beforeSend: function (){
                    //opcional
                //antes de enviar puedes colocar un gif cargando o un  mensaje que diga espere...
                }
        
                }).done(function(response){
                    console.log(response);
                    Swal.fire(response);
            
                    // location.reload();
                // Se resetea el formulario luego de haber enviado los datos
                $('#add').trigger('reset');
                }).fail(function(jqXHR, ajaxOptions, thrownError){
                //en caso de que haya un error muestras un mensaje con el error
                console.log(thrownError);
                });
                //Con esta linea se esconde el modal de agregar
                $('#add-permiso').modal('hide');
                
            });

    })
    
    </script>

   
</body>
</html>
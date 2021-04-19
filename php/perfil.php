<?php

    include('conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../index.php?error=debe_loguearse");
        exit;
    }

    $personaId = $_GET['personaId'];

    $sql = "SELECT * FROM personas"
    . " INNER JOIN personas_fisicas ON 
    personas.`persona_id` = personas_fisicas.`rela_persona`"
    . " WHERE personas.`persona_id`=".$personaId;

    $rs = $conexion->query($sql) or die($conexion->error);

    $persona = $rs->fetch_assoc();

    $sql1 = "SELECT * FROM personas"
    . " INNER JOIN persona_contacto ON 
    personas.`persona_id`= persona_contacto.`rela_persona`"
    . "INNER JOIN tipo_contacto ON 
    persona_contacto.`rela_tipo_contacto`=tipo_contacto.`tipo_contacto_id`"
    . " WHERE persona_contacto.`estado`=1 
    AND personas.`persona_id`=".$personaId;

    $rs_con = $conexion->query($sql1) or die($conexion->error);


    $sql2 = "SELECT * FROM personas"
    . " INNER JOIN persona_domicilio ON
    personas.`persona_id`= persona_domicilio.`rela_persona`"
    . "INNER JOIN tipo_domicilios ON 
    persona_domicilio.`rela_tipo_domicilio`=tipo_domicilios.`tipo_domicilio_id`"
    . " WHERE  persona_domicilio.`estado`=1 
    AND personas.`persona_id`= ".$personaId;
    
    $rs_dom = $conexion->query($sql2) or die($conexion->error);
    
?>
<head>
<link rel="stylesheet" href="/autoparts_system/css/perfil.css">
<?php require 'head_link.php';?>
<?php require 'head_script.php';?>


</head>

<body>

    <?php require 'menu.php'; ?>

    <div class="container-fluid">

        <div class="card-body ">            
            <!-- <div class="row d-dlex"> -->
                <div class="row">
                    

                    <div class="col-3">
                    <img src="\autoparts_system\img\img.png" class="card-img-top" alt="Card Img cap" width="50px" height="100px" style="border-radius: 60%;" >
                        <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link btn-outline-danger active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Datos Personales</a>
                            <a class="nav-link btn-outline-danger" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Datos de Contacto</a>
                            <a class="nav-link btn-outline-danger" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Datos de Domicilio</a>
                       
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button type="button" id="editar" class="btn btn-warning " data-toggle="modal" data-target="#editarperfil" personaId="<?php echo $personaId?>" ><i class="far fa-edit"></i>
                                        Editar
                                    </button>
                                </div>
                            </div>                 
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="card border-danger text-dark">
                                    <ul class="list-group list-group-flush" >
                                        <li class="list-group-item"><b>Persona: </b><?php echo $persona['apellidos_persona'].', '.$persona['nombres_persona'];?></li>
                                        <li class="list-group-item"><b>DNI:</b>  <?php echo $persona['persona_dni'];?></li>
                                        <li class="list-group-item"><b>Cuil:</b> <?php echo $persona['persona_cuil'];?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="card border-danger">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th >Tipo Contacto</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row= $rs_con->fetch_assoc()):?>
                                                <tr>
                                                    <td><?php echo $row['tipo_contacto_descripcion'];?></td>
                                                    <td><?php echo $row['valor_contacto'];?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="card border-danger">
                                    <table class="table table-responsive table-hover">
                                        <thead>
                                            <tr>
                                                <th >Tipo Domicilio</th>
                                                <th>Barrio</th>
                                                <th>Calle</th>
                                                <th>Altura</th>
                                                <th>Torre</th>
                                                <th>Piso</th>
                                                <th>Manzana</th>
                                                <th>Sector</th>
                                                <th>Parcela</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row= $rs_dom->fetch_assoc()):?>
                                                <tr>
                                                    <td><?php echo $row['tipo_domicilio_descripcion'];?></td>
                                                    <td><?php echo $row['barrio'];?></td>
                                                    <td><?php echo $row['calle'];?></td>
                                                    <td><?php echo $row['altura'];?></td>
                                                    <td><?php echo $row['torre'];?></td>
                                                    <td><?php echo $row['piso'];?></td>
                                                    <td><?php echo $row['manzana'];?></td>
                                                    <td><?php echo $row['sector'];?></td>
                                                    <td><?php echo $row['parcela'];?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-sm-6 col-md-4 col-lg-4"> 



                    <div class="card lista nav nav-tab" style="width: 18rem;" id="list-tab" role="tablist">
                        <img src="\autoparts_system\img\img.png" class="card-img-top" alt="Card Img cap" width="25px" height="100px" >
                        
                        <ul class="list-group list-group-flush" >
                            <li class="list-group-item list-group-item-dark list-group-item-action active" id="list-personales-list" data-toggle="list" href="#list-personales" role="tab" aria-controls="personales">Datos Personales</li>
                            <li class="list-group-item list-group-item-dark list-group-item-action" id="list-contacto-list" data-toggle="list" href="#list-contacto" role="tab" aria-controls="contacto">Datos de Contacto</li>
                            <li class="list-group-item list-group-item-dark list-group-item-action" id="list-domicilio-list" data-toggle="list" href="#list-domicilio" role="tab" aria-controls="domicilio">Datos de Domicilio</li>
                        </ul>
                        
                    </div> 
                </div>  -->
                
                <!-- <div class="col-sm-6 col-md-8 col-lg-8"> -->
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                 <button type="button" id="editar" class="btn btn-warning " data-toggle="modal" data-target="#editarperfil" personaId="<?php //echo $personaId?>" ><i class="far fa-edit"></i> 
                                    Editar
                                </button>
                            </div>
                        </div>                 
                    </div> -->
                    <!-- <div class="espacio"></div>
                    <div class="tab-content mt-4 datos" id="nav-tabContent">                         -->

                       <!-- <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                             <div class="card border-danger text-dark">
                                <ul class="list-group list-group-flush" >
                                    <li class="list-group-item"><b>Persona: </b><?php //echo $persona['apellidos_persona'].', '.$persona['nombres_persona'];?></li>
                                    <li class="list-group-item"><b>DNI:</b>  <?php //echo $persona['persona_dni'];?></li>
                                    <li class="list-group-item"><b>Cuil:</b> <?php //echo $persona['persona_cuil'];?></li>
                                </ul>
                            </div> 
                        </div>-->

                        <!-- <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                            <div class="card border-danger">

                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th >Tipo Contacto</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php //while($row= $rs_con->fetch_assoc()):?>
                                            <tr>
                                                <td><?php //echo $row['tipo_contacto_descripcion'];?></td>
                                                <td><?php //echo $row['valor_contacto'];?></td>
                                            </tr>
                                        <?php //endwhile; ?>
                                    </tbody>
                                    
                                </table>
                            </div> 
                        </div>-->

                        <!-- <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list"> -->
                            <!-- <div class="card border-danger">


                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th >Tipo Domicilio</th>
                                            <th>Barrio</th>
                                            <th>Calle</th>
                                            <th>Altura</th>
                                            <th>Torre</th>
                                            <th>Piso</th>
                                            <th>Manzana</th>
                                            <th>Sector</th>
                                            <th>Parcela</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php //while($row= $rs_dom->fetch_assoc()):?>
                                            <tr>
                                                <td><?php //echo $row['tipo_domicilio_descripcion'];?></td>
                                                <td><?php //echo $row['barrio'];?></td>
                                                <td><?php //echo $row['calle'];?></td>
                                                <td><?php //echo $row['altura'];?></td>
                                                <td><?php //echo $row['torre'];?></td>
                                                <td><?php// echo $row['piso'];?></td>
                                                <td><?php //echo $row['manzana'];?></td>
                                                <td><?php //echo $row['sector'];?></td>
                                                <td><?php //echo $row['parcela'];?></td>
                                            </tr>
                                        <?php //endwhile; ?>
                                    </tbody>
                                    
                                </table>
                            </div> 
                        </div>-->
                        
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->

            <!-- MODAL EDITAR PERFIL - PERSONALES--> 
            <div class="modal fade" id="editarperfil" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editarperfil">
                                <h3>Modificar datos en el perfil de <?php echo $persona['apellidos_persona'].', '.$persona['nombres_persona'];?> </h3>

                                <input type="hidden" id="personaidedit" personaid="<?php echo $personaId?>">
                                <p>
                                    <h5><b>Datos Personales</b></h5>
                                <div class="form-group">
                                    <label>Nombre: </label>
                                    <input type="text" id="nombreedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Apellido </label>
                                    <input type="text" id="apellidoedit"  >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>DNI:</label>
                                    <input type="text" id="dniedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Cuil:</label>
                                    <input type="text" id="cuiledit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                
                                <!-- <p>Genero:
                                <div class="form-group">
                                    <label><input type="radio" id="sexoedit" value="femenino"> Mujer </label>
                                    <label><input type="radio" id="sexoedit" value="masculino"> Hombre </label>
                                    <label><input type="radio" id="sexoedit" value="otro"> Otro </label><br>
                                    
                                </div>                            
                                </p> -->
                                
                                
                                <p>
                                <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                    <input type="date" id="fchNacedit"  >
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidadedit" >
                                    
                                </div>
                                    
                                
                    
                                <p>
                                    <h5><b>Datos CONTACTO</b></h5>
                                <div class="form-group">
                                    <label>Tipo Contacto: </label>
                                    <input type="text" id="tipocontactoedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Valor Contacto</label>
                                    <input type="text" id="valorcontactoedit"  >
                                    </label>
                                    
                                </div>
                                    
                               
                                
                           
                                <p>
                                    <h5><b>Datos DOMICILIO</b></h5>
                                <div class="form-group">
                                    <label>Tipo domicilio: </label>
                                    <input type="text" id="tipodomicilioedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Barrio: </label>
                                    <input type="text" id="barrioedit"  >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Calle:</label>
                                    <input type="text" id="calleedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Altura:</label>
                                    <input type="text" id="alturaedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                
                                <p>
                                <div class="form-group">
                                <label>Torre: </label>
                                    <input type="date" id="torreedit"  >
                                    
                                </div>
                                    
                                </p>
                                
                                <p>
                                <div class="form-group">
                                <label>Piso: </label>
                                    <input type="date" id="pisoedit"  >
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Manzana</label>
                                    <input type="text" id="manzanaedit" >
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Sector</label>
                                    <input type="text" id="sectoredit"  >
                                </div>
                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Parcela</label>
                                    <input type="text" id="parcelaedit"  >
                                </div>
                                
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal EDITAR -->

        </div>

    </div>
    

    <script>
        console.log('Jquery is working')
        $(document).on('click', '#editar', function () {
            let element = $(this)[0];
            let personaId = $(element).attr('personaId');

            $.post('../modulos/Clientes/cliente-edit.php', {personaId}, function(response){
               console.log(JSON.parse(response))
            
                let datos = JSON.parse(response);
               
                
                $('*personaidedit').val(datos.personaid);
                $('#nombreedit').val(datos.nombre);
                $('#apellidoedit').val(datos.apellido);
                $('#dniedit').val(datos.dni);
                $('#cuiledit').val(datos.cuil);
                // $('#sexoedit').val(datos.sexo);
                $('#fchNacedit').val(datos.fchNac);
                $('#nacionalidadedit').val(datos.nacionalidad);
                $('#tipocontactoedit').val(datos.tipo_contacto_descripcion);
                $('#valorcontactoedit').val(datos.valor_contacto);
                $('#tipodomicilioedit').val(datos.tipo_domiclio_descripcion);
                $('#barrioedit').val(datos.barrio);
                $('#calleedit').val(datos.calle);
                $('#alturaedit').val(datos.altura);
                $('#torreedit').val(datos.torre);
                $('#pisoedit').val(datos.piso);
                $('#manzanaedit').val(datos.manzana);
                $('#sectoredit').val(datos.sector);
                $('#parcelaedit').val(datos.parcela);
                });
            


        });

    </script>
   
   <?php require 'footer.php'; ?>      
</body>

</html>
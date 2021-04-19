<?php

    include('conexion.php');

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../index.php?error=debe_loguearse");
        exit;
    }

    $personaId = $_GET['personaId'];  
    $clienteId = $_GET['clienteId'];

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
<link rel="stylesheet" href="/autoparts_system/bootstrap-4.5.0/css/bootstrap.min.css">

    <style>
 .pic{
    border-radius: 50%;
    width: 170px;
    height:160px;
 }

 .espacio{
     height:95px;
 }
.lista{
    width: 470px;
}
.datos{
    width:800px;
}

    </style>
</head>

<body>

    <?php require 'menu.php'; ?> 

    <div class="container-fluid">

        <div class="card-body ">            

            
            <div class="row d-dlex justify-content-center">    
                <div class="col-md-3">
                    
                    <div class="list-group lista" id="list-tab" role="tablist">

                        <div class="img-perfil text-center">
                            <img class="card-img-top border-danger pic" src="\autoparts_system\img\img.png" alt="Card image cap" width="25px" height="100px">
                        </div>
                       
                        <a class="list-group-item list-group-item-dark list-group-item-action border-danger active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Datos Personales</a>
                        <a class="list-group-item list-group-item-dark list-group-item-action border-danger" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Datos de contacto</a>
                        <a class="list-group-item list-group-item-dark list-group-item-action border-danger" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Datos de domicilio</a>
                       
                    </div>
                </div>
                <div class="mr-3"></div>
                <div class=" col-md-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <button type="button" id="editar" class="btn btn-warning " data-toggle="modal" data-target="#editarPerfil" personaId="<?php echo $personaId?>" ><i class="far fa-edit"></i>
                                    Editar
                                </button>
                            </div>
                        </div>                 
                    </div>
                    <div class="espacio"></div>
                    <div class="tab-content mt-4 datos" id="nav-tabContent">
                        

                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                            <div class="card border-danger text-dark">
                                <ul class="list-group list-group-flush" >
                                    <li class="list-group-item"><b>Persona: </b><?php echo $persona['apellidos_persona'].', '.$persona['nombres_persona'];?></li>
                                    <li class="list-group-item"><b>DNI:</b>  <?php echo $persona['persona_dni'];?></li>
                                    <li class="list-group-item"><b>Cuil:</b> <?php echo $persona['persona_cuil'];?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
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

                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
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
                        <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">...</div>
                    </div>
                </div>
            </div>

            <!-- MODAL EDITAR PERFIL -->
            <div class="modal fade" id="editarPerfil" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editar">
                                <h3>Modificar datos en el perfil de <?php echo $persona['apellidos_persona'].', '.$persona['nombres_persona'];?> </h3>

                                <input type="hidden" id="<?php echo $personaId?>">
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
                                
                                <p>Genero:
                                <div class="form-group">
                                    <label><input type="radio" id="sexoedit" value="femenino"> Mujer </label>
                                    <label><input type="radio" id="sexoedit" value="masculino"> Hombre </label>
                                    <label><input type="radio" id="sexoedit" value="otro"> Otro </label><br>
                                    
                                </div>                            
                                </p>
                                
                                
                                <p>
                                <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                    <input type="date" id="fchNacedit"  >
                                    </label>
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidadedit" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Nro. de cuenta</label>
                                    <input type="text" id="nro_cuentaedit"  >
                                    </label>
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
    <script src="/autoparts_system/js/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        console.log('Jquery is working')
        $(document).on('click', '#editar', function () {
            let element = $(this)[0];
            let personaId = $(element).attr('personaId');

            console.log(personaId);
            


        });

    </script>
   
    <?php include('footer.php'); ?>    
</body>
</html>
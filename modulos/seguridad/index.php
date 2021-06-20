<?php 

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../index.php?error=debe_loguearse");
        exit;
    }


    $sql = "SELECT 
    persona_id AS id, 
    CONCAT(apellidos_persona,' ',nombres_persona) AS nombre, 
    persona_dni AS dni 
    FROM empleados e
    INNER JOIN personas_fisicas pf ON e.rela_persona_fisica = pf.persona_fisica_id
    INNER JOIN personas p ON p.persona_id = pf.rela_persona
    WHERE e.estado = 1";
    $empleado = mysqli_query($conexion,$sql);

    $sql1 = "SELECT perfil_id AS id, perfil_descripcion AS nombre FROM perfiles";
    $perfil = mysqli_query($conexion,$sql1);

    $sql2 = "SELECT modulo_id as id, modulo_descripcion as nombre from modulos";
    $modulos = mysqli_query($conexion,$sql2);

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\empleados.css"> -->
    <!-- <script src="js/seguridad.js"></script> -->
    
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                <h3>Seguridad</h3>
                
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Usuarios</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Perfiles</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Otros</a>
                </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php include 'usuarios/index.php'; ?>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php include 'perfiles/index.php'; ?>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">otra info</div>
                </div>
            </div>

            <!-- Modal ASIGNAR USUARIO-->
            <div class="modal fade" id="nuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingresar los datos correspondientes</h3>
                                <p>
                                <div class="form-group">
                                    <label>Seleccionar un empleado:</label>
                                    <select name="empleado" id="empleado">
                                        <option value="">--SELECCIONE--</option>
                                        <?php 
                                        while ($row = $empleado->fetch_assoc()) {
                                        echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].' - '.$row['dni'].'</option>'  ;
                                        }

                                        ?>
                                    </select>
                                </div>                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Seleccionar el perfil:</label>
                                    <select name="perfil" id="perfil">
                                        <option value="">--SELECCIONE--</option>
                                        <?php 
                                        while ($row = $perfil->fetch_assoc()) {
                                        echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>'  ;
                                        }

                                        ?>
                                    </select>
                                </div>                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Establecer nombre de Usuario:</label>
                                    <span data-placement="top" title="Debe contener al menos 4 caracteres" data-toggle="tooltip"><p><input type="text" id="usuario" placeholder="" min="4" max="20"></span></p>
                                </div>                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Establecer contraseña de Usuario:</label>
                                    <span data-placement="top" title="Debe contener al menos 4 caracteres" data-toggle="tooltip"><p><input type="password" id="pass" placeholder="" min="4" max="20"></span></p>
                                    </label>
                                </div>                                
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div> 
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal ASIGNAR USUARIO-->

                    

            <!-- Modal EDITAR-->
            <div class="modal fade" id="editarPass" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="editar">
                            <strong><h3>Modificar Datos de Usuarios </h3></strong>
                                
                                <p>
                                <div class="form-group">
                                <label>Usuario:</label>
                                    <input type="text" name="usuario" id="usuario-edit"></input>                                   
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Contraseña:</label>
                                    <input type="password" name="pass" id="pass-edit"></input>                                   
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

            <!-- Modal ADD PERFIL-->
            <div class="modal fade" id="add-perfil" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body text-dark">
                            <form role="form" method="post" id="add">
                            <strong><h3>Agregar nuevo Perfil </h3></strong>
                                
                                <p>
                                <div class="form-group">
                                <label>Nombre:</label>
                                    <input type="text" name="nombre" id="nombre"></input>                                   
                                </div>
                                </p>   
                                <p>
                                <div class="form-group">
                                <label>Seleccione un permiso para agregar a este perfil:</label>
                                    <select name="modulo" id="modulo">
                                        <option value="">--SELECCIONE--</option>
                                        <?php 
                                        while ($row = $modulos->fetch_assoc()) {
                                        echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>'  ;
                                        }
                                        ?>
                                    </select>                                   
                                </div>
                                </p>                              
                                
                                <button type="submit" class="btn btn-danger  fa-pull-right">Agregar</button>

                            </form>
                        </div>

                    </div> 
                    <!-- /.modal-content -->
                </div>
               <!-- - /.modal-dialog -->
            </div>
            <!-- /.modal add perfil -->


        </div>


        <?php require "../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
<?php 

    require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../index.php?error=debe_loguearse");
        exit;
    }

    // $sql = "SELECT * FROM persona_sexo";
    // $sexo = mysqli_query($conexion,$sql)or die($conexion->error);

    // $sql1 = "SELECT * FROM perfiles";
    // $cargo = mysqli_query($conexion,$sql1)or die($conexion->error);

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoluciones</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\empleados.css"> -->
    <!-- <script src="js/seguridad.js"></script> -->
    
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                <h3>Devoluciones</h3>
                
            </div>
            <!-- Modal AGREGAR -->
            <!-- <div class="modal fade" id="nuevoEmpleado" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese los datos personales del Empleado</h3>
                                <p>
                                <div class="form-group">
                                    <label>Nombre: </label>
                                    <input type="text" id="nombre" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>    
                                <p>
                                <div class="form-group">
                                <label>Apellido </label>
                                    <input type="text" id="apellido" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>DNI:</label>
                                    <input type="text" id="dni" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Cuil:</label>
                                    <input type="text" id="cuil" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                
                                <p>
                                <div class="form-group">
                                <label>Genero:</label>
                                <select name="sexo" id="sexo">
                                    <option value="">--SELECCIONE--</option>
                                    <?php 
                                    // while ($row = $sexo->fetch_assoc()) {
                                    // echo '<option VALUE="'.$row['id_sexo'].'">'.$row['descripcion_sexo'].'</option>'  ;
                                    // }

                                    ?>
                                </select>
                                    
                                </div>                            
                                </p>
                                
                                
                                <p>
                                <div class="form-group">
                                <label>Fecha de Nacimiento</label>
                                    <input type="date" id="fchNac" placeholder="
                                    AAAA/MM/DD">
                                    </label>
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidad" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <h3>Ingresar datos propios del empleado</h3> 
                                <p>
                                <div class="form-group">
                                <label>Cargo:</label> 
                                <select name="cargo" id="cargo">
                                    <option value="">--SELECCIONE--</option>
                                    <?php 
                                    // while ($row = $cargo->fetch_assoc()) {
                                    // echo '<option VALUE="'.$row['perfil_id'].'">'.$row['perfil_descripcion'].'</option>'  ;
                                    // }

                                    ?>
                                </select>
                                    
                                </div>                            
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Establecer nombre de Usuario:</label>
                                    <span data-placement="top" title="Debe contener al menos 4 caracteres" data-toggle="tooltip"><p><input type="text" id="nombreuser" placeholder="" min="4" max="20"></span></p>
                                </div>                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Establecer contraseña de Usuario:</label>
                                    <span data-placement="top" title="Debe contener al menos 4 caracteres" data-toggle="tooltip"><p><input type="password" id="passworduser" placeholder="" min="4" max="20"></span></p>
                                    </label>
                                </div>                                
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div> -->

                    <!-- </div>/.modal-content -->
                <!-- </div> /.modal-dialog -->
            <!-- </div>/.modal AGREGAR -->

            

            <!-- Modal EDITAR-->
            <!-- <div class="modal fade" id="editarEmpleado" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="editar-empleado">
                            <strong><h3>Modificar datos del Empleado </h3></strong>
                                    <div class="card border-danger" >
                                        <div class="card-body text-danger">
                                            <h5 class="card-title text-center"><i class="fas fa-exclamation-triangle"></i>Advertencia<i class="fas fa-exclamation-triangle"></i></h5>
                                            <p class="card-text">¡Los datos personales se deben editar accediendo al perfil!</p>
                                        </div>
                                    </div>
                                <input type="hidden" id="empleadoidedit" >
                                <input type="hidden" id="personaidedit" >
                                <p>
                                <div class="form-group">
                                <label>Fecha Alta:</label>
                                    <input type="date" name="fechaaltaedit" id="fechaaltaedit"></input>                                   
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Cargo:</label>
                                    <select name="cargo" id="cargoedit" ></select>                                    
                                </div>
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div> -->

                    <!-- </div> /.modal-content -->
              <!-- </div> - /.modal-dialog -->
            <!-- </div>/.modal EDITAR -->


        </div>


        <?php require "../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
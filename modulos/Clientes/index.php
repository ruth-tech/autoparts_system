<?php 

    require '../../php/conexion.php'; 

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $sql = "SELECT * FROM persona_sexo";
    $sexo = mysqli_query($conexion,$sql);

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <link rel="stylesheet" href="\autoparts_system\css\clientes.css">
    <script src="js/clientes.js"></script>
    
</head>
<body>

    

    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nuevoCliente"><i class="fas fa-plus"></i>
                        Agregar
                    </button>

                </div>
                <h3>Clientes</h3>
            </div>

                <div class="card-body"> 

                    <table class="table table-striped " id="listado-clientes" >
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Cliente</td>
                                <td>Cuil</td>
                                <td>Cuenta</td>
                                <td>Informacion</td>
                                <td>Acciones</td>
                            </tr>

                        </thead>
                        <!-- <tbody id="listadoClientes"> -->

                        </tbody>
                    </table>

                </div>
                
            
            <!-- Modal AGREGAR -->
            <div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese los datos del cliente</h3>
                                <p>
                                <div class="form-group">
                                    <label>Escriba su nombre: </label>
                                    <input type="text" id="nombre" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>    
                                <p>
                                <div class="form-group">
                                <label>Escriba su apellido </label>
                                    <input type="text" id="apellido" style="text-transform:uppercase;">
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Escriba su DNI:</label>
                                    <input type="text" id="dni" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                 <p>
                                <div class="form-group">
                                    <label>Escriba su Cuil:</label>
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
                                    while ($row = $sexo->fetch_assoc()) {
                                    echo '<option VALUE="'.$row['id_sexo'].'">'.$row['descripcion_sexo'].'</option>'  ;
                                    }

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
                                <p>
                                <div class="form-group">
                                    <label>Nro. de cuenta</label>
                                    <input type="text" id="nro_cuenta" >
                                    </label>
                                </div>
                                
                                </p> 
                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal AGREGAR-->

            

            <!-- Modal EDITAR CLIENTES-->
           <div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editarCliente">
                            <strong><h3>Modificar datos del cliente </h3></strong>
                                    <div class="card border-danger" >
                                        <div class="card-body text-danger">
                                            <h5 class="card-title text-center"><i class="fas fa-exclamation-triangle"></i>Advertencia<i class="fas fa-exclamation-triangle"></i></h5>
                                            <p class="card-text">¡Los datos personales se deben editar accediendo al perfil de la persona!</p>
                                        </div>
                                    </div>
                                <p>
                                <input type="hidden" id="personaidedit" >
                                <input type="hidden" id="clienteidedit" >
                                
                                <p>
                                <div class="form-group">
                                <label>Fecha alta cliente</label>
                                    <input type="date" id="fechaaltaclienteedit" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Cuenta Num</label>
                                    <input type="text" id="nrocuentaedit" >
                                    
                                </div>
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal EDITAR -->


        </div>


<?php require "../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
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
    <title>Productos-Categoria</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\empleados.css"> -->
    <script src="js/categoriasproductos.js"></script>
    
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nuevaCategoria"><i class="fas fa-plus"></i>
                        Agregar
                    </button>

                </div>
                <h3>Productos-Categoria</h3>
                <div class="card-body">

                    <table class="table table-striped " id="listado-categorias" >
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Descripcion</td>
                                <td>Vehiculos</td>
                                <td>ACCIONES</td>
                            </tr>

                        </thead>
                        <tbody id="listadoCategorias">

                        </tbody>
                    </table>

                </div>
                
            </div>
            <!-- Modal AGREGAR -->
             <div class="modal fade" id="nuevaCategoria" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese la Nueva Categoria</h3>
                                <p>
                                    <div class="form-group">
                                        <label>Descripcion: </label>
                                        <input type="text" id="descripcion" style="text-transform:uppercase">                        
                                    </div>                                    
                                </p>    
                                                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div> 

                    </div><!-- /.modal-content -->
                 </div><!--  /.modal-dialog -->
            </div><!-- /.modal AGREGAR -->

            

            <!-- Modal EDITAR-->
            <div class="modal fade" id="editarCategoria" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="editar-categoria">
                            <strong><h3>Modificar Categoria </h3></strong>
                                   
                                <input type="hidden" id="categoriaidedit" >
                                <p>
                                <div class="form-group">
                                <label>Descripcion:</label>
                                    <input type="text" id="descripcionedit"></input>                                   
                                </div>
                                </p>
                                                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- - /.modal-dialog -->
            </div><!--/.modal EDITAR -->


        </div>


        <?php require "../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
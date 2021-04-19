<?php

require '../../../../php/conexion.php';

$categoriaid=$_GET['categoriaid'];
$vehiculoid = $_GET['vehiculoid'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos-Modelos</title>
    <?php require '../../../../php/head_link.php'; ?>
    <?php require '../../../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\empleados.css"> -->
    <script src="modelos.js"></script>
    
</head>
<body>    

    <?php require '../../../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nuevoVehiculo"><i class="fas fa-plus"></i>
                        Agregar
                    </button>

                </div>
                <h3>Vehiculos-Modelos</h3>
                <div class="card-body">
                <input type="hidden" id="categoria" categoriaid="<?php  echo $categoriaid; ?>">
                <input type="hidden" id="vehiculo" vehiculoid="<?php  echo $vehiculoid; ?>">
                    <table class="table table-striped " id="listado-modelos" >
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Modelo</td>
                                <td>Productos</td>
                                <td>ACCIONES</td>
                            </tr>

                        </thead>
                        <tbody id="listadoModelos">

                        </tbody>
                    </table>

                </div>
                
            </div>
            <!-- Modal AGREGAR -->
             <div class="modal fade" id="nuevoVehiculo" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese datos del nuevo vehiculo</h3>
                                <input type="hidden" id="categoria-add" value="<?php  echo $categoriaid; ?>">
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
            <div class="modal fade" id="editarVehiculo" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="editar-vehiculo">
                            <strong><h3>Modificar vehiculo </h3></strong>
                                   
                                <input type="hidden" id="categoriaidedit" >
                                <input type="hidden" id="vehiculoidedit" >
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


        <?php require "../../../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
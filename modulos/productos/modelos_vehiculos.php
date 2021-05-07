<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location:../../index.php?error=debe_loguearse");
      exit;
    }

    // $idvehiculo = $_POST['vehiculoid'];
    $marcaid = $_GET['marcaid'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelos vehiculos</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>

    <!-- <link rel="stylesheet" href="\autoparts_system\css\marcas.css"> -->
    <script src="vehiculos.js"></script>
   

<?php 

?>
    
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nuevoModelo"><i class="fas fa-plus"></i>
                            Agregar
                    </button>
                    

                </div>
                <h3>Modelos de la Marca</h3>                             
            </div>
            <div class="card-body">
            <input type="hidden" id="marca" marcaid="<?php echo $marcaid?>">
            <table class="table table-striped" id="listado-modelos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Categorias-Productos</th>
                    </tr>
                </thead>

            </table>

            <!-- Modal AGREGAR -->
            <div class="modal fade" id="nuevoModelo" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body text-dark">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese los datos del Modelo</h3>
                                
                                <p>
                                    <div class="form-group">
                                        <label>Nombre o descripcion: </label>
                                        <input type="text" id="descripcion" style="text-transform:uppercase">                        
                                    </div>                                    
                                </p>   
                                <p>
                                    <div class="form-group">
                                        <label>Año: </label>
                                        <input type="text" id="anio" style="text-transform:uppercase" placeholder="Ej: 97-99">                        
                                    </div>                                    
                                </p> 
                                                          
                                <button type="submit" id="agregar"class="btn btn-danger">Agregar</button>

                            </form>
                        </div> 

                    </div><!-- /.modal-content -->
                 </div><!--  /.modal-dialog -->
            </div><!-- /.modal AGREGAR -->
            
               
            </div>
        </div>
        <?php require "../../php/footer.php"; ?>
    </div> 
</html>
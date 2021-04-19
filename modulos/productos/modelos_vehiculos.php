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
                        <th>Productos</th>
                    </tr>
                </thead>

            </table>
            
               
            </div>
        </div>
        <?php require "../../php/footer.php"; ?>
    </div> 
</html>
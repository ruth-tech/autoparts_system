<?php 
require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../index.php?error=debe_loguearse");
    exit;
}
// include '../../php/menu.php' 
?>
<!DOCTYPE html> 
<html lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pedidos</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?> 
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <script src="pedidos.js"></script>
    

<body>
<?php include '../../php/menu.php' ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                <div class="btn-group fa-pull-right">
                <button type="button" class="btn btn-danger" data-toggle="popover" title="" data-content="test content <a href='#' title='test add link'>link on content</a>" data-original-title="test title"><i class="fas fa-plus"></i>Agregar</button>
                    <!-- <button type="button" class="agregar_pedido btn btn-danger" ><a class="text-white" href="nuevo.php"><i class="fas fa-plus"></i>
                        Agregar</a>
                    </button> -->

                </div>
                <h3>Pedidos</h3>
            </div>

            <?php require 'todos/index.php';?>
                           
                        

           

        </div>


<?php require "../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
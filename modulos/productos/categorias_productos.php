<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location:../../index.php?error=debe_loguearse");
      exit;
    }    
    $modeloid = $_GET['modeloid']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias-Productos</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\marcas.css"> -->
    <script src="categorias.js"></script>
   

<?php 

?>
    
</head>
<body>    

  <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="btn-group fa-pull-right">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#agregarCategoria"><i class="fas fa-plus"></i>
                    Agregar
            </button>
                  

          </div>
          <h3>Categorias-Productos</h3>                             
        </div>
        <div class="card-body">

          <input type="hidden" id="modelo" modeloid="<?php echo $modeloid; ?>">
          <table class="table table-striped" id="listado-categoriasProductos">
            <thead>
              <th>ID</th>
              <th>Categoria</th>
              <th>Descripcion</th>
              <th>Acciones</th>
            </thead>
            <tbody></tbody>
          </table>
            
          <!-- Modal AGREGAR -->
          <div class="modal fade" id="agregarCategoria" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body text-dark">
                  <form role="form" method="post" id="agregar">
                    <h3>Seleccione una o mas categorias que desea agregar a este modelo</h3>

                    <div class="checkbox">
                      <label><input type="checkbox" name="check_lista[]" value="C++">C++</label>
                    </div>
                    <div class="checkbox"> 
                      <label><input type="checkbox" name="check_lista[]" value="Java">Java</label>
                    </div>
                    <div class="checkbox">
                      <label><input type="checkbox" name="check_lista[]" value="PHP7">PHP 7</label>
                    </div> 
                    <div class="checkbox">
                      <label><input type="checkbox" name="check_lista[]" value="HTML5/CSS">HTML5/CSS</label>
                    </div> 
                    <div class="checkbox">
                      <label><input type="checkbox" name="check_lista[]" value="JavaScript/jQuery">JavaScript/jQuery</label>
                    </div> 
                                            
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
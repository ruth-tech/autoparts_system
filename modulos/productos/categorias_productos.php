<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location:../../index.php?error=debe_loguearse");
      exit;
    }    
    $modeloid = $_GET['modeloid'];

    $sql = "SELECT * FROM categorias";
    $rs_cat= mysqli_query($conexion,$sql);

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

    <style>
      .checkbox input,.checkbox label{
        display:inline-block;
        vertical-align:middle;	
      }
      .checkbox label{margin-right:20px;}

    </style>  
 
</head>
<body>    

  <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="btn-group fa-pull-right">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#asignarCategoria"><i class="fas fa-sign-in-alt"></i>
                    Asignar Categorias
            </button>
            |
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
          <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="asignarCategoria">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Seleccione una o mas categorias que desea agregar a este modelo</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body text-dark">
                  <form  role="form" method="post" id="asignarCategoria" > <!--action="/autoparts_system/modulos\productos\categorias_abm\categorias_asigned.php"-->            
                    <?php while ($row = $rs_cat->fetch_assoc()) : ?>      
                        
                    <label class="checkbox-inline" >
                      <input type="checkbox" name="check_lista[]" value="<?php echo $row['prod_categoria_id'];?>"> <?php echo $row['prod_categoria_descripcion'];?>
                    </label>
                    <?php endwhile; ?> 
                    <br>
                     
                    <div class="btn-group fa-pull-right">
                      <button type="submit" class="btn btn-danger">Agregar
                      </button>
                    </div>                         
                    
                  </form>
                </div> 

              </div><!-- /.modal-content -->
            </div><!--  /.modal-dialog -->
          </div><!-- /.modal AGREGAR -->        
                                                

        </div>
      </div>
      <?php require "../../php/footer.php"; ?>
      <!-- <script>
      $(document).ready(function(){
         $('#submit').click(function(e){
            // e.preventDefault();
            var selected = '';    
            $('#asignarCategoria input[type=checkbox]').each(function(){
                if (this.checked) {
                    selected += $(this).val()+', ';
                }
            }); 
    
            if (selected != '') 
                alert('Has seleccionado: '+selected);  
            else
                alert('Debes seleccionar al menos una opción.');
    
            return false;
        });
      });
      </script> -->
    </div> 
</html>
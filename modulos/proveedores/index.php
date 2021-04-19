<?php 
   require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    // $sql = "SELECT * FROM persona_sexo";
    // $sexo = mysqli_query($conexion,$sql);

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Proveedores</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <link rel="stylesheet" href="\autoparts_system\css\proveedores.css">
    <script src="js/proveedores.js"></script>
    
</head>
<body>   

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nuevoProveedor"><i class="fas fa-plus"></i>
                        Agregar
                    </button>

                </div>
                <h3>Proveedores</h3>
            </div>

                <div class="card-body">

                    <table class="table table-striped " id="listadoProveedores" >
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Razon Social</td>
                                <td>Cuit</td>
                                <td>Categoria</td>
                                <td>Web-site Oficial</td>
                                <td>Informacion</td>
                                <td>Acciones</td>
                            </tr>

                        </thead>
                        <!-- <tbody id="listadoProveedores">

                        </tbody> -->
                    </table>

                </div>
                
            
            <!-- Modal AGREGAR -->
            <div class="modal fade" id="nuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="agregar">
                                <h3>Ingrese los datos del Proveedor</h3>
                                <p>
                                <div class="form-group">
                                    <label>Cuit: </label>
                                    <input type="text" id="cuit">
                                    </label>
                                    
                                </div>
                                    
                                </p>    
                                <p>
                                <div class="form-group">
                                <label>Razon Social</label>
                                    <input type="text" id="razonsocial" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Categoria:</label>
                                    <input type="text" id="categoria" >
                                    </label>
                                    
                                </div>                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>N° habilitacion:</label>
                                    <input type="text" id="nrohabilitacion" >
                                    </label>
                                    
                                </div>                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Web-site oficial:</label>
                                    <input type="text" id="website" >
                                    </label>
                                    
                                </div>                                    
                                </p>
                                
                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div> 

                    </div> <!--/.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal AGREGAR-->

            

            <!-- Modal EDITAR CLIENTES-->
           <div class="modal fade" id="editarProveedor" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editar-proveedor">
                            <strong><h3>Modificar datos del Proveedor </h3></strong>
                                    <div class="card border-danger" >
                                        <div class="card-body text-danger">
                                            <h5 class="card-title text-center"><i class="fas fa-exclamation-triangle"></i>Advertencia<i class="fas fa-exclamation-triangle"></i></h5>
                                            <p class="card-text">¡Los datos personales se deben editar accediendo al perfil!</p>
                                        </div>
                                    </div>
                                <p>
                                
                                <input type="hidden" id="proveedoridedit" >
                                
                                <p>
                                <div class="form-group">
                                <label>Fecha alta Proveedor:</label>
                                    <input type="date" id="fechaaltaproveedoredit" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Website Oficial:</label>
                                    <input type="text" id="websiteedit" >
                                    
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Categoria:</label>
                                    <input type="text" id="categoriaedit" >
                                    
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
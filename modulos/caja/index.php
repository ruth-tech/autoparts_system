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

    $sql1 = "SELECT tipo_pago_id as id, tipo_pago_descripcion as nombre FROM tipo_pago";
    $tipo_pago = mysqli_query($conexion,$sql1)or die($conexion->error);

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <script src="caja.js"></script>
    
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <div class="card" id="card-main">
            <div class="card-header">
                <div class="btn-group fa-pull-right">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#gasto_ingreso"><i class="fas fa-dollar-sign"></i>
                        Generar Gasto/Ingreso
                    </button>   
                    
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#abrirCaja"><i class="fas fa-plus"></i>
                        Iniciar caja
                    </button>  
                    

                </div>
                <h3>Caja</h3>
                
            </div>
            <div class="card-body"> 

                    <table class="table table-striped " id="listado-caja" >
                        <thead>
                            <tr>
                                
                                <td>Fecha Inicio</td>
                                <td>Monto Inicial</td>
                                <td>Monto total</td>
                                <td>Fecha cierre</td>
                                <td>Estado</td>
                                <td>Cerrar caja</td>
                                <td>Resumen de caja</td>
                            </tr>

                        </thead>
                        <!-- <tbody id="listadoClientes"> -->

                        </tbody>
                    </table>

                </div>
           
            <!-- Modal GENERAR GASTO/INGRESO-->
            <div class="modal fade" id="gasto_ingreso" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="gas_ingre">
                            <strong><h3>Ingresar los datos correspondientes </h3></strong>
                                   
                                <p>
                                <div class="form-group">
                                <label>Fecha</label>
                                    <input type="datetime" name="fecha" id="fecha" value='<?php echo date("Y-m-d H:i:s"); ?>'></input>                                   
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Seleccione:</label>
                                    <select name="tipo" id="tipo">
                                        <option value="">--SELECCIONE--</option>
                                        <option value="1">INGRESO</option>
                                        <option value="2">GASTO</option>
                                    </select>                                  
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Tipo de pago:</label>
                                <select name="tipo_pago" id="tipo_pago">
                                    <option value="">--SELECCIONE--</option>
                                    <?php 
                                    while ($row = $tipo_pago->fetch_assoc()) {
                                    echo '<option VALUE="'.$row['id'].'">'.$row['nombre'].'</option>'  ;
                                    }

                                    ?>
                                </select>
                                    
                                </div>                            
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Ingrese el monto:</label>
                                    <input type="number" name="monto" id="monto">                                   
                                </div>
                                </p>
                                
                                <button type="submit" class="btn btn-danger fa-pull-right">Generar gasto/ingreso</button>

                            </form>
                        </div> 

                     </div> 
                     <!-- /.modal-content -->
                </div>  
                <!-- - /.modal-dialog -->
            </div> 
            <!-- /.modal INICIAR CAJA -->

            

            <!-- Modal ABRIR CAJA-->
            <div class="modal fade" id="abrirCaja" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        <div class="modal-body">
                            <form role="form" method="post" id="abrir_caja">
                            <strong><h3>Ingresar los datos correspondientes </h3></strong>
                                   
                                <p>
                                <div class="form-group">
                                <label>Fecha</label>
                                    <input type="datetime" name="fecha" id="fecha" value='<?php echo date("Y-m-d H:i:s"); ?>'></input>                                   
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Ingrese el monto inicial:</label>
                                    <input type="number" name="inicial" id="inicial">                                   
                                </div>
                                </p>
                                
                                <button type="submit" class="btn btn-danger fa-pull-right">Iniciar Caja</button>

                            </form>
                        </div> 

                     </div> 
                     <!-- /.modal-content -->
                </div>  
                <!-- - /.modal-dialog -->
            </div> 
            <!-- /.modal INICIAR CAJA -->


        </div>


        <?php require "../../php/footer.php"; ?>
    </div> 

    
</body>
</html>
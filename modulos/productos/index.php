<?php

    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location: ../../index.php?error=debe_loguearse");
      exit;
    }


    // echo $sql1;
    // // exit;

    //     $rs_vehiculos =$conexion->query($sql1) or die($conexion->error);
    //     header('Content-Type: text/html; charset=UTF-8');  

   


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcas</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <link rel="stylesheet" href="\autoparts_system\css\marcas.css">


    <!-- <script src="vehiculos.js"></script> -->
    <script src="\autoparts_system\js\jquery-redirect.js"></script>
    <script src="marcas_vehiculos.js"></script>
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">

        <!-- <div class="card" id="card-main"> -->
            <!-- <div class="card-header"> -->
               <!-- <div class="container"> -->

               <div class="card">
                    <strong><h3 class="card-header">Marcas</h3></strong>
                    <div class="card-body">
                        <h5 class="card-title">Seleccione la marca del vehiculo solicitado:</h5>
                           
                        <table class="table table-striped" id="listado-vehiculos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripcion</th>
                                    <th>imagen</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- <span data-toggle="tooltip" data-placement="top" title="ZAZ"><a id="86" href="#"><img class="marcasautos" src="/autoparts_system/img/marcas/zaz.jpg" alt="Autopartes: ZAZ" width="100" height="100"></a></span> -->
                        
                    </div>
                </div>
               
            

            


        <?php require "../../php/footer.php"; ?>
    </div> 
<script>
    //  // clickear la marca solicitada
    // $(document).ready(function(){
    //     $(document).on('click','.marcasautos', function(e){
    //         e.preventDefault();
    //         var href = '/autoparts_system/modulos/productos/modelos_vehiculos.php';
    //         let element = $(this)[0].parentElement;
    //         let marcaid = $(element).attr('id');

    //         console.log(marcaid)
    //         if(marcaid){
    //             var direccion = href+'?marcaid='+marcaid;
    //             window.open(direccion,"_self");
    //         }

            
            
    //     });
    // })
</script>
    
</body>
</html>
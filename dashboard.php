<?php
  //  if(!isset($_SESSION)) 
  //  { 
       session_start(); 
  // //  }
  
  // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
  if (!isset($_SESSION["logueado"])) {
    header("location: ../index.php?error=debe_loguearse");
    exit;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Inicio</title>
  <link rel="stylesheet" href="css\dashboard.css">
  <?php require 'php/head_link.php';?>
  <?php require 'php/head_script.php';?>
	
</head>
<body>
  <div class="container-fluid">

    <div class="row">
      <?php require 'php/menu.php'; ?>
    </div>
    <!-- ----
    <div class="row">
                <div class="col-md-12">
                    <div id="subida">
                        <form action="subirData" method="post">
                            <div class="form-row"><!-- agregar esto -->
                                <!-- <div class="col-md-6"> -->
                                    <!--//PRIMERA COLUMNA -->
                                    <!--  -->
                                          <!-- <div class="col-sm-6">
                                          
                                              <div class="card-body">
                                                <canvas id="mychart" ></canvas> 
                                              </div>
                                          </div>

                                          <div class="col-sm-6">
                                          <div class="card">
                                      <div class="form-group form-row"> agregar esto -->
                                       
                                            <!-- <div class="card-body">
                                            <canvas id="mychart4" ></canvas> 
                                            </div>
                                          </div>         
                                      
                                          
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-6"> -->
                                    <!--//SEGUNDA COLUMNA -->
                                    <!-- <div class="form-group form-row">agregar esto -->
                                        <!-- <label for="" class="col-sm-4 col-form-label">Fecha de Ingreso</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control fechaIngreso" name="fechaIngreso">
                                        </div>
                                    </div>
                                    <div class="form-group form-row"> <!-- agregar esto -->
                                        <!-- <label for="" class="col-sm-4 col-form-label">Placa</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control placa" name="placa">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input id="submit-all" type="submit" value="Subir" />
                        </form>
                    </div>
                </div>
            </div> -->
    <div class="graficos ">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-6 col-xl-6">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-6">
              <div class="card" >
                <div class="card-body">
                  <canvas id="mychart" ></canvas> 
                </div>
              </div>

            </div>
            <div class="col-12 col-md-12 col-lg-12 col-xl-6">
              <div class="card" >
                <div class="card-body">
                  <canvas id="mychart4" ></canvas> 
                </div>
              </div>

            </div>
          </div>
          
        </div>
        <div class="col-12 col-md-12 col-lg-6 col-xl-6">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-6 ">
              <div class="card" >
                <div class="card-body">
                  <canvas id="mychart2" ></canvas>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12 col-xl-6">
              <div class="card" >
                <div class="card-body">
                  <canvas id="mychart3" ></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
    
    
    
      <?php 		
          require 'php/footer.php';
      ?>
    
    
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>

  <script type="text/javascript" src="estadisticas/grafico.js"></script>
  <script type="text/javascript" src="estadisticas/grafico2.js"></script>
  <script type="text/javascript" src="estadisticas/grafico3.js"></script>
  <script type="text/javascript" src="estadisticas/grafico4.js"></script>

</body>

</html>


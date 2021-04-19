<?php

require '../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../index.php?error=debe_loguearse");
        exit;
    }

    $personaid = $_GET['personaId'];

   

?>
<head>
<link rel="stylesheet" href="/autoparts_system/css/perfil.css">
<?php require '../../php/head_link.php';?>
<?php require '../../php/head_script.php';?>
<script src="perfil.js"></script>



</head>

<body>

    <?php require '../../php/menu.php'; ?>

    <div class="container-fluid">

        <div class="card" id="card-perfil">            
            
            <div class="row" >
                <div class="col-12 col-lg-4 col-xl-4" >
                    
                    <div class="card-header" id="headerperfil">   
                        <img src="\autoparts_system\img\img.png" class="img-user card-img-top" alt="Card Img cap" width="50px" height="100px" style="border-radius: 50%;" >                        

                        <ul class="nav nav-tabs card-header-tabs">
                            
                            <li class="nav-item">
                                <a class="nav-link btn-outline-danger active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true" href="#">Datos Personales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-outline-danger" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false" href="#">Datos de contacto<span id="agregarcon" data-placement="top" title="Agregar contacto" data-toggle="tooltip"><button type="button"  class="btn btn-outline-success" data-toggle="modal" data-target="#agregarcontacto" personaid="<?php echo $personaid?>"><i class="fas fa-plus"></i></button>
                                </span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-outline-danger" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false" href="#">Datos de domicilio<span id="agregardom" data-placement="top" title="Agregar domicilio" data-toggle="tooltip"><button type="button"  class="domicilio-add btn btn-outline-success" data-toggle="modal" data-target="#agregardomicilio" personaid="<?php echo $personaid?>"><i class="fas fa-plus"></i></button>
                                </span></a>
                            </li>
                        </ul>
                         

                    </div>
                            
                                                
                </div> 
                    
                <div class="col-12 col-lg-8 col-xl-8">
                    <div class="card-body">                                 

                        <div class="tab-content" id="v-pills-tabContent">
                          
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="card ">
                                    <?php require 'datospersonales-juridicas.php'?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="card ">

                                    <?php require '../contactos/index.php'?>

                                </div> 
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="card ">

                                <?php require '../domicilios/index.php'?>
                                    
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                
                    
            </div>
        </div>
    

       

         
    <?php require '../../php/footer.php '; ?>  
    </div>     
</body>

</html>

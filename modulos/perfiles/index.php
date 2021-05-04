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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head-datatables-link.php';?>
    <?php require '../../php/head_script.php'; ?>
    <?php require '../../php/head-datatables-script.php';?>
    <link rel="stylesheet" href="/autoparts_system/css/perfil.css">
<!-- <script src="perfil-personal.js"></script> -->
</head>
<body>
<?php require '../../php/menu.php'; ?>

<div class="container">
    <div class="card-perfil">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                    Datos personales
                </a>
                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                    Datos de contacto
                    <span id="agregarcon" data-placement="top" title="Agregar contacto" data-toggle="tooltip"><button type="button"  class="btn btn-outline-success" data-toggle="modal" data-target="#agregarcontacto" personaid="<?php echo $personaid?>"><i class="fas fa-plus"></i></button>
                    </span>
                </a>
                <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                    Datos de domicilio
                    <span id="agregardom" data-placement="top" title="Agregar domicilio" data-toggle="tooltip"><button type="button"  class="domicilio-add btn btn-outline-success" data-toggle="modal" data-target="#agregardomicilio" personaid="<?php echo $personaid?>"><i class="fas fa-plus"></i></button>
                    </span>
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="card">
                    <?php require 'datospersonales.php'?>
                </div>                
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="card">
                    <?php require '../contactos/index.php'?>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="card">
                    <?php require '../domicilios/index.php'?>
                </div>
            </div>
        </div>

    </div>
    

    <?php require '../../php/footer.php '; ?>  
</div>     
</body>
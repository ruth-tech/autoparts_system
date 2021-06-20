<?php
session_start();
    require '../../../php/conexion.php';

    

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }

    $usuario = $_GET['usuarioId'];
    $rs_usuario = mysqli_query($conexion,"SELECT * FROM historial_usuarios hu inner join usuarios u on hu.rela_usuario = u.usuario_id inner join personas p on u.rela_persona = p.persona_id inner join personas_fisicas pf on p.persona_id = pf.rela_persona where u.usuario_id = $usuario");
    // $tipo_fac = mysqli_fetch_assoc($query);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de sesiones</title>
    <?php require '../../../php/head_link.php'; ?>
    <?php require '../../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\clientes.css"> -->
    <!-- <script src="nuevo.js"></script> -->

    
</head>
<body>
    <?php require '../../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="container">

            <div class="card" id="card-main">
                <div class="card-header">                    
                    <h3><i class="fas fa-history"></i> Historial de sesiones</h3>
                </div>
                
               <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Fecha inicio</th>
                            <th scope="col">Fecha fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row= $rs_usuario->fetch_assoc()):?>
                                <tr>
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['usuario_nombre'];?></td>
                                    <td><?php echo $row['fecha_inicio'];?></td>
                                    <td><?php echo $row['fecha_fin'];?></td>
                                </tr>
                            <?php endwhile; ?>
                            
                        </tbody>
                    </table>
               </div>
                
            </div> 

        </div>

    
    </div> 
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> -->
    
    <?php require "../../../php/footer.php"; ?>

   
</body>
</html>
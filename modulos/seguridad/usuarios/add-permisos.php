<?php

    require '../../../php/conexion.php';

    session_start();

    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
        header("location: ../../../index.php?error=debe_loguearse");
        exit;
    }
    $perfil = $_POST['perfil'];
    $modulo = $_POST['modulo'];

        if (siExiste($perfil,$modulo,$conexion) == 1) {
            echo "Este Perfil ya tiene acceso al modulo selecionado!";   
            exit;         
        }else {
            $query = "INSERT into perfilxmodulo(rela_perfil,rela_modulo) VALUES($perfil,$modulo)";

            $result = mysqli_query($conexion,$query);

            if(!$result){
                die('¡No se ha logrado agregar el registro a la base de datos!');
            }

        
            echo "¡Registro agregado exitosamente!";
            exit;
        }

        function siExiste($perfil,$modulo,$conexion){
            $sql = "SELECT * FROM perfilxmodulo where rela_perfil = $perfil AND rela_modulo = $modulo";
            $res = mysqli_query($conexion,$sql);
            if (mysqli_num_rows($res) > 0) {
                return 1;
            }else{
                return 0;
            }
        }

        
    


?>
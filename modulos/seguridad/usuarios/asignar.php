<?php
// print_r($_REQUEST);exit;

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../../index.php?error=debe_loguearse");
    exit;
}
$persona = $_POST['persona'];
$usuario = $_POST['usuario'];
$pass = $_POST['pass'];
$perfil = $_POST['perfil'];  

if (siExiste($persona,$conexion) == 1) {
    echo "El empleado ya tiene un usuario activo asociado!";
    exit;
}else {
    // GUARDO Usuario
    
    $sql1 = "INSERT INTO usuarios(rela_persona,usuario_nombre,usuario_password,rela_perfil)VALUES($persona,'$usuario','$pass',$perfil)";

    $res = mysqli_query($conexion,$sql1) or die($conexion->error);

    echo '¡Registro agregado exitosamente!';
    exit;
}
    
function siExiste($per,$conexion){
    $sql = "SELECT * from usuarios where estado = 1 and rela_persona = $per";
    $res = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($res) > 0) {
        return 1;
    }else{
        return 0;
    }
}

?>
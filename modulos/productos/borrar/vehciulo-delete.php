
<?php

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../../index.php?error=debe_loguearse");
    exit;
}


    $idcategoria = $_POST['idcategoria'];
    $idvehiculo = $_POST['idvehiculo'];

    $query = "UPDATE categoriaxvehiculo "
    ." SET estado = 0 WHERE rela_vehiculo= ". $idvehiculo
    ." AND rela_prod_categoria=".$idcategoria;

    $result = mysqli_query($conexion,$query);

    if(!$result){
        die('¡No se ha logrado eliminar el registro de la base de datos!');
    }

   
    echo "¡Registro eliminado exitosamente!";



?>
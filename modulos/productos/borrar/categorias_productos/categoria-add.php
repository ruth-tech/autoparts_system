<?php 

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../index.php?error=debe_loguearse");
    exit;
}

  
        $descripcion = strtoupper($_POST['descripcion']);
        
        // cuando agrego nueva persona estado = 1
        $estado = 1;


        // GUARDO CLIENTE
        $sql3 = "INSERT INTO prod_categorias(`prod_categoria_descripcion`,`estado`)"
            . " VALUES ('$descripcion',$estado)";
// echo $sql3;
// exit;
        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql3)) {
            echo '!Ha ocurrido un error en la carga a la base de datos!';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }


        echo '¡Registro agregado exitosamente!';
        //$mensaje = 'GUARDAR_CLIENTE_OK';
        
        //header("location: ../listado.php?mensaje=$mensaje");
  
?>
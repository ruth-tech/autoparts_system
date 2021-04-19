<?php 

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../../index.php?error=debe_loguearse");
    exit;
}

    // if(isset($_POST['nombre'])){
        $categoria = $_POST['categoria'];
        $modelo = $_POST['modelo'];
        $descripcion = strtoupper($_POST['descripcion']);
        $fabricante = strtoupper($_POST['fabricante']);
        $cantidad = $_POST['cantidad'];
        $precioproveedor = $_POST['precioproveedor'];
        $precioventa = $_POST['precioventa'];
        $detalles = strtoupper($_POST['detalles']);
         
        // echo $nombre.', '.$apellido.', '.$dni;

        // cuando agrego nueva persona estado = 1
        $estado = 1;
        $fechaIngreso = date('Y-m-d');

        // // GUARDO PERSONA
        $sql1 = "INSERT INTO productos"
            . " (`producto_descripcion`,`producto_fecha_ingreso`,`producto_detalle_fabricante`,`producto_cantidad`)"
            . " VALUES ('".$descripcion."','".$fechaIngreso."','".$fabricante."',".$cantidad.")";
    
        
        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql1)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla productos!';
            exit();
            //$mensaje = 'GUARDAR_PERSONA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }

        $productoid = mysqli_insert_id($conexion);



        $sql2 = " INSERT INTO producto_precio" 
        . " (`rela_producto`,`precio_fecha`,`precio_proveedor`,`precio_venta`)"
        . " VALUES (".$productoid.",'".$fechaIngreso."',".$precioproveedor.",".$precioventa.")";
        // echo $sql2;
        // exit;
        //$rs_persona = $conexion->query($sql2) or die($conexion->error);

        if (!mysqli_query($conexion, $sql2)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla de precios!';
            exit();
            //$mensaje = 'GUARDAR_PERSONA_FISICA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }

        
        $sql3 = "INSERT INTO producto_detalles (`rela_producto`,`producto_detalle_descripcion`)"
            . " VALUES (".$productoid.",'".$detalles."')";

            // echo $sql3;
            // exit;

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql3)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla de detalles de productos!';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }

        $sql4 = "INSERT INTO productoxcategoriaxmodelo(`rela_producto`,`rela_prod_categoria`,`rela_modelo`,`cantidad_actual`,`estado`)"
        . " VALUES (".$productoid.",".$categoria.",".$modelo.",".$cantidad.",".$estado.")";

        // echo $sql4;
        // exit;

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql4)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla relacional de Producto, Categoria y Modelo de vehiculo!';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }


        echo '¡Registro agregado exitosamente!';
        //$mensaje = 'GUARDAR_CLIENTE_OK';
        
        //header("location: ../listado.php?mensaje=$mensaje");
    // }else{
    //     echo 'no estan definidas las variables';
    // };

?>
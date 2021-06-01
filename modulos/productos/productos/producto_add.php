<?php 

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../../index.php?error=debe_loguearse");
    exit;
}

    // if(isset($_POST['nombre'])){
        $categoriaxmodelo = $_POST['categoriaxmodelo'];
        $descripcion = strtoupper($_POST['descripcion']);
        $fabricante = strtoupper($_POST['fabricante']);
        $cantidad = $_POST['cantidad'];
        $precioventa = $_POST['precioventa'];
        $detalles = strtoupper($_POST['detalles']);
         
        // echo $nombre.', '.$apellido.', '.$dni;

        // cuando agrego nueva persona estado = 1
        $estado = 1;
        //
        $fechaIngreso = date('Y-m-d h:i:s');
        // echo $fechaIngreso;
        // exit();

        // // GUARDO PRODUCTO
        $sql1 = "INSERT INTO productos"
            . " (`producto_descripcion`,`producto_fecha_ingreso`,`producto_detalle_fabricante`)"
            . " VALUES ('".$descripcion."','".$fechaIngreso."','".$fabricante."')";
    
        
        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql1)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla productos!';
            exit();
            //$mensaje = 'GUARDAR_PERSONA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }

        $productoid = mysqli_insert_id($conexion);



        $sql2 = " INSERT INTO producto_precio" 
        . " (`rela_producto`,`precio_fecha`,`precio_venta`)"
        . " VALUES (".$productoid.",'".$fechaIngreso."',".$precioventa.")";
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

        $sql5 = "INSERT INTO producto_stock (`rela_producto`,`stock_fecha`,`stock`)"
            . " VALUES (".$productoid.",'".$fechaIngreso."',".$cantidad.")";

            // echo $sql3;
            // exit;

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql5)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla stock de productos!';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }

        $sql4 = "INSERT INTO productoxcategoriaxmodelo(`rela_producto`,`rela_categoriaxmodelo`,`estado`)"
        . " VALUES (".$productoid.",".$categoriaxmodelo.",".$estado.")";

        // echo $sql4;
        // exit;

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql4)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla relacional de Producto, Categoria y Modelo de vehiculo!';
            exit();
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
        }
        //EJEUTO LA LLAMADA AL PROCEDIMIENTO QUE GUARDA LA EXITENCIA INICIAL
        $sql5 = "CALL proc_existencia_productos(".$productoid.",".$cantidad.",".$precioventa.")";

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (!mysqli_query($conexion, $sql5)) {
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla de existencia!';
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
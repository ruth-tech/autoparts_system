<?php 

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../index.php?error=debe_loguearse");
    exit;
}

  
        $razonsocial = strtoupper($_POST['razonsocial']);
        
        $nrohabilitacion = $_POST['nrohabilitacion'];
        $cuit = $_POST['cuit'];
        $website = strtoupper($_POST['website']);
       
        // cuando agrego nueva persona estado = 1
        $estado = 1;

        // GUARDO PERSONA
        $sql1 = "INSERT INTO personas(persona_id)"
            . " VALUES ('')";
    
        
        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (mysqli_query($conexion, $sql1)) {
            //$mensaje = 'GUARDAR_PERSONA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
            
        }else{
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla personas!';
            exit();
        }

        $id_persona = mysqli_insert_id($conexion);



        $sql2 = " INSERT INTO personas_juridicas" 
        . " (`rela_persona`,`cuit`,`razon_social`,`nro_habilitacion`)"
        . " VALUES ($id_persona,'$cuit','$razonsocial',$nrohabilitacion) ";

        //$rs_persona = $conexion->query($sql2) or die($conexion->error);

        if (mysqli_query($conexion, $sql2)) {
            //$mensaje = 'GUARDAR_PERSONA_FISICA_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
            
        }else{
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla personas juridicas!';
            exit();
        }



        // obtengo el id insertado en personas
        $id_persona_juridica = mysqli_insert_id($conexion);

        // obtengo fecha/hora actual
        $fecha_alta = date('Y-m-d'); 

        // GUARDO CLIENTE
        $sql3 = "INSERT INTO proveedores(`rela_persona_juridica`,`proveedor_fecha_alta`,`proveedor_website`,`estado`)"
            . " VALUES ($id_persona_juridica,'$fecha_alta','$website',$estado)";

        // si no puedo guardar, redirecciono al listado con mensaje de error
        if (mysqli_query($conexion, $sql3)) {
            //$mensaje = 'GUARDAR_CLIENTE_ERROR';
            //header("location: ../listado.php?mensaje=$mensaje");
            
        }else{
            echo '!Ha ocurrido un error en la carga a la base de datos respecto a la tabla proveedores!';
            exit();
        }

        echo '¡Registro agregado exitosamente!';
        //$mensaje = 'GUARDAR_CLIENTE_OK';
        
        //header("location: ../listado.php?mensaje=$mensaje");
    
?> 
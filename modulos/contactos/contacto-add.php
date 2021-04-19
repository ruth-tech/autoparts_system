<?php 

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../index.php?error=debe_loguearse");
    exit;
}

    
        $personaid=$_POST['personaid'];
        $relatipocontacto = $_POST['tipocontacto'];
        $valor = $_POST['valor'];
        
        // cuando agrego nueva estado = 1
        $estado = 1;

        // GUARDO CONTACTO
        $sql3 = "INSERT INTO persona_contacto(`rela_persona`,`rela_tipo_contacto`,`valor_contacto`,`estado`)"
        . " VALUES($personaid,$relatipocontacto,'$valor',$estado)";
            
            $result = mysqli_query($conexion,$sql3);

            if(!$result){
                die('!Ha ocurrido un error en la carga a la base de datos!');
            }


            echo '¡Registro agregado exitosamente!';
       
?>
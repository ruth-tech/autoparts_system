<?php 

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
    header("location: ../../index.php?error=debe_loguearse");
    exit;
}

    $personaid=$_POST['personaid'];
    $tipodomicilio=$_POST['tipodomicilio'];
    $localidad=$_POST['localidad'];
    $barrio=$_POST['barrio'];
    $calle1=$_POST['calle'];
    $altura1=$_POST['altura'];
    $torre1 = $_POST['torre'];
    $piso1 =$_POST['piso'];
    $manzana1 =$_POST['manzana'];
    $sector1 =$_POST['sector'];
    $parcela1 = $_POST['parcela'];
    $calle = (!empty($calle1))   ?  "'$calle1'" : "NULL" ;
    $altura = (!empty($altura1))   ?  "$altura1"  : "NULL" ;
    $torre = (!empty($torre1))   ? "'$torre1'"  : "NULL" ;
    $piso = (!empty($piso1))   ? "'$piso1'"  : "NULL" ;
    $manzana = (!empty($manzana1))   ? "'$manzana1'"   : "NULL" ;
    $sector = (!empty($sector1))   ?  "'$sector1'" : "NULL" ;
    $parcela = (!empty($parcela1))   ?  "'$parcela1'"  : "NULL" ;
    
   
        // cuando agrego nueva estado = 1
        $estado = 1;

        // GUARDO DOMICILIO
        $sql3 = "INSERT INTO persona_domicilio(`rela_persona`,`rela_tipo_domicilio`,`rela_localidad`,`barrio`,`calle`,`altura`,`piso`,`torre`,`manzana`,`sector`,`parcela`,`estado`)"
        . " VALUES($personaid,$tipodomicilio,$localidad,'$barrio',$calle,$altura,$piso,$torre,$manzana,$sector,$parcela,$estado)";

        // echo $sql3;
        // exit();
            
            $result = mysqli_query($conexion,$sql3);

            if(!$result){
                echo '!Ha ocurrido un error en la carga a la base de datos!';
            }


            echo '¡Registro agregado exitosamente!';
       
?>
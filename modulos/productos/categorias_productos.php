<?php
    require '../../php/conexion.php';

    session_start();
      
    // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
    if (!isset($_SESSION["logueado"])) {
      header("location:../../index.php?error=debe_loguearse");
      exit;
    }

    // $idvehiculo = $_POST['vehiculoid'];
    $modeloid = $_GET['modeloid'];

    // echo $modeloid;
    // exit();

    $sql1 = "SELECT * FROM categoriaxmodelo"
    ." INNER JOIN categorias ON categoriaxmodelo.rela_categoria = categorias.prod_categoria_id"
    ." WHERE rela_modelo =".$modeloid
    ." ORDER BY prod_categoria_descripcion ASC";

    // echo $sql1;
    // exit;

        $rs_categoria =$conexion->query($sql1) or die($conexion->error);
        header('Content-Type: text/html; charset=UTF-8');   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias-Productos</title>
    <?php require '../../php/head_link.php'; ?>
    <?php require '../../php/head_script.php'; ?>
    <!-- <link rel="stylesheet" href="\autoparts_system\css\marcas.css"> -->
    <!-- <script src="vehiculos.js"></script> -->
   

<?php 

?>
    
</head>
<body>    

    <?php require '../../php/menu.php'; ?>
    
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Categorias-Productos</h3>                             
            </div>
            <div class="card-body disabled">
            
                <p>
                <?php while($row = $rs_categoria->fetch_assoc()):?>
               
                <?php switch($row['prod_categoria_descripcion']){
								case 'ACCESORIOS':
									$img="\autoparts_system\img\productos-img\accesorios.png";
                                break;
                                case 'ALMA DE CHASIS':
									$img="\autoparts_system\img\productos-img\alma_de_chasis.jpg";
                                break;
                                case 'AMORTIGUADORES':
                                    $img="\autoparts_system\img\productos-img\amortiguadores.jpg";
                                break;
                                case 'BATERIAS':
                                    $img="\autoparts_system\img\productos-img\baterias.jpg";
								break;
								case 'BOCINAS':
									$img="\autoparts_system\img\productos-img\bocinas.jpg";
                                break;
                                case 'BUJES':
									$img="\autoparts_system\img\productos-img\bujes.jpg";
                                break;
                                case 'BUTACAS':
									$img="\autoparts_system\img\productos-img\butacas.jpg";
                                break;
                                case 'CAMPANAS':
									$img="\autoparts_system\img\productos-img\campanas de freno.jpg";
                                break;
                                case 'CAPOT':
									$img="\autoparts_system\img\productos-img\capot.jpg";
                                break;
                                case 'CERRADURAS':
									$img="\autoparts_system\img\productos-img\cerraduras.jpg";
                                break;
                                case 'CORREAS':
									$img="\autoparts_system\img\productos-img\correas.png";
                                break;
                                case 'CRISTALES':
									$img="\autoparts_system\img\productos-img\cristales.jpg";
                                break;
                                case 'DISCOS DE FRENO':
									$img="\autoparts_system\img\productos-img\discos_de_freno.jpg";
                                break;
                                case 'EMBRAGUES':
									$img="/autoparts_system/img/productos-img/embragues.jpg";
                                break;
                                case 'ESCOBILLAS':
									$img="/autoparts_system/img/productos-img/escobillas.jpg";
                                break;
                                case 'ESPEJOS':
									$img="/autoparts_system/img/productos-img/espejos.jpg";
                                break;
                                case 'ESPIRALES':
									$img="/autoparts_system/img/productos-img/espirales.jpg";
                                break;
                                case 'FAROS':
									$img="\autoparts_system\img\productos-img/faros.jpg";
                                break;
                                
                                case 'FILTROS':
                                    $img="\autoparts_system\img\productos-img/filtros.jpg";
                                break;
                                case 'FUELLES':
									$img="\autoparts_system\img\productos-img/fuelles.jpg";
                                break;
                                case 'FUSIBLES':
									$img="\autoparts_system\img\productos-img/fusibles.jpg";
                                break;
                                case 'GUARDABARROS':
									$img="\autoparts_system\img\productos-img\guardabarros.jpg";
                                break;
                                case 'GUARDAPLAST':
									$img="\autoparts_system\img\productos-img\guardaplast.jpg";
                                break;
                                case 'HOMOCINETICAS':
									$img="\autoparts_system\img\productos-img\homocinetica.jpg";
                                break;
                                case 'LEVANTA CRISTALES':
									$img="\autoparts_system\img\productos-img\levanta_cristales.jpg";
                                break;
                                case 'LUNETAS':
									$img="\autoparts_system\img\productos-img\lunetas.jpg";
                                break;
                                case 'MANIJAS':
									$img="\autoparts_system\img\productos-img\manijas.jpg";
                                break;
                                case 'PANEL DE CONTROL':
									$img="\autoparts_system\img\productos-img\panel de control.jpg";
                                break;
                                case 'PANELES DE PUERTAS':
									$img="\autoparts_system\img\productos-img\paneles de puerta.jpg";
                                break;
                                case 'PARABRISAS':
									$img="\autoparts_system\img\productos-img\PARABRISAS.jpg";
                                break;
                                case 'PARAGOLPES':
									$img="\autoparts_system\img\productos-img\paragolpes.jpg";
                                break;
                                case 'PARRILLAS':
									$img="\autoparts_system\img\productos-img\parrillas.jpg";
                                break;
                                case 'PASTILLAS DE FRENO':
									$img="\autoparts_system\img\productos-img\pastillas de freno.jpg";
                                break;
                                case 'PUERTAS':
									$img="\autoparts_system\img\productos-img\puerta.jpg";
                                break;
                                case 'ROTULAS Y EXTREMOS':
									$img="\autoparts_system\img\productos-img\rotulas y extremos.jpg";
                                break;
                                case 'TAZAS':
									$img="\autoparts_system\img\productos-img/tazas.jpg";
                                break;
                                case 'TERMINALES':
									$img="\autoparts_system\img\productos-img/terminales.jpg";
                                break;
                                
							};?>
                <div class="card d-inline-block m-2" style="width: 15rem; ">
                    <img class="card-img-top" src="<?php echo $img;?>" alt="Card image cap" width="100" height="100">
                    <div class="card-body">
                        
                        <h5 class="card-title" ><?php echo utf8_encode($row['prod_categoria_descripcion']);?></h5>
                        <p class="card-text"  ><?php echo utf8_encode($row['texto_descripcion']);?></p>
                        <a href="productos/index.php?categoriaid=<?php echo $row['prod_categoria_id'];?>&modeloid=<?php echo $row['rela_modelo']?>" class="btn btn-outline-danger">Ver productos</a>
                    </div>
                </div>
                <?php endwhile; ?>
                </p>
                
                                                

            </div>
        </div>
        <?php require "../../php/footer.php"; ?>
    </div> 
</html>
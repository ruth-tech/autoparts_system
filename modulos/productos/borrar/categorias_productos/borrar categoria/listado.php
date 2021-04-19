<?php

include '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

if (isset($_GET['mensaje'])) {
	switch ($_GET['mensaje']) {
        case 'GUARDAR_CATEGORIA_OK':
            $mensaje = 'Categoria agregada correctamente.';
            break;
          case 'MODIFICAR_CATEGORIA_OK':
            $mensaje = 'Categoria modificada correctamente.';
            break;

        case 'CATEGORIA_ESTADO_UPDATE_OK':
            $mensaje = 'Categoria eliminada correctamente.';
            break;
            
        case 'CATEGORIA_ESTADO_UPDATE_ERROR':
            $mensaje = 'No se pudo dar de baja la categoria, intentelo nuevamente.';
            break;

         case 'NO_EXISTE_CATEGORIA':
         	$mensaje = 'La categoria que desea modificar no existe.';
         	break;

    	case 'GUARDAR_CATEGORIA_ERROR':
      		$mensaje = 'Ha ocurrido un error al intentar crear la categoria.';
      		break;

    	

    }
}



// Consultamos en la tabla Empleados y Personas
$sql = "SELECT * FROM prod_categorias where estado=1 order by prod_categoria_descripcion asc";

//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);



?>

<!DOCTYPE html>
<html>
<head>
	<title>Categorias-Productos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="\autoparts_system\bootstrap-4.5.0\css\bootstrap.min.css">
    
</head>
<body>

	

	<?php if (isset($mensaje)): ?>
			<h3><font color="red"><?php echo $mensaje; ?></font></h3>
	<?php endif; ?>
	
		
	<?php require '../../php/menu.php'; ?> 


	
	<div class="container-fluid">	
		
	
				

			<h1><b>Listado de categorias</b></h1>
				<a href="alta_categoria.php">Nueva categoria</a>
				<a href="buscar_categoria.php">Buscar</a>
				
		<div class="table-responsive">

			<table class="table">
					<thead class="thead">
						<tr>
							<th>ID</th>
							<th>Descripcion Categoria</th>
							<th>Vehiculos</th>
							<th>ACCIONES</th>
						</tr>
					</thead>

					<tbody>
							<?php while ($row = $rs->fetch_assoc()): ?>
								<tr>
									<td> <?php echo $row['prod_categoria_id']; ?> </td>
									<td> <?php echo utf8_encode($row['prod_categoria_descripcion']); ?> </td>
									<td> <a href="vehiculos/listado.php?prod_categoria_id=<?php echo $row['prod_categoria_id']; ?>">Ver</a></td>
									<td>
										<a href="editar.php?prod_categoria_id=<?php echo $row['prod_categoria_id']; ?>">
											Editar
										</a> | 
										<a onclick="return confirm('¿Estas seguro que desea dar de baja esta categoria?')" href="procesar_baja.php?prod_categoria_id=<?php echo $row['prod_categoria_id']; ?>">
											Eliminar
										</a>
									</td>
								</tr>
							<?php endwhile; ?>
					</tbody>
				</table>

		</div>
			
	</div>
			

					

								

							
	<!-- cdn jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

	<script src="\autoparts_system\bootstrap-4.5.0\js\jquery-3.5.1.min.js"></script>
	
	<script src="\autoparts_system\bootstrap-4.5.0\js\bootstrap.min.js"></script>
							
	<script src="categorias_prod.js" ></script>					


</body>

</html>
<?php

require '../../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../index.php?error=debe_loguearse");
	exit;
}

if (isset($_GET['mensaje'])) {
 	switch ($_GET['mensaje']) {
         case 'GUARDAR_MODELO_OK':
             $mensaje = 'Modelo agregado correctamente.';
             break;
           case 'MODIFICAR_MODELO_OK':
             $mensaje = 'Modelo modificado correctamente.';
             break;

       case 'MODELO_ESTADO_UPDATE_OK':
            $mensaje = 'Modelo eliminado correctamente.';
             break;
            
        case 'MODELO_ESTADO_UPDATE_ERROR':
             $mensaje = 'No se pudo dar de baja el Modelo, intentelo nuevamente.';
             break;

        case 'NO_EXISTE_MODELO':
          	$mensaje = 'El Modelo que desea modificar no existe.';
          	break;

     	case 'GUARDAR_MODELO_ERROR':
       		$mensaje = 'Ha ocurrido un error al intentar crear el Modelo.';
       		break;

    	

    }
}

$prod_categoria_id = $_GET['prod_categoria_id'];
$vehiculo_id = $_GET['vehiculo_id'];

// Consultamos en la tabla Empleados y Personas
$sql = "SELECT * FROM modelos_vehiculos"
	." where estado=1 and rela_vehiculo=". $vehiculo_id;



//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);






?>

<!DOCTYPE html>
<html>
<head>
	<title>Modelo de vehiculos</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Modelos de Vehiculos</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
		<?php endif; ?>
		
		

		<p><a href="alta_modelo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">Agregar nuevo modelo</a></p>
		<p><a href="buscar_modelo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">Buscar</a></p>
		<p><a href="../.../../../dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Descripcion modelo</th>
					<th>Productos</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>
					<tr>
						<td> <?php echo $row['modelo_vehiculo_id']; ?> </td>
						<td> <?php echo utf8_encode($row['modelo_vehiculo_descripcion']); ?> </td>
						<td> <a href="productos/listado.php?prod_categoria_id=<?php echo $prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>&modelo_vehiculo_id=<?php echo $row['modelo_vehiculo_id']; ?>">Ver</a></td>
						<td>
							<a href="editar.php?prod_categoria_id=<?php echo $prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>&modelo_vehiculo_id=<?php echo $row['modelo_vehiculo_id']; ?>">
							    Editar
							</a> | 
							<a onclick="return confirm('¿Estas seguro que desea dar de baja este modelo?')" href="procesar_baja.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>&modelo_vehiculo_id=<?php echo $row['modelo_vehiculo_id']; ?>">
							    Eliminar
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>

	</div>
</body>
</html>
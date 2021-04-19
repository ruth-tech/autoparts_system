<?php

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

 if (isset($_GET['mensaje'])) {
 	switch ($_GET['mensaje']) {
        case 'GUARDAR_VEHICULO_OK':
             $mensaje = 'Vehiculo agregado correctamente.';
            break;
           case 'MODIFICAR_VEHICULO_OK':
            $mensaje = 'Vehiculo modificado correctamente.';
             break;

         case 'VEHICULO_ESTADO_UPDATE_OK':
             $mensaje = 'Vehiculo eliminado correctamente.';
            break;
            
         case 'VEHICULO_ESTADO_UPDATE_ERROR':
             $mensaje = 'No se pudo dar de baja el vehiculo, intentelo nuevamente.';
             break;

          case 'NO_EXISTE_VEHICULO':
          	$mensaje = 'El vehiculo que desea modificar no existe.';
          	break;

     	case 'GUARDAR_VEHICULO_ERROR':
       		$mensaje = 'Ha ocurrido un error al intentar crear el vehiculo.';
       		break;

    	

    }
 }

$prod_categoria_id= $_GET['prod_categoria_id'];

// Consultamos en la tabla Empleados y Personas
$sql = "SELECT * FROM categoriaxvehiculo 
inner join prod_categorias on prod_categorias.prod_categoria_id=categoriaxvehiculo.rela_prod_categoria 
inner join vehiculos on vehiculos.vehiculo_id=categoriaxvehiculo.rela_vehiculo
where categoriaxvehiculo.estado=1 and categoriaxvehiculo.rela_prod_categoria=".$prod_categoria_id." order by vehiculos.vehiculo_descripcion asc";

// echo $sql;
// exit();

$rs_vehiculo = $conexion->query($sql) or die($conexion->error);


?>

<!DOCTYPE html>
<html>
<head>
	<title>Vehiculos</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de vehiculos</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="alta_vehiculo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">Agregar vehiculo</a></p>
		<p><a href="buscar_vehiculo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>">Buscar</a></p>
		<p><a href="../../../dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Vehiculos</th>
					<th>Modelos</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs_vehiculo->fetch_assoc()): ?>
					
					<tr>
						<td> <?php echo $row['vehiculo_id']; ?> </td>
						<td> <?php echo utf8_encode($row['vehiculo_descripcion']); ?> </td>

						<td> <a href="modelos_vehiculos/listado.php?prod_categoria_id=<?php echo $prod_categoria_id;?>&vehiculo_id=<?php echo $row['vehiculo_id'];?>">Ver</a></td>
						<td>
							<a href="editar.php?prod_categoria_id=<?php echo $prod_categoria_id;?>&vehiculo_id=<?php echo $row['vehiculo_id']; ?>">
							    Editar
							</a> | 
							<a onclick="return confirm('¿Estas seguro que desea dar de baja este vehiculo?')" href="procesar_baja.php?prod_categoria_id=<?php echo $prod_categoria_id;?>&vehiculo_id=<?php echo $row['vehiculo_id']; ?>">
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
<?php

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

if (isset($_GET['mensaje'])) {
	switch ($_GET['mensaje']) {
        case 'GUARDAR_COMPRA_OK':
            $mensaje = 'Compra agregada correctamente.';
            break;

		case 'GUARDAR_COMPRA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar guardar la compra.';
			break;
	}
}

// Consultamos en la tabla Empleados y Personas
$sql = "SELECT * FROM compras INNER JOIN detalle_compra ON id_compra = rela_compra"
 			. " INNER JOIN productos ON rela_producto = id_producto"
 			. " INNER JOIN proveedores ON rela_proveedor = id_proveedores"
 			. " INNER JOIN personas_juridicas ON id_persona_juridica = rela_persona_juridica"
			. " WHERE id_compra = rela_compra AND compras.estado = 1";

//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);


?>

<!DOCTYPE html>
<html>
<head>
	<title>Compras</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Compras</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="alta_compra.php">Nueva compra</a></p>
		<p><a href="/autoparts_system/dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>Fecha compra</th>
					<th>Cantidad adquirida</th>
					<th>Nombre producto</th>
					<th>Precio de compra</th>
					
					<th>Nombre Proveedor</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>
					<tr>
						<td> <?php echo $row['fecha_compra']; ?> </td>
						<td> <?php echo $row['detalle_cantidad_compra']; ?> </td>
						<td> <?php echo utf8_encode($row['descripcion_producto']); ?> </td>
						<td> <?php echo $row['detalle_precio_unitario']; ?> </td>
						
						<td> <?php echo $row['razon_social_persona']; ?> </td>
						<td>
							<a href="editar.php?id_compra=<?php echo $row['id_compra']; ?>">
							    Editar
							</a> | 
							<a href="eliminar.php?id_compra=<?php echo $row['id_compra']; ?>">
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

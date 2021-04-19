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
        case 'GUARDAR_VENTA_OK':
            $mensaje = 'Venta agregada correctamente.';
            break;

		case 'GUARDAR_VENTA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar agregar la venta.';
			break;
	}
}

// Consultamos en la tabla Empleados y Personas
$sql ="SELECT factura_fecha,detalle_cantidad,descripcion_producto,
		detalle_precio_unitario,factura_total,nombres_persona,apellidos_persona"
	 . " FROM facturas INNER JOIN detalle_factura ON id_factura = rela_factura"
     . " INNER JOIN productos ON id_producto = rela_producto"
     . " INNER JOIN clientes ON id_cliente = rela_cliente"
     . " INNER JOIN personas_fisicas ON id_persona_fisica = rela_persona_fisica"
     . " WHERE id_factura = rela_factura";

//$rs = mysqli_query($conexion, $sql);
 $rs = $conexion->query($sql) or die($conexion->error);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ventas</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Ventas</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="alta_venta.php">Nueva venta</a></p>
		<p><a href="/autoparts_system/dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>Fecha Factura</th>
					<th>Cantidad facturada</th>
					
					<th>Nombre producto</th>
					
					<th>PVP</th>
					<th>Total factura</th>
					<th>Nombre cliente</th>
					<th>Apellido cliente</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>


					<tr>
						<td> <?php echo $row['factura_fecha']; ?> </td>
						<td> <?php echo $row['detalle_cantidad']; ?> </td>
						<td> <?php echo utf8_encode($row['descripcion_producto']); ?> </td>
						<td> <?php echo $row['detalle_precio_unitario']; ?> </td>
						<td> <?php echo $row['factura_total']; ?> </td>
						<td> <?php echo utf8_encode($row['nombres_persona']); ?> </td>
						<td> <?php echo utf8_encode($row['apellidos_persona']); ?> </td>

						
						<td>
							<a href="editar.php?id_factura=<?php echo $row['id_factura']; ?>">
							    Editar
							</a> | 
							<a href="eliminar.php?id_factura=<?php echo $row['id_factura']; ?>">
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
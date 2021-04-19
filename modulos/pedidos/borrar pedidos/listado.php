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
        case 'GUARDAR_PEDIDO_OK':
            $mensaje = 'Pedido agregado correctamente.';
            break;

		case 'GUARDAR_PEDIDO_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar agregar el pedido.';
			break;
	}
}

// Consultamos en la tabla Empleados y Personas
$sql = "SELECT  id_pedido,fecha_pedido,detalle_cantidad,descripcion_producto,nombres_persona,apellidos_persona,dni_persona"  
	. " FROM pedidos" 
	. " JOIN detalle_pedido ON id_pedido = rela_pedido"
	. " JOIN productos ON id_producto = rela_producto"
	. " JOIN clientes ON id_cliente = rela_cliente"
	. " JOIN personas_fisicas ON id_persona_fisica = rela_persona_fisica"
	. " WHERE id_pedido = rela_pedido";

//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pedidos</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Pedidos</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="nuevo.php">Agregar Pedido</a></p>
		<p><a href="../../dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Fecha pedido</th>
					<th>Cantidad pedido</th>
					<th>Nombre producto</th>
					
					<th>Nombre Cliente</th>
					<th>Apellido Cliente</th>
					<th>DNI Cliente</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>
					<tr>
						<td> <?php echo $row['id_pedido']; ?> </td>
						<td> <?php echo$row['fecha_pedido']; ?> </td>
						<td> <?php echo $row['detalle_cantidad']; ?> </td>
						<td> <?php echo utf8_encode($row['descripcion_producto']); ?> </td>
						
						<td> <?php echo utf8_encode($row['nombres_persona']); ?> </td>
						<td> <?php echo utf8_encode($row['apellidos_persona']); ?> </td>
						<td> <?php echo $row['dni_persona']; ?> </td>
						<td>
							<a href="editar.php?id_pedido=<?php echo $row['id_pedido']; ?>">
							    Editar
							</a> | 
							<a href="eliminar.php?id_pedido=<?php echo $row['id_pedido']; ?>">
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
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
        case 'GUARDAR_PROVEEDOR_OK':
            $mensaje = 'Proveedor agregado correctamente.';
            break;
        case 'MODIFICAR_PROVEEDOR_OK':
            $mensaje = 'Proveedor modificado correctamente.';
            break;

        case 'PERSONA_ESTADO_UPDATE_OK':
            $mensaje = 'Proveedor eliminado correctamente.';
            break;

        case 'MODIFICAR_PERSONA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar modificar la persona juridica.';
			break;

   		case 'GUARDAR_PROVEEDOR_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear el Proveedor.';
			break;

		case 'MODIFICAR_PROVEEDOR_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar modificar el Proveedor.';
			break;

		case 'GUARDAR_PERSONA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear la persona.';
			break;
		case 'GUARDAR_PERSONA_JURIDICA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear la persona juridica.';
			break;

		case 'PERSONA_ESTADO_UPDATE_ERROR':
			$mensaje = 'Ha ocurrido un error al intenta dar de baja a la persona juridica.';
			break;

	}
}

// Consultamos en la tabla Empleados y Personas
$sql = "SELECT * FROM personas JOIN personas_juridicas ON personas.persona_id = personas_juridicas.rela_persona"
	 .	" JOIN proveedores ON proveedores.rela_persona_juridica = personas_juridicas.persona_juridica_id"
	 .	" WHERE proveedores.estado = 1";

//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Proveedores</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Proveedores</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="alta_proveedores.php">Nuevo Proveedor</a> ||
      <a href="buscar_proveedores.php">Buscar</a> </p>
		<p><a href="../../dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nombre/Razon Social</th>
					<th>Nro. Habilitacion</th>
					<th>Contacto</th>
					<th>Direccion</th>
					<th>ACCIONES</th> 
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>
					<tr>
						<td> <?php echo $row['proveedor_id']; ?> </td>
						<td> <?php echo utf8_encode($row['razon_social']); ?> </td>
						<td> <?php echo utf8_encode($row['nro_habilitacion']); ?> </td>
						<td><a href="../contactos/listado.php?persona_id=<?php echo $row['persona_id']; ?>">Ver</a></td>
						<td><a href="../domicilios/listado.php?persona_id=<?php echo $row['persona_id']; ?>">Ver</a></td>
						
						<td>
						
							<a href="editar_proveedores.php?persona_juridica_id=<?php echo $row['persona_juridica_id']; ?>">
							    Editar
							</a> | 
							<a href="procesamiento/procesar_baja.php?persona_juridica_id=<?php echo $row['persona_juridica_id']; ?>" onclick="return confirm('¿Estas seguro que desea dar de baja a este Proveedor?')">
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
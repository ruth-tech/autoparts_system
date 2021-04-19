<?php

require '../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

/*if (isset($_GET['mensaje'])) {
	switch ($_GET['mensaje']) {
        case 'GUARDAR_CLIENTE_OK':
            $mensaje = 'Cliente agregado correctamente.';
            break;

		case 'GUARDAR_CLIENTE_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear el Cliente.';
			break;

		case 'GUARDAR_PERSONA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear la persona.';
			break;
	}
}*/
$id = $_GET['id_persona_fisica'];

// Consultamos en la tabla Usuario, Perfiles, Empleados y Personas
$sql = " SELECT nombres_persona,apellidos_persona,descripcion_modulo"
." FROM usuarios u "
." INNER JOIN empleados e ON e.id_empleado = u.rela_empleado"
." INNER JOIN personas_fisicas pf ON  e.rela_persona_fisica = pf.id_persona_fisica"
." INNER JOIN perfiles perf ON perf.id_perfil = u.rela_perfil"
." INNER JOIN perfilesxmodulos pxm ON pxm.rela_perfil = perf.id_perfil"
." INNER JOIN modulos m ON pxm.rela_modulo = m.id_modulo"
." WHERE u.estado=1 AND id_persona_fisica =".$id;

//$rs = mysqli_query($conexion, $sql);
$rs_modulo = $conexion->query($sql) or die($conexion->error);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Seguridad</title>
</head>
<body>
	<?php require '../../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Configuracion de seguridad</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="usuarios.php">Asignar nuevo usuario</a></p>
		<p><a href="/autoparts_system/dashboard.php">Volver al menú</a></p>
		<br>
		<input type="hidden" name="ID" value="<?php echo $id;?>">
		<?php while ($row = $rs->fetch_assoc()): ?>
		<p><h5><?php echo utf8_encode($row['nombres_persona'."-".'apellidos_persona']); ?></h5></p>

		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>Modulos al que tiene acceso</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				
					<tr>
						<td> <?php echo utf8_encode($row['descripcion_modulo']); ?> </td>
						<td>
							<a href="modificar_usuario.php?id_usuario=<?php echo $row['id_usuario']; ?>">
							    Editar
							</a> | 
							<a href="baja_usuario.php?id_usuario=<?php echo $row['id_usuario']; ?>">
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
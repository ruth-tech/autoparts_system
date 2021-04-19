<?php

require '../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../index.php?error=debe_loguearse");
	exit;
}

/*if (isset($_GET['mensaje'])) {
	switch ($_GET['mensaje']) {
        case 'USUARIO_ERROR':
            $mensaje = 'Error al crear/modificar usuario.';
            break;
	}
}*/




$id_persona = $_GET['id_persona_fisica'];

$sql = "SELECT * FROM perfiles";

$rs_perfiles = $conexion->query($sql) or die ($conexion->error) //  }mysqli_query($conexion, $sql);

$sql = 'SELECT * FROM usuarios WHERE id_persona = ' . $id_persona;
$rs_usuarios = $conexion->query($sql) or die ($conexion->error) //mysqli_query($conexion, $sql);
$usuario = $rs_usuarios->fetch_assoc();

if ($usuario == NULL) {
	$usuario_id = 0;
} else {
	$usuario_id = $usuario['id_usuario'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Usuarios</title>
</head>
<body>
	<?php require '../../php/menu.php'; ?>
	<br>
	<br>
	<div align='center'>
		<form method="POST" action="asignar_usuario.php">
			<input type="hidden" name="PersonaID" value="<?php echo $id_persona; ?>">
			<input type="hidden" name="UsuarioID" value="<?php echo $usuario_id; ?>">
			<table border="1" cellpadding="2" cellspacing="0">
				<tbody>
					<tr>
						<td>Nombre Usuario: </td>
						<td>
							<input type="text" name="nomUser" value="<?php echo $usuario['nombre_usuario']; ?>">
						</td>
					</tr>
					<tr>
						<td>Contraseña: </td>
						<td>
							<input type="text" name="password" value="<?php echo $usuario['contrasenia_usuario']; ?>">
						</td>
					</tr>
					<tr>
						<td>Perfil: </td>
						<td>
							<select name="cboPerfil">
								<?php while ($row = $rs_perfiles->fetch_assoc()): ?>

									<?php
									if ($usuario['rela_perfil'] == $row['id']):
										$selected = 'SELECTED';
								    else:
								    	$selected = '';
									endif;
									?>

									<option value="<?php echo $row['id_perfil']; ?>" <?php echo $selected; ?>>
										<?php echo $row["descripcion_perfil"]; ?>
			    					</option>
			    				<?php endwhile; ?>
							</select>
					    </td>
				    </tr>
				    <tr>
				    	<td colspan="2">
				    		<input type="submit" value="Guardar">
				    	</td>
				    </tr>
				</tbody>
			</table>
		</form>
	</div>
</body>
</html>
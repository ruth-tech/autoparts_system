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
        case 'GUARDAR_EMPLEADO_OK':
            $mensaje = 'Empleado agregado correctamente.';
			break;
		
		case 'GUARDAR_USUARIO_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear el Usuario.';
			break;

		case 'GUARDAR_EMPLEADO_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear el Empleado.';
			break;

		case 'GUARDAR_PERSONA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar crear la persona.';
			break;
		
			case 'GUARDAR_PERSONA_FISICA_ERROR':
			$mensaje = 'Ha ocurrido un error al internar agregar una persona.';
			break;
		case 'NO_EXISTE_PERSONA':
			$mensaje = 'La persona a la que intenta realizar la accion no existe. ';
			break;
		case 'MODIFICAR_EMPLEADO_OK':
      		$mensaje = 'El empleado ha sido modificado exitosamete.';
      		break;
    	case 'MODIFICAR_EMPLEADO_ERROR':
      		$mensaje = 'Ha ocurrido un error al intentar modificar el Cliente.';
      		break;

    	case 'MODIFICAR_PERSONA_ERROR':
      		$mensaje = 'Ha ocurrido un error al intentar modificar la persona.';
      		break;
      	case 'EMPLEADO_ESTADO_UPDATE_ERROR':
            $mensaje = 'No se pudo dar de baja a esta persona, intentelo nuevamente.';
            break;
         case 'EMPLEADO_ESTADO_UPDATE_OK':
            $mensaje = 'Empleado eliminado correctamente.';
            break;
	}
}

// Consultamos en la tabla Clientes y Personas
$sql = "SELECT * FROM empleados"
. " INNER JOIN personas_fisicas
ON empleados.`rela_persona_fisica`=
personas_fisicas.`persona_fisica_id`"
. " INNER JOIN personas ON personas.`persona_id`=
personas_fisicas.`rela_persona`"
. " INNER JOIN usuarios ON personas.persona_id=usuarios.rela_persona"
. " INNER JOIN perfiles ON usuarios.rela_perfil=perfiles.perfil_id"
. " WHERE empleados.`estado`=1 ";

// echo $sql;
// exit();

//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);


?>

<!DOCTYPE html>
<html>
<head>
	<title>Empleados</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Empleados</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="alta_empleado.php">Agregar</a>||<a href="buscar_empleado.php">Buscar</a></p>
		<p><a href="/autoparts_system/dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Empleado</th>
					<th>Cuil</th>			
					<th>Perfil del empleado</th>
					<th>Contacto</th>
					<th>Direccion</th>	
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>
					<tr>
						<td> <?php echo $row['empleado_id']; ?> </td>
						<td> <?php echo utf8_encode($row['apellidos_persona'].", ". $row['nombres_persona']); ?> </td>									
						<td> <?php echo utf8_encode($row['persona_cuil']); ?> </td>
						<td> <?php echo utf8_encode($row['perfil_descripcion']); ?> </td>
						<td><a href="../contactos/listado.php?persona_id=<?php echo $row['persona_id']; ?>">Ver</a></td>
						<td><a href="../domicilios/listado.php?persona_id=<?php echo $row['persona_id']; ?>">Ver</a></td>
						
						<td>
							<a href="editar_cliente.php?persona_fisica_id=<?php echo $row['persona_fisica_id']; ?>&empleado_id=<?php echo $row['empleado_id']; ?>">
							    Editar
							</a> | 
							<a onclick="return confirm('¿Estas seguro que desea dar de baja a este Empleado?')" href="procesamiento/procesar_baja.php?persona_fisica_id=<?php echo $row['persona_fisica_id']; ?>&empleado_id=<?php echo $row['empleado_id']; ?>">							    Eliminar
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>

	</div>
</fieldset>
</body>
</html>
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
		
		case 'GUARDAR_DOMICILIO_OK':
            $mensajeDomi = 'Domicilio agregado correctamente.';
            break;

         case 'MODIFICAR_DOMICILIO_OK':
            $mensajeDomi = 'Domicilio modificado correctamente.';
            break;

         case 'PERSONA_ESTADO_UPDATE_OK':
            $mensajeDomi = 'Domicilio eliminado correctamente.';
            break;

        case 'MODIFICAR_PERSONA_DOMICILIO_ERROR':
            $mensajeDomi = 'Ha ocurrido un error al intentar modificar el Domicilio de la persona seleccionada.';
            break;

        case 'GUARDAR_DOMICILIO_ERROR':
            $mensajeDomi = 'Ha ocurrido un error al intentar agregar un Domicilio a la persona seleccionada.';
            break;

         case 'PERSONA_ESTADO_UPDATE_ERROR':
            $mensajeDomi = 'Ha ocurrido un error al intentar eliminar un Domicilio de la persona seleccionada.';
            break;
         
        


          

    }
}

$persona_id = $_GET["persona_id"];

$sql = "SELECT * FROM `persona_domicilio`" 
." INNER JOIN `personas` "
." ON `persona_domicilio`.`rela_persona` 
=`personas`.`persona_id`"
." INNER JOIN tipo_domicilios "
." ON `tipo_domicilios`.`tipo_domicilio_id`=
`persona_domicilio`.`rela_tipo_domicilio`"
." INNER JOIN barrios ON barrios.`barrio_id`=
persona_domicilio.`rela_barrio`"
." INNER JOIN localidades ON localidades.localidad_id= barrios.rela_localidad"
." INNER JOIN provincias ON provincias.provincia_id= localidades.rela_provincia"
." WHERE `persona_domicilio`.`estado`=1 
AND personas.`persona_id`=".$persona_id
." ORDER BY persona_domicilio.persona_domicilio_id ASC";



$rs_domicilio = $conexion->query($sql) or die($conexion->error);

if ($persona_id) {
	$sql= "SELECT * FROM  personas_fisicas where rela_persona=".$persona_id;

	$rs_persona_fisica=$conexion->query($sql) or die($conexion->error);
	$persona = $rs_persona_fisica->fetch_assoc();
	$nombre = $persona['nombres_persona']." ".$persona['apellidos_persona'];
	
}else{
	$sql="SELECT * FROM personas_juridicas where rela_persona=".$persona_id;

	$rs_persona_juridica=$conexion->query($sql) or die($conexion->error);
	$persona = $rs_persona_juridica->fetch_assoc();
	$nombre = $persona['razon_social'];

}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Direcciones</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Direcciones</b></h1>
    	<?php if (isset($mensajeDomi)): ?>
    		<h3><font color="red"><?php echo $mensajeDomi; ?></font></h3>
    	<?php endif; ?>
		<p><a href="altadomicilio.php?persona_id=<?php echo $persona_id ?>">Agregar</a></p>
		<br>

		<p><h3><b><?php echo utf8_encode($nombre); ?></b></h3></p>

		 
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tipo Domicilio</th>
					<th>Provincia</th>
					<th>Localidad</th>
					<th>Barrio</th>
					<th>Calle</th>
					<th>Altura</th>
					<th>Torre</th>
					<th>Piso</th>
					<th>Manzana</th>
					<th>Sector</th>
					<th>Parcela</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				 
					<tr>
						<?php while ($row = $rs_domicilio->fetch_assoc()): ?>
			             
						
						<td> <?php echo $row['persona_domicilio_id']; ?> </td>
						<td> <?php echo utf8_encode($row['tipo_domicilio_descripcion']); ?> </td>
						<td> <?php echo utf8_encode($row['provincia_nombre']); ?> </td>
						<td> <?php echo utf8_encode($row['localidad_nombre']); ?> </td>
						<td> <?php echo utf8_encode($row['barrio_nombre']); ?> </td>
						<td> <?php echo utf8_encode($row['calle']); ?> </td>
						<td> <?php echo $row['altura']; ?> </td>
						<td> <?php echo $row['torre']; ?> </td>
						<td> <?php echo $row['piso']; ?> </td>
						<td> <?php echo $row['manzana']; ?> </td>
						<td> <?php echo $row['sector']; ?> </td>
						<td> <?php echo $row['parcela']; ?> </td>
						<td>
							<a href="editar_domicilio.php?persona_id=<?php echo $persona_id;?>&persona_domicilio_id=<?php echo $row['persona_domicilio_id'] ;?>">
							    Editar
							</a> | 
							<a href="procesar_baja.php?persona_id=<?php echo $persona_id;?>&persona_domicilio_id=<?php echo $row['persona_domicilio_id'] ;?>" onclick="return confirm('Esta seguro que desea eliminar el domicilio seleccionado.')">
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
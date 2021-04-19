<?php

// require '../../php/conexion.php';

// session_start();

// // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
// if (!isset($_SESSION["logueado"])) {
// 	header("location: ../../index.php?error=debe_loguearse");
// 	exit;
// }

// if (isset($_GET['mensaje'])) {
// 	switch ($_GET['mensaje']) {
		
// 		case 'GUARDAR_CONTACTO_OK':
//             $mensaje = 'Contacto agregado correctamente.';
//             break;

//          case 'MODIFICAR_CONTACTO_OK':
//         	$mensaje = 'El contacto ha sido modificado correctamente.';
//         	break;

//          case 'PERSONA_ESTADO_UPDATE_OK':
//         	$mensaje = 'El contacto ha sido eliminado correctamente.';
//         	break;

//         case 'GUARDAR_CONTACTO_ERROR':
//             $mensaje = 'Ha ocurrido un error al intentar agregar un Contacto a la persona seleccionada.';
//             break;


//         case 'MODIFICAR_PERSONA_CONTACTO_ERROR';
//         	$mensaje = 'Ha ocurrido un error al intentar modificar el contacto de la persona seleccionada.';
//         	break;
       
//         case 'PERSONA_ESTADO_UPDATE_ERROR':
//         	$mensaje = 'Ha ocurrido un error al intentar eliminar el contacto de la persona seleccionada';
//         	break;
          

//     }
// }

$persona_id = $_GET["persona_id"];

// $persona_fisica_id=$_GET['persona_fisica_id'];
// $persona_juridica_id=$_GET['persona_jurica_id'];

$sql = "SELECT * FROM `persona_contacto` "
." INNER JOIN `personas` "
." ON `persona_contacto`.`rela_persona` 
=`personas`.`persona_id` "
." INNER JOIN tipo_contacto "
." ON `tipo_contacto`.`tipo_contacto_id`=
`persona_contacto`.`rela_tipo_contacto`"
." WHERE `persona_contacto`.`estado`=1 AND personas.`persona_id`=". $persona_id
." ORDER BY persona_contacto.`persona_contacto_id`";



$rs_contacto = $conexion->query($sql) or die($conexion->error);

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
	<title>Contactos</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Contactos</b></h1>
    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>
		<p>
			<a href="alta_contacto.php?persona_id=<?php echo $persona_id; ?>">Agregar</a>
			
		</p>
		
		 
		<!-- <p><h3><b><?php //echo $nombre; ?></b></h3></p> -->
		<?php  if($rs !== 0): ?>

		<table border="1" cellpadding="2" cellspacing="0">
			

			<thead>
				
				<tr>
					<th>ID</th>
					<th>Tipo Contacto</th>
					<th>Valor</th>
					<th>ACCIONES</th>
					
				</tr>
			</thead>
			<tbody>
				 
					<tr>
						
						
						<?php while ($row = $rs_contacto->fetch_assoc()): ?>
						<td><?php echo $row['persona_contacto_id'] ;?></td>
						<td> <?php echo utf8_encode($row['tipo_contacto_descripcion']); ?> </td>
						<td><?php echo utf8_encode($row['valor_contacto']); ?></td>
						<td>
							<a href="editar_contacto.php?persona_id=<?php echo $persona_id;?>&persona_contacto_id=<?php echo $row['persona_contacto_id'] ;?>">
							    Editar
							</a> | 
							<a href="procesar_baja.php?persona_id=<?php echo $persona_id;?>&persona_contacto_id=<?php echo $row['persona_contacto_id'] ;?>" onclick="return confirm('¿Estas seguro que desea eliminar este Contacto?')" >
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
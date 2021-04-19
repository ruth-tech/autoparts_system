<?php


require('../../../../php/conexion.php');


session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];

$vehiculo_id=$_GET['vehiculo_id'];

if(isset($_POST["filtro"]) and !empty($_POST['filtro'])){
	$filtro = trim($_POST["filtro"]);
} else {
	echo "<h1><b>Resultado de búsqueda</b></h1><br>";
	echo "<a href='listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id'>Lista de Categorias</a> &nbsp;||&nbsp;";
	echo "<a href='alta_categoria.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id'>Agregar</a> &nbsp;||&nbsp;";
	echo "<a href='../../../../dashboard.php'>Volver</a><br><br>";
	echo "<p>Por favor ingrese un parámetro de búsqueda.</p>";
	
	return false;
}


$sql = "SELECT * FROM modelos_vehiculos"
	. " WHERE modelo_vehiculo_descripcion LIKE '%$filtro%' and rela_vehiculo=".$vehiculo_id." ORDER BY modelo_vehiculo_descripcion ASC";

$rs = $conexion->query($sql) or die($conexion->error);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Resultado</title>
	<link rel="stylesheet" href="">
</head>
<body>

	<h1><b>Resultado de búsqueda</b></h1>
	<p>
		<a href="listado.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">Lista de Modelos</a> || 
		<a href="alta_modelo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">Agregar</a> || 
		<a href="buscar_modelo.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>">Buscar</a>
	</p>
	<br>
	<table border="1" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				
				<th>Descripcion</th>
				
				<th>ACCIONES</th>
			</tr>
		</thead>
		<tbody>
			
			<?php while($row = $rs->fetch_assoc()):?>
			<tr>
				<td> <?php echo $row['modelo_vehiculo_descripcion']; ?> </td>
				
				<td>
				<a href="listado.php?prod_categoria_id=<?php echo $row['prod_categoria_id'];?>&vehiculo_id=<?php echo $vehiculo_id;?>&modelo_vehiculo_id=<?php echo $row['modelo_vehiculo_id'];?>">Ir al Listado</a> |
				<a href="editar.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>&modelo_vehiculo_id=<?php echo $row['modelo_vehiculo_id'];?>">Editar</a> | 
				<a onclick="return confirm('¿Estas seguro que desea dar de baja a este modelo?')" href="procesar_baja.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo $vehiculo_id;?>&modelo_vehiculo_id=<?php echo $row['modelo_vehiculo_id'];?>">Eliminar</a>
			</tr>
			<?php endwhile; ?>
		</tbody>		

	</table>

</body>
</html>


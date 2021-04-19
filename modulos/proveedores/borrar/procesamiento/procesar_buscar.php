<?php


require('../../../php/conexion.php');


session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../index.php?error=debe_loguearse");
	exit;
}

if(isset($_POST["filtro"]) and !empty($_POST['filtro'])){
	$filtro = trim($_POST["filtro"]);
} else {
	echo "<h1><b>Resultado de búsqueda</b></h1><br>";
	echo "<a href='listado.php'>Lista de Proveedores</a> &nbsp;||&nbsp;";
	echo "<a href='alta_proveedores.php'>Agregar</a> &nbsp;||&nbsp;";
	echo "<a href='../../../dashboard.php'>Volver al menu</a><br><br>";
	echo "<p>Por favor ingrese un parámetro de búsqueda.</p>";
	
	return false;
}


$sql = "SELECT * FROM proveedores inner JOIN personas_juridicas ON personas_juridicas.persona_juridica_id = proveedores.rela_persona_juridica"
	. " WHERE razon_social LIKE '%$filtro%' ORDER BY razon_social ASC";

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
		<a href="../listado.php">Lista de Proveedores</a> || 
		<a href="../alta_proveedores.php">Agregar</a> || 
		<a href="../buscar_proveedores.php">Buscar</a>
	</p>
	<br>
	<table border="1" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				<th>ID</th>
				<th>Razon Social</th>
				<th>Nro de habilitacion</th>				
				<th>ACCIONES</th>
			</tr>
		</thead>
		<tbody>
			
			<?php while($row = $rs->fetch_assoc()):?>
			<tr>
				<td> <?php echo $row['proveedor_id']; ?> </td>
				<td> <?php echo $row['razon_social']; ?> </td>
				<td> <?php echo $row['nro_habilitacion']; ?> </td>
							
				<td>
				<a href="listado.php">Ir al listado</a> |
				<a href="editar_proveedores.php?persona_juridica_id=<?php echo $row['persona_juridica_id']; ?>"> Editar</a> | 
				<a href="procesamiento/procesar_baja.php?persona_juridica_id=<?php echo $row['persona_juridica_id']; ?>" onclick="return confirm('¿Estas seguro que desea dar de baja a este Proveedor?')">Eliminar</a>
			</tr>
			<?php endwhile; ?>
		</tbody>		

	</table>

</body>
</html>


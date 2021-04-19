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
	echo "<a href='../listado.php'>Ir al listado</a> &nbsp;||&nbsp;";
	echo "<a href='../alta_empleado.php'>Agregar</a> &nbsp;||&nbsp;";
	echo "<a href='../buscar_empleado.php'>Buscar</a> &nbsp;||&nbsp;";
	echo "<a href='../../../dashboard.php'>Volver</a><br><br>";
	echo "<p>Por favor ingrese un parámetro de búsqueda.</p>";
	
	return false;
}


$sql = "SELECT * FROM empleados  JOIN personas_fisicas ON persona_fisica_id = rela_persona_fisica"
	. " WHERE empleados.estado=1 and nombres_persona LIKE '%$filtro%' OR apellidos_persona LIKE '%$filtro%' ORDER BY empleado_id ASC";

	//echo $sql;
	//exit();

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
		<a href="../listado.php">Ir al listado</a> || 
		<a href="../alta_empleado.php">Agregar</a> || 
		<a href="../buscar_empleado.php">Buscar</a>
	</p>
	<br>
	<table border="1" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>DNI</th>
				<th>CUIL</th>
				<th>ACCION</th>
			</tr>
		</thead>
		<tbody>
			
			<?php while($row = $rs->fetch_assoc()):?>
			<tr>
				<td> <?php echo $row['nombres_persona']; ?> </td>
				<td> <?php echo $row['apellidos_persona']; ?> </td>
				<td> <?php echo $row['persona_dni']; ?> </td>
				<td> <?php echo $row['persona_cuil']; ?> </td>
				
				<td>
				<a href="editar_empleado.php?persona_fisica_id=<?php echo $row['persona_fisica_id']; ?>&empleado_id=<?php echo $row['empleado_id']; ?>">
				Editar</a> | 
				<a href="procesar_baja.php?persona_fisica_id=<?php echo $row['id_persona_fisica']; ?>&empleado_id=<?php echo $row['empleado_id']; ?>" onclick="return confirm('Esta seguro desea dar de baja a este empleado?')" >Eliminar</a>
			</tr>
			<?php endwhile; ?>
		</tbody>		

	</table>

</body>
</html>

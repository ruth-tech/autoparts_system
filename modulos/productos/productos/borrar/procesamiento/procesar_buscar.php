<?php


require('../../../../../../php/conexion.php');


session_start();

if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../../../index.php?error=debe_loguearse");
	exit;
}

if(isset($_POST["filtro"]) and !empty($_POST['filtro'])){
	$filtro = trim($_POST["filtro"]);
} else {
	echo "<h1><b>Resultado de búsqueda</b></h1><br>";
	echo "<a href='../listado.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id'>Lista de Productos</a> &nbsp;||&nbsp;";
	echo "<a href='../alta_productos.php?prod_categoria_id=$prod_categoria_id&vehiculo_id=$vehiculo_id&modelo_vehiculo_id=$modelo_vehiculo_id'>Agregar</a> &nbsp;||&nbsp;";
	echo "<a href='../../../../../../dashboard.php'>Volver al menu</a><br><br>";
	echo "<p>Por favor ingrese un parámetro de búsqueda.</p>";
	
	return false;
}


$sql = "SELECT * FROM productoxcategoria "
	." INNER JOIN productos ON productos.producto_id = productoxcategoria.rela_producto"
	." WHERE productos.descripcion_producto LIKE '%$filtro%' OR productos.producto_detalle_fabricante LIKE '%$filtro%' ORDER BY productos.producto_descripcion ASC";

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
		<a href="../listado.php? prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo $modelo_vehiculo_id;?>">Lista de Productos</a> || 
		<a href="../alta_productos.php? prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo $modelo_vehiculo_id;?>">Agregar</a> 
		
	</p>
	<br>
	<table border="1" cellpadding="2" cellspacing="0">
		<thead>
			<tr>
				
				<th>ID</th>
				<th>Descripcion Producto</th>
				
				<th>ACCIONES</th>
			</tr>
		</thead>
		<tbody>
			
			<?php while($row = $rs->fetch_assoc()):?>
			<tr>
				<td> <?php echo $row['id']; ?> </td>
				<td> <?php echo $row['descripcion_producto']; ?> </td>
							
				<td>
				<a href="editar_producto.php? prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo $modelo_vehiculo_id;?>producto_id=<?php echo $row['producto_id']; ?>">Editar</a> | 
				<a onclick="return confirm('¿Estas seguro que desea dar de baja a este Cliente?')" href="procesamiento/procesar_baja.php? prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo $modelo_vehiculo_id;?>producto_id=<?php echo $row['producto_id']; ?>">Eliminar</a>
			</tr>
			<?php endwhile; ?>
		</tbody>		

	</table>

</body>
</html>


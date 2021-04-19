
<?php

require '../../../../../php/conexion.php';

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
	header("location: ../../../../../index.php?error=debe_loguearse");
	exit;
}

$prod_categoria_id=$_GET['prod_categoria_id'];

$vehiculo_id=$_GET['vehiculo_id'];

$modelo_vehiculo_id=$_GET['modelo_vehiculo_id'];

if (isset($_GET['mensaje'])) {
	switch ($_GET['mensaje']) {
        case 'GUARDAR_PRODUCTO_OK':
            $mensaje = 'Producto agregado correctamente.';
            break;

         case 'MODIFICAR_PRODUCTO_OK':
            $mensaje = 'Producto modificado correctamente.';
            break;

        case 'PRODUCTO_ESTADO_UPDATE_OK':
            $mensaje = 'Producto eliminado correctamente.';
            break;

		case 'GUARDAR_PRODUCTO_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar agregar el Producto.';
			break;

		
		case 'GUARDAR_PRODUCTO_PRECIO_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar guardar el precio del Producto.';
			break;

		case 'PRODUCTO_ESTADO_UPDATE_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar eliminar el Producto.';
			break;


		case 'GUARDAR_PRODUCTOXCATEGORIA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar agregar el Producto a la categoria seleccionada.';
			break;

		case 'MODIFICAR_PRODUCTO_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar modificar el Producto.';
			break;

		case 'MODIFICAR_PRODUCTOXCATEGORIA_ERROR':
			$mensaje = 'Ha ocurrido un error al intentar modificar el Producto de la categoria seleccionada.';
			break;

	}
}



$sql = "SELECT * FROM productoxcategoria". 
" INNER JOIN prod_categorias ON prod_categorias.`prod_categoria_id`=productoxcategoria.`rela_prod_categoria`".
" INNER JOIN productos ON productoxcategoria.`rela_producto`=productos.`producto_id`".
" INNER JOIN modelos_vehiculos ON productos.`rela_modelo_vehiculo`=modelos_vehiculos.`modelo_vehiculo_id`".
" INNER JOIN vehiculos ON modelos_vehiculos.`rela_vehiculo`=vehiculos.`vehiculo_id`".
" INNER JOIN producto_precio ON producto_precio.`rela_productoxcategoria`=productoxcategoria.`productoxcategoria_id`".
" WHERE productoxcategoria.`estado`=1".
" AND producto_precio.`precio_fecha`=
(SELECT MAX(precio_fecha) FROM producto_precio". 
" INNER JOIN productoxcategoria ON producto_precio.`rela_productoxcategoria`=productoxcategoria.`productoxcategoria_id`".
" INNER JOIN prod_categorias ON prod_categorias.`prod_categoria_id`=productoxcategoria.`rela_prod_categoria`".
" WHERE prod_categorias.`prod_categoria_id`=". $prod_categoria_id.")
AND prod_categorias.`prod_categoria_id`=".$prod_categoria_id.
" AND modelos_vehiculos.`modelo_vehiculo_id`=".$modelo_vehiculo_id;

//echo$sql;
//exit();


//$rs = mysqli_query($conexion, $sql);
$rs = $conexion->query($sql) or die($conexion->error);



?>

<!DOCTYPE html>
<html>
<head>
	<title>Productos</title>
</head>
<body background="../../../../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../../../../php/menu.php'; ?>
	<div align='center'>
		<h1><b>Listado de Productos</b></h1>

    	<?php if (isset($mensaje)): ?>
    		<h3><font color="red"><?php echo $mensaje; ?></font></h3>
    	<?php endif; ?>

		<p><a href="alta_productos.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>">Nuevo Producto</a>||
		<a href="buscar_producto.php?prod_categoria_id=<?php echo$prod_categoria_id;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>">Buscar</a></p>
		<p><a href="../../../../dashboard.php">Volver al menú</a></p>
		<br>
		<table border="1" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Descripcion Producto</th>
					<th>Cantidad actual</th>
					<th>Precio</th>
					<th>ACCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $rs->fetch_assoc()): ?>
					<tr>
						<td> <?php echo $row['producto_id']; ?> </td>
						<td> <?php echo utf8_encode($row['producto_descripcion']); ?> </td>

						<td> <?php echo $row['cantidad_actual']; ?> </td>
						<td><?php echo $row['precio_valor']; ?></td>
						
						<td>
							<a href="editar_producto.php?prod_categoria_id=<?php echo $prod_categoria_id ;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>&producto_id=<?php echo $row['producto_id']; ?>">
							    Editar
							</a> | 
							<a onclick="return confirm('¿Estas seguro que desea dar de baja este producto?')" href="procesamiento/procesar_baja.php?prod_categoria_id=<?php echo $prod_categoria_id ;?>&vehiculo_id=<?php echo$vehiculo_id;?>&modelo_vehiculo_id=<?php echo$modelo_vehiculo_id;?>&producto_id=<?php echo $row['producto_id']; ?>">
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
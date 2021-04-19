<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nueva Compra</title>
</head>
<body background="../../fondo6.jpg">

	<fieldset style="border:6px groove #ccc; background:#f2f2f2";&quot;height:100px;width:200px&quot;>
	<?php require '../../php/menu.php'; ?>
  <div align="center">

	 <h1>Alta de Compras</h1>


    <p>
      <a href="listado.php">Lista de Compras</a> ||
      <a href="buscar_compra.php">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesamiento/procesar_alta.php">


      <h3>Ingrese los datos de la compra</h3>
      <p>
        <label>Fecha Compra: </label>
        <input type="date" name='fecha_compra'>
        </label>
      </p>
      
      <p>
      	<label>Proveedor:

      		<select name='proveedor_id'>
      			<option value="">--Seleccione--</option>
      			<?php

      			$proveedor = $conexion->query("SELECT * FROM proveedores p INNER JOIN personas_juridicas pj ON p.rela_persona_juridica = pj.id_persona_juridica") or die ("Error de SQL");
      			while ($row = $proveedor->fetch_assoc()) {
      				echo '<option VALUE="'.$row['id_proveedores'].'">'.$row['razon_social_persona'].'</option>';
      			}
      			?>   			
      		</select>      		
      	</label>|| <a href="../proveedores/alta_proveedores.php" target="_blank">Añadir</a>   
      </p>
      <p>
      	<label>Encargado de la Compra:

      		<select name="encargado_compra">
      			<option value="">--Seleccione--</option>
      			<?php

      			$encargado_compra = $conexion->query("SELECT * FROM empleados INNER JOIN personas_fisicas ON empleados.rela_persona_fisica = personas_fisicas.id_persona_fisica") or die ("Error de SQL");
      			while ($row = $encargado_compra->fetch_assoc()) {
      				echo '<option VALUE="'.$row['id_empleado'].'">'.$row['nombres_persona'].'</option>';
      			}
      			?>      			
      		</select>      		
      	</label>|| <a href="../empleados/alta_empleado.php" target="_blank">Añadir</a>
      </p>
      
       <p>
      	<label>Categorias:

      		<select name="categorias">
      			<option value="">--Seleccione--</option>
      			<?php

      			$categorias = $conexion->query("SELECT * FROM categorias_productos") or die ("Error de SQL");
      			while ($row = $categorias->fetch_assoc()) {
      				echo '<option VALUE="'.$row['id_categoria'].'">'.$row['descripcion_categoria'].'</option>';
      			}
      			?>      			
      		</select>      		
      	</label>|| <a href="../categorias_productos/alta_categoria.php" target="_blank">Añadir</a>
      </p>
      
      <p>
        <label>Productos:

          <select name="productos">
            <option value="">--Seleccione--</option>
            <?php

            $productos = $conexion->query("SELECT * FROM productos") or die ("Error de SQL");
            while ($row = $categorias->fetch_assoc()) {
              echo '<option VALUE="'.$row['id_producto'].'">'.$row['descripcion_producto'].'</option>';
            }
            ?>            
          </select>         
        </label>|| <a href="../categorias_productos/productos/alta_productos.php" target="_blank">Añadir</a>
      </p>
      <p>
        <label>Cantidad adquirida: </label>
        <input type="text" name="cant_adquirida" >
        </label>
      </p>
      
      <p>
        <label>Precio unitario Compra:</label>
        <input type="text" name="precio_unit_compra" >
        </label>
      </p>
      
      <p>
        <label>Forma de pago:

          <select name="forma_pago">
            <option value="">--Seleccione--</option>
            <?php

            $categorias = $conexion->query("SELECT * FROM forma_pago") or die ("Error de SQL");
            while ($row = $categorias->fetch_assoc()) {
              echo '<option VALUE="'.$row['id_forma_pago'].'">'.$row['descripcion'].'</option>';
            }
            ?>            
          </select>         
        </label>
      </p>

      
       



      <p>
        <button type="button" onclick="window.history.go(-1); return false;">Cancelar</button> &nbsp;
        <input type="submit" value="Guardar">
      </p>
    </form>
  </div>
</body>
</html>



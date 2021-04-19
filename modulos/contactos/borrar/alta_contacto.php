<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}

$persona_id = $_GET["persona_id"];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Nuevo Contacto</title>
</head>
<body>
	<div align="center">
	<h2>Ingrese datos de Contacto</h2>

		<form method="POST" action="procesar_alta.php" >
			<input type="hidden" name="ID" value="<?php echo $persona_id;?>">

			<p><label>Tipo de Contacto:
			<select name="tipo_contacto">
				<option value="">--SELECCIONE--</option>
				<?php 
				$tipo_contacto = $conexion->query("SELECT * FROM tipo_contacto") or die ("Error de SQL");
				while ($row = $tipo_contacto->fetch_assoc()) {
					echo '<option VALUE="'.$row['tipo_contacto_id'].'">'.$row['tipo_contacto_descripcion'].'</option>'  ;
				}

				?>
			</select>
			 </label></p>

			 <p><label>Valor: 
			<input  type="text" name="valor">
			</label></p>


			<p><button>Guardar</button></p>




		</form>
	</div>
</body>
</html>

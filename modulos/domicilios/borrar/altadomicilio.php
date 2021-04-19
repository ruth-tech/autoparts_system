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
	<title>Nuevo Domicilio</title>
</head>
<body>
	<div align="center">
	<h2>Ingrese datos del domicilio</h2>

		<form method="POST" action="procesar_alta.php" >
			<input type="hidden" name="persona_id" value="<?php echo $persona_id;?>">

			<p><label>Tipo Domicilio:
					<select name="tipo_domi">
						<option value="">--SELECCIONE--</option>
						<?php 
						$tipo_domi = $conexion->query("SELECT * FROM tipo_domicilios") or die ("Error de SQL");
						while ($row = $tipo_domi->fetch_assoc()) {
							echo '<option VALUE="'.$row['tipo_domicilio_id'].'">'.$row['tipo_domicilio_descripcion'].'</option>'  ;
						}

						?>
					</select>
			 
				</label>
			</p>
			
			<p><label>Pais:
					<select name="pais" id="pais">
						<option value="">--SELECCIONE--</option>
						
					</select>
			 
				</label>
			</p>

			<p><label>Provincia:
					<select name="provincia" id="provincia">
						<option value="">--SELECCIONE--</option>
						
					</select>
			 
				</label>
			</p>

			<p><label>Localidad:
					<select name="localidad" id="localidad">
						<option value="">--SELECCIONE--</option>
						
					</select>
			 
				</label>
			</p>

			<p><label>Barrio:
					<select name="barrio" id="barrio">
						<option value="">--SELECCIONE--</option>
						
					</select>
			 
				</label>
			</p>

			

			<p><label>Calle: 
			<input  type="text" name="calle">
			</label></p>

			<p><label>Altura:  
			<input  type="text" name="altura">
			</label></p>

			<p><label>Torre: 
			<input  type="text" name="torre">
			</label></p>

			<p><label>Piso: 
			<input  type="text" name="piso">
			</label></p>

			<p><label>Manzana: 
			<input  type="text" name="manzana">
			</label></p>

			<p><label>Sector: 
			<input  type="text" name="sector">
			</label></p>

			<p><label>Parcela: 
			<input  type="text" name="parcela">
			</label></p>


			<p><button>Guardar</button></p>




		</form>
	</div>

	<script>
		$(function(){

			// Lista de Paises
			$.post( 'paises.php' ).done( function(respuesta)//.post -> 
			{
			$( '#paises' ).html( respuesta );
			});

			// lista de Provincias  
			$('#paises').change(function()
			{
				var el_pais = $(this).val();

			// Lista de Paises
			$.post( 'provincias.php', { pais: el_pais} ).done( function( respuesta )
			{
					$( '#provincias' ).html( respuesta );
				});
			});

			// Lista de Ciudades
			$( '#provincias' ).change( function()
			{
				//var pais = $(this).children('option:selected').html();

				//Nuevo codigo
				// Lista de Ciudades
			$.post( 'ciudades.php', { provincia: $( '#provincias' ).val()} ).done( 
			function( respuesta )
				{
					$( '#ciudades' ).html( respuesta );
				alert( 'Lista de ciudades ' + respuesta);
				});

			});
		});

	</script>

</body>
</html>
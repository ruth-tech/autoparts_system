<?php 
	$localidad = $conexion->query("SELECT * FROM barrios") or die ("Error de SQL");
		while ($row = $localidad->fetch_assoc()) {
			echo '<option VALUE="'.$row['barrio_id'].'">'.$row['barrio_nombre'].'</option>'  ;
		}

?>
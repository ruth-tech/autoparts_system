<?php 
	$provincia = $conexion->query("SELECT * FROM provincias") or die ("Error de SQL");
		while ($row = $provincia->fetch_assoc()) {
			echo '<option VALUE="'.$row['provincia_id'].'">'.$row['provincia_nombre'].'</option>'  ;
		}

?>
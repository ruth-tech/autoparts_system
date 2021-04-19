<?php 
	$localidad = $conexion->query("SELECT * FROM localidades") or die ("Error de SQL");
		while ($row = $localidad->fetch_assoc()) {
			echo '<option VALUE="'.$row['localidad_id'].'">'.$row['localidad_nombre'].'-CP:'.$row['localidad_codigo_postal'].'</option>'  ;
		}

?>
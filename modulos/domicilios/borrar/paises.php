<?php 
    $pais = $conexion->query("SELECT * FROM paises") or die ("Error de SQL");
		while ($row = $pais->fetch_assoc()) {
			echo '<option VALUE="'.$row['pais_id'].'">'.$row['pais_nombre'].'</option>'  ;
		}

?>
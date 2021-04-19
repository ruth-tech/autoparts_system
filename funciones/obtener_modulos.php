<?php

require_once '../php/conexion.php';

function obtener_modulos($persona_id) {
	// Es necesario esto ya que sino no es posible acceder a la conexión.
	// En este caso se convierte la variable conexion a una variable global.
	global $conexion;

	// Array vacío. Aquí agregaremos los módulos obtenidos.
	$modulos = [];

	// Consulta sql para obtener id y descrición dé los módulos.

	$sql = "SELECT modulos.modulo_id, modulos.modulo_descripcion, modulos.directorio FROM usuarios "."
			INNER JOIN perfiles ON perfiles.perfil_id = usuarios.rela_perfil "."
			INNER JOIN perfilxmodulo ON perfilxmodulo.rela_perfil = perfiles.perfil_id "."
			INNER JOIN modulos ON modulos.modulo_id = perfilxmodulo.rela_modulo"." 
			WHERE usuarios.rela_persona = ". $persona_id;

	$rs_modulos = mysqli_query($conexion, $sql);

	// Reccorro los registros y asigno los módulos al array.
	while ($row = $rs_modulos->fetch_assoc()) {
		//$modulos[$row["id"]] = $row["descripcion"];
		$arreglo = [
			'id' => $row['modulo_id'],
			'descripcion' => $row['modulo_descripcion'],
			'directorio' => $row['directorio']
		];

		$modulos[] = $arreglo;
	}

	// retorno los módulos obtenidos.
	return $modulos;
}

?>
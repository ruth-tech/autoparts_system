

<?php

const SERVIDOR = 'localhost';
const USUARIO = 'root';
const PASSWORD = '';
const DATABASE = 'autoparts_system_2020';

// Intento conectarme al servidor de base de datos
$conexion = mysqli_connect(SERVIDOR, USUARIO, PASSWORD, DATABASE);

// Si no pude conectarme, entonces muestro un mensaje de error y finaliza la ejecución
// La función die() muestra un mensaje y fianliza la ejecución
if (!$conexion) {
	die("Error en la conexión con el servidor de Base de Datos");
}

?>
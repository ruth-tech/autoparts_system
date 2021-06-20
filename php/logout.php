<?php
include 'conexion.php';
// Inicializar la sesión.
// Si está usando session_name("algo"), ¡no lo olvide ahora!
session_start();

$id = $_SESSION['id'];
$sql = "UPDATE historial_usuarios SET fecha_fin = NOW() WHERE
fecha_inicio =(SELECT MAX(fecha_inicio) FROM historial_usuarios WHERE rela_usuario = $id)AND rela_usuario = $id";
$rs_session = mysqli_query($conexion, $sql);
// Destruir todas las variables de sesión.
$_SESSION = array();

// Finalmente, destruir la sesión.
session_destroy();
header("Location: /autoparts_system/index.php ")
?>
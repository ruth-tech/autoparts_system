<?php
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'autoparts_system_2020');

$connexion = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

// $html = '';
$palabra = $_POST['palabra'];

$result = $connexion->query(
    'SELECT * FROM clientes 
    INNER JOIN personas_fisicas ON clientes.rela_persona_fisica= personas_fisicas.persona_fisica_id 
    WHERE clientes.estado=1
    AND personas_fisicas.apellidos_persona LIKE "%'.strip_tags($palabra).'%"
    OR personas_fisicas.nombres_persona LIKE "%'.strip_tags($palabra).'%"'
);

$lista = $result->fetch_all();
foreach($lista as $milista){
    // colocamos en negrita a los textos
    $cliente = str_replace($_POST["palabra"],'<b>'.$_POST["palabra"].'</b>',$milista["apellidos_persona"].' '.$milista["nombres_persona"]);
    // aqui agregamos las opciones
    echo '<li onclick="set_item(\''.str_replace("'","\'",$milista['rela_persona']).'\')">'.$cliente.'</li>';
}
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {                
//         $html .= '<div><a class="suggest-element" data="'.utf8_encode($row['apellidos_persona'].', '.$row['nombres_persona']).'" personaId='.$row['rela_persona'].'>'.utf8_encode($row['apellidos_persona'].', '.$row['nombres_persona']).'</a></div>';
//     }
// }
// echo $html;
?>

<!-- SELECT * FROM clientes 
INNER JOIN personas_fisicas ON clientes.rela_persona_fisica= personas_fisicas.persona_fisica_id 
WHERE clientes.estado=1
AND personas_fisicas.apellidos_persona LIKE "%'.strip_tags($key)'%"
AND personas_fisicas.nombres_persona LIKE "%'.strip_tags($key)'%" -->
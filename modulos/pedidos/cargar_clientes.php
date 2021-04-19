<?php
    if (isset($_GET['term'])){
    include '../../php/conexion.php';
    $return_arr = array();
    // SI EXISTE CONEXION A BD EJECUTAR LA CONSULTA
        if($conexion){
            $sql ="SELECT 
            c.cliente_id, pf.apellidos_persona, pf.nombres_persona, tc.tipo_contacto_descripcion, 
            pc.valor_contacto
            FROM clientes c
            INNER JOIN personas_fisicas pf ON c.rela_persona_fisica = pf.persona_fisica_id
            INNER JOIN persona_contacto pc ON pf.rela_persona = pc.rela_persona
            INNER JOIN tipo_contacto tc ON pc.rela_tipo_contacto = tc.tipo_contacto_id 
            WHERE pf.persona_dni LIKE '%".$_GET['term']."' AND c.estado=1";

            $res = $conexion->query($sql) or die($conexion->error);

            // RECORRER Y GUARDAR EN UN ARRAY LOS RESULTADOS DE LA CONSULTA
            while($row = mysqli_fetch_array($res)){
                $cliente_id = $row['cliente_id'];
                $row_array['cliente']=$row['apellidos_persona'].", ".$row['nombres_persona'];
                $row_array['tipo_contacto']=$row['tipo_contacto_descripcion'];
                $row_array['contacto']=$row['valor_contacto'];
                
                array_push($return_arr,$$row_array);
            }
        }
        echo json_encode($return_arr);
        // exit;
    }
?>
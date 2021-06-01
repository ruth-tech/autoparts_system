<?php
include '../../php/conexion.php';
    if($_POST['action'] == 'searchCliente'){
        // print_r($_POST);
        $return_arr = array();
        // echo "BUSCAR CLIENTE";
        if(!empty($_POST['cliente'])){
            $cliente = $_POST['cliente'];
            
            $sql ="SELECT 
            c.cliente_id AS id, CONCAT(pf.apellidos_persona,', ',pf.nombres_persona) AS cliente,
            pc.valor_contacto AS contacto, pd.barrio,pd.calle,pd.altura,pd.piso,pd.torre,pd.manzana,pd.sector,pd.parcela "  
            ." FROM clientes c"
            ." INNER JOIN personas_fisicas pf ON c.rela_persona_fisica = pf.persona_fisica_id"
            ." INNER JOIN persona_contacto pc ON pf.rela_persona = pc.rela_persona"
            ." INNER JOIN tipo_contacto tc ON pc.rela_tipo_contacto = tc.tipo_contacto_id" 
            ." INNER JOIN persona_domicilio pd ON pf.rela_persona = pd.rela_persona"
            ." WHERE c.estado=1 
             AND tc.tipo_contacto_descripcion = 'telefono celular'
             AND pc.estado = 1
             AND pd.estado = 1
             AND pf.persona_dni LIKE '".$cliente."' LIMIT 1";
             
            $res = $conexion->query($sql) or die($conexion->error);
            
            $result = mysqli_num_rows($res);
            $data = '';
            if($result > 0){
                // RECORRER Y GUARDAR EN UN ARRAY LOS RESULTADOS DE LA CONSULTA
                while($row = mysqli_fetch_array($res)){
                    $row_array['id'] = $row['id'];
                    $row_array['cliente']=$row['cliente'];
                    $row_array['contacto']=$row['contacto'];
                        $calle = (!empty($row['calle']))   ?  'Calle:'.$row['calle'] : "" ;
                        $altura = (!empty($row['altura']))   ?  'Altuta:'.$row['altura'] : "" ;
                        $torre = (!empty($row['torre']))   ?  'Torre:'.$row['torre'] : "" ;
                        $piso = (!empty($row['piso']))   ?  'Piso:'.$row['piso'] : "";
                        $manzana = (!empty($row['manzana']))   ?  'Mz:'.$row['manzana'] : "";
                        $sector = (!empty($row['sector']))   ?  'Sector:'.$row['sector'] : "" ;
                        $parcela = (!empty($row['parcela']))   ?  'Casa:'.$row['parcela'] : "" ;            
                    $row_array['domicilio']=$row['barrio']." ".$calle." ".$altura." ".$piso." ".$torre." ".$manzana." ".$sector." ".$parcela;
                    
                    
                    array_push($return_arr,$row_array);
                    
                };
                // echo $return_arr;
                $jsonstring = json_encode($return_arr);
                //     switch(json_last_error()) {
                //     case JSON_ERROR_NONE:
                //         echo ' - Sin errores';
                //     break;
                //     case JSON_ERROR_DEPTH:
                //         echo ' - Excedido tamaño máximo de la pila';
                //     break;
                //     case JSON_ERROR_STATE_MISMATCH:
                //         echo ' - Desbordamiento de buffer o los modos no coinciden';
                //     break;
                //     case JSON_ERROR_CTRL_CHAR:
                //         echo ' - Encontrado carácter de control no esperado';
                //     break;
                //     case JSON_ERROR_SYNTAX:
                //         echo ' - Error de sintaxis, JSON mal formado';
                //     break;
                //     case JSON_ERROR_UTF8:
                //         echo ' - Caracteres UTF-8 malformados, posiblemente codificados de forma incorrecta';
                //     break;
                //     default:
                //         echo ' - Error desconocido';
                //     break;
                // }
                echo $jsonstring;

            }else{
                echo 0;
            }            
        }
        exit;
    }
?>
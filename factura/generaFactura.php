<?php

	//rint_r($_REQUEST);p
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
	if (!isset($_SESSION["logueado"])) { 
		header("location: ../index.php?error=debe_loguearse");
		exit;
	}
	include '../php/conexion.php';
	require_once '../dompdf\autoload.inc.php';

	// print_r($_REQUEST);
	// exit;

	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conexion,	"SELECT parametro_nombre AS empresa,
														parametro_direccion AS domicilio,
														parametro_cuit_empresa AS cuit,
														parametro_nro_habilitacion AS habilitacion,
														parametro_email AS email,
														parametro_telefono AS telefono,
														parametro_rubro AS rubro,
														parametro_comerciante AS responsable,
														parametro_cuil_comerciante AS cuit_responsable
													FROM parametros_empresa");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}

		$query_iva = mysqli_query($conexion,"SELECT parametro_valor FROM parametros_impositivos WHERE parametro_descripcion = 'IVA'");
        $result_iva = mysqli_num_rows($query_iva);
		if ($result_iva > 0) {
			$iva_p = mysqli_fetch_assoc($query_iva);
		}

		$return_array=array(); 
		$query = mysqli_query($conexion,"SELECT CONCAT(pf.apellidos_persona,' ',nombres_persona) AS cliente,
											persona_dni AS dni,
											cliente_nro_cuenta AS no_cuenta,
											valor_contacto AS telefono,
											pd.barrio,calle,altura,piso,torre,manzana,sector,parcela,
											pe.pedido_id,DATE_FORMAT(pe.pedido_fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(pe.pedido_fecha, '%H:%i:%s') as hora,pedido_total,
											vw_e.nombreEmpleado AS empleado,
											f.no_factura
										FROM personas p
										INNER JOIN personas_fisicas pf ON p.persona_id = pf.rela_persona
										INNER JOIN clientes c ON c.rela_persona_fisica = pf.persona_fisica_id 
										INNER JOIN persona_contacto pc ON p.persona_id = pc.rela_persona
										INNER JOIN tipo_contacto tc ON pc.rela_tipo_contacto = tc.tipo_contacto_id
										INNER JOIN persona_domicilio pd ON p.persona_id = pd.rela_persona
										INNER JOIN pedidos pe ON pe.rela_cliente = c.cliente_id
										INNER JOIN facturas f ON pe.pedido_id = f.rela_pedido
										INNER JOIN usuarios u ON pe.rela_user = u.usuario_id
										INNER JOIN vw_empleado_nombre vw_e ON vw_e.usuarioid = pe.rela_user
										WHERE pc.estado = 1
										AND pd.estado = 1
										AND pe.rela_pedido_estado != 3
										AND tc.tipo_contacto_descripcion = 'telefono celular'
										AND pe.pedido_id = $noFactura
										AND c.cliente_id = $codCliente");
		
		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_pedido = $factura['pedido_id'];

			// if($factura['rela_pedido_estado'] == 2){
			// 	$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			// }

			$query_productos = mysqli_query($conexion,"SELECT p.producto_descripcion,dp.pedido_cantidad as cantidad,dp.precio_venta,(dp.pedido_cantidad * dp.precio_venta) AS precio_total 
															FROM detalle_pedido dp
															INNER JOIN pedidos ped ON ped.pedido_id = dp.rela_pedido
															INNER JOIN productos p ON dp.rela_producto = p.producto_id
															WHERE ped.pedido_id =$no_pedido");
															
			$result_detalle = mysqli_num_rows($query_productos);
// instantiate and use the dompdf class
$dompdf = new Dompdf();
			ob_start();
		    include_once 'factura.php';
		    $html = ob_get_clean();

			

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$no_pedido.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>
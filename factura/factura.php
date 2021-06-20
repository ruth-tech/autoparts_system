<?php
	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	$tl_sniva   = 0;
	$total 		= 0;
// print_r($configuracion);
// exit;
 ?>

<html>
<head>
	<meta>
	<title>Factura</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
<?php echo $anulada; ?>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="img/logo.jpg">
				</div>
			</td>
			<td class="info_empresa">
				<?php
					// $iva = $iva_p['parametro_valor'];
					// if($result_config > 0){
						
				 ?>
				<div>
					<span class="h2"><?php //echo strtoupper($configuracion['empresa']); ?></span>
					<p><?php //echo $configuracion['cuit']; ?></p>
					<p>Habilitacion N°:<?php //echo $configuracion['habilitacion']; ?></p>
					<p><?php echo //$configuracion['domicilio']; ?></p>
					<p>Teléfono: <?php //echo $configuracion['telefono']; ?></p>
					<p>Email: <?php //echo $configuracion['email']; ?></p>
				</div>
				<?php
					// }
				 ?>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura</span>
					<p>No. Factura: <strong><?php //echo $factura['no_factura']; ?></strong></p>
					<p>Fecha: <?php //echo $factura['fecha']; ?></p>
					<p>Hora: <?php //echo $factura['hora']; ?></p>
					<p>Vendedor: <?php //echo $factura['empleado']; ?></p>
				</div>
			</td>
		</tr>
	</table>
	<!-- <table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Cliente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>DNI:</label><p><?php echo $factura['dni']; ?></p></td>
							<td><label>Teléfono:</label> <p><?php echo $factura['telefono']; ?></p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p><?php echo $factura['cliente']; ?></p></td>
							<td><label>Dirección:</label> 
								<p>
									<?php 
										$barrio= $factura['barrio'];
										$calle = (!empty($factura['calle']))   ?  'Calle:'.$factura['calle'] : "" ;
										$altura = (!empty($factura['altura']))   ?  'Altura:'.$factura['altura'] : "" ;
										$torre = (!empty($factura['torre']))   ?  'Torre:'.$factura['torre'] : "" ;
										$piso = (!empty($factura['piso']))   ?  'Piso:'.$factura['piso'] : "";
										$manzana = (!empty($factura['manzana']))   ?  'Mz:'.$factura['manzana'] : "";
										$sector = (!empty($factura['sector']))   ?  'Sector:'.$factura['sector'] : "" ;
										$parcela = (!empty($factura['parcela']))   ?  'Casa:'.$factura['parcela'] : "" ; 
										echo $barrio.' '.$calle.' '.$altura.' '.$torre.' '.$piso.' '.$manzana.' '.$sector.' '.$parcela;
									?>
								</p>
							</td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table> -->

	<!-- <table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th class="textleft">Descripción</th>
					<th class="textright" width="150px">Precio Unitario.</th>
					<th class="textright" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php

				// if($result_detalle > 0){

				// 	while ($row = mysqli_fetch_assoc($query_productos)){
			 ?>
				<tr>
					<td class="textcenter"><?php //echo $row['cantidad']; ?></td>
					<td><?php// echo $row['producto_descripcion']; ?></td>
					<td class="textright"><?php //echo $row['precio_venta']; ?></td>
					<td class="textright"><?php//echo $row['precio_total']; ?></td>
				</tr>
			<?php
				// 		$precio_total = $row['precio_total'];
				// 		$subtotal = round($subtotal + $precio_total, 2);
				// 	}
				// }

				// $impuesto 	= round($subtotal * ($iva / 100), 2);
				// $tl_sniva 	= round($subtotal - $impuesto,2 );
				// $total 		= round($tl_sniva + $impuesto,2);
			?>
			</tbody>
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL</span></td>
					<td class="textright"><span><?php //echo '$ '.$tl_sniva; ?></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA (<?php //echo $iva; ?> %)</span></td>
					<td class="textright"><span><?php //echo '$ '.$impuesto; ?></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL</span></td>
					<td class="textright"><span><?php //echo '$ '.$total; ?></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div> -->

</div>

</body>
</html>
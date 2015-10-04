<?php error_reporting(E_ERROR); ?>
<br/>
<!-- barra de botones -->
<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Factura de Compra
			<?php
			if($consulta_facturacompra != FALSE){
				foreach($consulta_facturacompra as $enlace){
					echo "<a id='modificar' class='btn btn-default navbar-btn' href=".base_url()."facturacompra/modificar/".$enlace->facturacompra_id."><span class='glyphicon glyphicon-pencil'> Modificar</span></a>";
					echo " <a id='agregar' class='btn btn-default navbar-btn' href=".base_url()."comprobanteegreso/index/".$enlace->facturacompra_id."><span class='glyphicon glyphicon-usd'> Pagar</span></a>";
					break;
				}
			}else{
				return FALSE;
			} ?>
			
			<a href="javascript:history.back()" class="btn btn-default" title="VOLVER"><span class="glyphicon glyphicon-circle-arrow-left"> Atras</span></a></p>
</nav>
<!-- fin de la barra de botones -->

<!-- creación de la tabla con formato bootstrap 3 -->
	<?php
	if($consulta_facturacompra != FALSE){
		/*plantilla para la tabla*/
		$plantilla = array('table_open' => '<table class="table table-hover table-bordered">');
		echo $this->table->set_template($plantilla);
		/*------------------------------------------------------------------------------------------------------*/
																			/*FACTURA DE COMPRA*/
		/*------------------------------------------------------------------------------------------------------*/
		echo "<h3 align='center'>Factura de Compra</h3>";
		foreach ($consulta_facturacompra as $mostrar){
			$myDateTime = DateTime::createFromFormat('Y-m-d', $mostrar->facturacompra_fecha);
			$fecha = $myDateTime->format('d-m-Y');
			$myDateTime = DateTime::createFromFormat('Y-m-d', $mostrar->facturacompra_fechavencimiento);
			$fechavencimiento = $myDateTime->format('d-m-Y');

			echo '
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th><label>Factura</label></th>
						<th><label>Nombre Beneficiario</label></th>
						<th><label>Fecha de creación</label></th>
						<th><label>Fecha de vencimiento</label></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.$mostrar->facturacompra_id.'</td>
						<td>'.$mostrar->relacion_nombre.'</td>
						<td>'.$fecha.'</td>
						<td>'.$fechavencimiento.'</td>
					</tr>
					<tr><td colspan="4"><label>Observación :</label> '.$mostrar->facturacompra_observacion.'</td></tr>
				</tbody>
			</table>';
			break;
		}
		/*-----------------------------------------------------------------------------------------*/
																			/*DETALLE DE LA FACTURA*/
		/*-----------------------------------------------------------------------------------------*/
		echo "<h3 align='center'>Detalle Factura de Compra</h3>";
		$this->table->set_heading('Categoría','Precio','Descuento','Impuesto','Cantidad','Total');
		$subtotal = 0;
		$descuento = 0;
		foreach ($consulta_facturacompra as $mostrar){
			$subtotal = ($mostrar->detalleproducto_precio*$mostrar->detalleproducto_cantidad);
			$descuento = $subtotal*($mostrar->detalleproducto_descuento/100);
			$this->table->add_row(
			$mostrar->producto_nombre,
			'$ '.number_format($mostrar->detalleproducto_precio),
			$mostrar->detalleproducto_descuento.' %',
			$mostrar->impuesto_nombre,
			$mostrar->detalleproducto_cantidad,
			'$ '.number_format($subtotal - $descuento)
			);
		}
		foreach ($detallepuc as $key => $value) {
			$this->table->add_row(
				$value['puc_nombre'],
				'$ '.number_format($value['dpuc_precio']),
				$value['dpuc_descuento'].' %',
				$value['impuesto_nombre'],
				$value['dpuc_cantidad'],
				'$ '.number_format($value['dpuc_total'] - (($value['dpuc_total']*$value['dpuc_descuento'])/100))
      );
		}
		echo $this->table->generate();
		/*------------------------------------------------------------------------------------------------------*/
																		/*TOTALES Y RESULTADOS DE LA FACTURA*/
		/*------------------------------------------------------------------------------------------------------*/
		$this->table->set_heading('Subtotal','Descuento','Subtotal','IVA','Total','Valor retenido','Por pagar','Valor pagado');
		$list = array(
	    '$ '.number_format($consulta_facturacompra[0]->fc_subtotal_sin_desc).'',
	    '- $ '.number_format($consulta_facturacompra[0]->fc_descuento).'',
	    '$ '.number_format($consulta_facturacompra[0]->fc_subtotal).'',
	    '$ '.number_format($consulta_facturacompra[0]->fc_iva).'',
	    '$ '.number_format($consulta_facturacompra[0]->fc_total).'',
	    '$ '.number_format($consulta_facturacompra[0]->fc_val_rete).'',
	    '<div id="estilo_x_pagar">$ '.number_format($consulta_facturacompra[0]->fc_x_pagar,2).'</div>',
	    '<div id="estilo_val_pagado">$ '.number_format($consulta_facturacompra[0]->fc_val_pagado,2).'</div>'
    );

		$new_list = $this->table->make_columns($list, 8);
		echo $this->table->generate($new_list);
		$this->table->clear();
		/*-----------------------------------------------------------------------------------------*/
																	/*DATOS DEL COMPROBANTE DE EGRESO*/
		/*-----------------------------------------------------------------------------------------*/
		
		if ($consulta_comprobante != FALSE) {
			echo "<h3 align='center'>Datos del Comprobante de Egreso</h3>";
			$this->table->set_heading('Fecha','Comprobante de egreso #','Monto','Observaciones');
			foreach ($consulta_comprobante as $row) {
				$this->table->add_row(
					$row->ce_fecha,
					$row->ce_id,
					'$ '.number_format($row->fc_val_pagar,2),
					$row->ce_observacion
				);
			}
			echo $this->table->generate();
			$this->table->clear();
		}
		/*-----------------------------------------------------------------------------------------*/
	}else {
		return FALSE;
	} ?>

	<script type="text/javascript">
		$(document).ready(function(){
			/*si el valor por pagar es diferente de cero entonces se colorea de rojo y el pagado de negro*/
			if ($("#estilo_x_pagar").html() != '$ 0.00') {
				$("#estilo_x_pagar").css("color","red");
				$("#estilo_val_pagado").css("color","black");
			}/*de lo contrario el valor por pagar se colorea de negro y el pagado de verde*/
			else {
				$("#estilo_x_pagar").css("color","black");	
				$("#estilo_val_pagado").css("color","#6CDD22");
				$('#modificar').remove();
				$('#agregar').remove();
			}
		});
	</script>
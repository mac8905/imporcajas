
	<br/>
		<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Factura de Venta</p>
		<?php
			if($consulta_facturaventa != FALSE){
				foreach($consulta_facturaventa as $enlace){
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."facturaventa/modificar/".$enlace->facturav_id.">Modificar</a>";
					echo " ";
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."facturaventaImprimirPDF/index/".$enlace->facturav_id." target='_blank'>Imprimir</a>";
					echo " ";
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."facturaventaDescargarPDF/index/".$enlace->facturav_id.">Descargar</a>";
					break;
				}
			}else{
				return FALSE;
			}
		?>
		</nav>
		
		<?php
			if($consulta_facturaventa != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover table-bordered">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Factura de Venta'."</h3>");
				foreach ($consulta_facturaventa as $mostrar){
				
					$myDateTime = DateTime::createFromFormat('Y-m-d', $mostrar->facturav_fecha);
					$fecha = $myDateTime->format('d-m-Y');
					$myDateTime = DateTime::createFromFormat('Y-m-d', $mostrar->facturav_fechavencimiento);
					$fechavencimiento = $myDateTime->format('d-m-Y');
				
					$this->table->add_row("<label>Número de Factura : ".$mostrar->facturav_id."</label>");
					$this->table->add_row("<label>Nombre : ".$mostrar->relacion_nombre."</label>");
					$this->table->add_row("<label>Fecha de creación : ".$fecha."</label>");
					$this->table->add_row("<label>Fecha de vencimiento : ".$fechavencimiento."</label>");
					$this->table->add_row("<label>Observación : ".$mostrar->facturav_observacion."</label>");
					$this->table->add_row("<label>Descripción : ".$mostrar->facturav_descripcion."</label>");
					break;
				}
				echo $this->table->generate();
				
				$this->table->clear();
				
				//-----------------------------------
				// Detalle de la factura de venta
				//-----------------------------------
				
				$this->table->set_heading('Productos','Tamaño','Precio','Descuento','Impuesto','Cantidad','Total');
				$subtotal = 0;
				$descuento = 0;
				foreach ($consulta_facturaventa as $mostrar){
					$subtotal = ($mostrar->detalleproducto_precio*$mostrar->detalleproducto_cantidad);
					$descuento = $subtotal*($mostrar->detalleproducto_descuento/100);
					$this->table->add_row(
					$mostrar->producto_nombre,
					$mostrar->detalleproducto_tamano,
					"$ ".number_format($mostrar->detalleproducto_precio,2),
					$mostrar->detalleproducto_descuento,
					$mostrar->impuesto_nombre,
					$mostrar->detalleproducto_cantidad,
					"$ ".number_format($subtotal - $descuento,2)
					);
				}
				echo $this->table->generate();
				
				$this->table->clear();
				
				//--------------------------------------
				//Totales de la factura de venta
				//--------------------------------------

					$this->table->set_heading('Subtotal','Descuento','Subtotal','IVA','Valor retenido','Total','Por pagar','Valor pagado');
					$list = array(
		              '$ '.number_format($consulta_facturaventa[0]->fv_subtotal_sin_desc,2).'',
		              '- $ '.number_format($consulta_facturaventa[0]->fv_descuento,2).'',
		              '$ '.number_format($consulta_facturaventa[0]->fv_subtotal,2).'',
		              '$ '.number_format($consulta_facturaventa[0]->fv_iva,2).'',
					  '$ '.number_format($consulta_facturaventa[0]->fv_val_ret,2).'',
		              '$ '.number_format($consulta_facturaventa[0]->fv_total,2).'',		       
		              '<div id="estilo_x_pagar">$ '.number_format($consulta_facturaventa[0]->fv_x_pagar,2).'</div>',
		              '<div id="estilo_val_pagado">$ '.number_format($consulta_facturaventa[0]->fv_val_pagado,2).'</div>'
		              );

		$new_list = $this->table->make_columns($list, 8);
		echo $this->table->generate($new_list);
		$this->table->clear();
		
		//------------------------------------------------------------------
		//						DATOS DEL RECIBO DE CAJA
		//------------------------------------------------------------------
		if ($consulta_recibo != FALSE) {
			echo "<h3 align='center'>Datos del Recibo de Caja</h3>";
			$this->table->set_heading('Fecha','Recibo de caja #','Monto','Observaciones');
			foreach ($consulta_recibo as $row) {
				$this->table->add_row(
					$row->recibocaja_fecha,
					$row->recibocaja_id,
					'$ '.number_format($row->fv_val_pagar,2),
					$row->recibocaja_observacion
				);
			}
			echo $this->table->generate();
			$this->table->clear();
		}
				
			}else{
				return FALSE;
			}
		?>
		</div>

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

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url()?>css1/bootstrap.css" type="text/css" rel="stylesheet">
	</head>
	<body>
	<br/>
		<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Recibo de Caja</p>
		<?php
			if($consulta_recibocaja != FALSE){
				foreach($consulta_recibocaja as $enlace){
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."recibocaja/modificar/".$enlace->recibocaja_id."> Modificar</a>";
					echo " ";
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."recibocajaImprimirPDF/index/".$enlace->recibocaja_id." target='_blank'><span class='glyphicon glyphicon-print'></span>  Imprimir</a>";
					break;
				}
			}else{
				return FALSE;
			}
		?>
		</nav>
		
		<?php
			if($consulta_recibocaja != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Recibo de Caja'."</h3>");
				foreach ($consulta_recibocaja as $mostrar){
					$this->table->add_row("<label>Número : ".$mostrar->recibocaja_id."</label>");
					$this->table->add_row("<label>Nombre : ".$mostrar->relacion_nombre."</label>");
					$this->table->add_row("<label>Fecha : ".$mostrar->recibocaja_fecha."</label>");
					$this->table->add_row("<label>Observación : ".$mostrar->recibocaja_observacion."</label>");
					$this->table->add_row("<label>Método de pago : ".$mostrar->metodopago_nombre."</label>");
					break;
				}
				echo $this->table->generate();
				
				$this->table->clear();
				
				$this->table->set_heading('Cuenta','Precio','Impuesto','Cantidad','Total');
				$subtotal = 0;
				$total = 0;
				foreach ($consulta_recibocaja as $mostrar){
					$subtotal = ($mostrar->detallerecibo_valor*$mostrar->detallerecibo_cantidad);
					$subtotalimpuesto = ($subtotal*($mostrar->impuesto_porcentaje/100));
					$total = $subtotal + $subtotalimpuesto;
					$this->table->add_row(
						$mostrar->puc_nombre,
						"$ ".number_format($mostrar->detallerecibo_valor,2),
						$mostrar->impuesto_nombre,
						$mostrar->detallerecibo_cantidad,
						"$ ".number_format($total,2)
					);
				}
				echo $this->table->generate();	
				
				$this->table->clear();
				
				//Mostrar Subtotal
				$subtotal1 = 0;
				foreach ($consulta_recibocaja as $mostrar){
					$sub = ($mostrar->detallerecibo_valor*$mostrar->detallerecibo_cantidad);
					$des = ($sub*($mostrar->impuesto_porcentaje/100));
					$subtotal1 = $subtotal1 + ($sub + $des);	
				}
				$this->table->add_row("<label>Subtotal : $ ".number_format($subtotal1,2)."</label>");				
				//Fin mostrar subtotal
				
				//Mostrar Retenciones
				foreach ($consulta_retencion as $retencion){
					$this->table->add_row("<label>".$retencion->retencion_nombre." : $ - ".number_format($retencion->retencion_valor,2)."</label>");
				}
								
				//Fin mostrar retenciones
				
				//Mostrar total
				$subtotal1 = 0;
				foreach ($consulta_recibocaja as $mostrar){
					$sub = ($mostrar->detallerecibo_valor*$mostrar->detallerecibo_cantidad);
					$des = ($sub*($mostrar->impuesto_porcentaje/100));
					$subtotal1 = $subtotal1 + ($sub + $des);	
				}
				$subtotal2 = 0;
				foreach($consulta_retencion as $retencion){
					$subtotal2 = $subtotal2 + $retencion->retencion_valor;
				}
				$totales = $subtotal1 - $subtotal2;
				$this->table->add_row("<label>Total : $ ".number_format($totales,2)."</label>");
				//Fin mostrar total
				
				echo $this->table->generate();
			}else{
				return FALSE;
			}
		?>
		</div>
	</body>
</html>
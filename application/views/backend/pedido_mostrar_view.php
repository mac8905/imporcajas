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
			<p class="navbar-text">Pedidos</p>
		<?php
			if($consulta_pedido != FALSE){
				foreach($consulta_pedido as $enlace){
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."pedido/modificar/".$enlace->pedido_id.">Modificar</a>";
					echo " ";
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."pedidoPDF/index/".$enlace->pedido_id." target='_blank'>Imprimir</a>";
					echo " ";
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."pedidoDescarga/index/".$enlace->pedido_id.">Descargar</a>";
					break;
				}
			}else{
				return FALSE;
			}
		?>
		</nav>
		
		<?php
			if($consulta_pedido != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Pedido'."</h3>");
				foreach ($consulta_pedido as $mostrar){
					$this->table->add_row("<label>Nombre : ".$mostrar->relacion_nombre."</label>");
					$this->table->add_row("<label>Fecha de creación : ".$mostrar->pedido_fecha."</label>");
					$this->table->add_row("<label>Fecha de vencimiento : ".$mostrar->pedido_fechavencimiento."</label>");
					$this->table->add_row("<label>Observación : ".$mostrar->pedido_observacion."</label>");
					$this->table->add_row("<label>Descripción : ".$mostrar->pedido_descripcion."</label>");
					break;
				}
				echo $this->table->generate();
				
				$this->table->clear();
				
				$this->table->set_heading('Productos','Tamaño','Precio','Descuento','Impuesto','Cantidad','Total');
				$subtotal = 0;
				$descuento = 0;
				foreach ($consulta_pedido as $mostrar){
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
				//Mostrar Subtotal
				$subtotal = 0;
				foreach ($consulta_pedido as $mostrar){
					$sub = ($mostrar->detalleproducto_precio*$mostrar->detalleproducto_cantidad);
					$des = ($sub*($mostrar->detalleproducto_descuento/100));
					$subtotal = $subtotal+ ($sub - $des);	
				}
				$this->table->add_row("<label>Subtotal : $ ".number_format($subtotal,2)."</label>");
				//Mostrar Descuento
				$descuento = 0;
				foreach($consulta_pedido as $row){
					$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
					$descuento = $descuento +($sub*($row->detalleproducto_descuento/100));
				}
				$this->table->add_row("<label>Descuento : - $ ".number_format($descuento,2)."</label>");
				//Mostrar el IVA
				$subIva = 0;
				foreach($consulta_pedido as $row){
					$impuesto = $row->impuesto_id;
					$data = $this->impuesto_model->obtenerDatos($impuesto);
					
					foreach($data as $row1){
						$porcentaje = $row1->impuesto_porcentaje;
					}				
						$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
						$des = ($sub*($row->detalleproducto_descuento/100));
						$subdes = $sub - $des;
						$iva = ($subdes*($porcentaje/100));
						$subIva = $subIva + $iva;				
				}
				$this->table->add_row("<label>IVA : $ ".number_format($subIva,2)."</label>");
				//Mostrar Total
				$total = 0;
				foreach($consulta_pedido as $row){
					$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
					$des = ($sub*($row->detalleproducto_descuento/100));
					$subdes = $sub - $des;
					$iva = ($subdes*($porcentaje/100));
					$total = $total + $subdes;
				}
				$total1=$total+$subIva;
				$this->table->add_row("<label>Total : $ ".number_format($total1,2)."</label>");
				echo $this->table->generate();				
			}else{
				return FALSE;
			}
		?>
		</div>
	</body>
</html>
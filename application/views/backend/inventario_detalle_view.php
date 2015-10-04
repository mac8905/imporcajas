
	<br/>
		<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Detalle de Ventas y Compras del producto</p>
			<!--<a class="btn btn-default navbar-btn" href="#" >Crear Factura de Venta</a>-->
		</nav>
		<div class="col-md-6 col-lg-6">
		<?php
			if($consulta_detalle_venta != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Ventas'."</h3>");

			
				foreach ($consulta_detalle_venta as $mostrar){
					$this->table->add_row("<label style='color:red'>Nombre : ".$mostrar->producto_nombre."</label>");
					break;
				}
				$total = 0;
				foreach ($consulta_detalle_venta as $mostrar){
					$this->table->add_row("<label style='color:green'>Número de la factura de venta : ".$mostrar->facturav_id."</label>");
					$this->table->add_row("<label>Fecha de creación : ".$mostrar->facturav_fecha."</label>");
					$this->table->add_row("<label>Cantidad vendida : ".$mostrar->detalleproducto_cantidad."</label>");
					$this->table->add_row("<label>Valor Unitario : ".$mostrar->detalleproducto_precio."</label>");
					
					$total = $total + $mostrar->detalleproducto_cantidad;
				}
				
				$this->table->add_row("<label style='color:blue'>Cantidad total de cajas vendidas : ".$total."</label>");
				echo $this->table->generate();
				echo $this->table->clear();
				 
				 $acumulador = 0;
				 
			}else{
				return "No hay datos";
			}
		?>
		</div>
		
		<div class="col-md-6 col-lg-6">
		<?php
			if($consulta_detalle_compra != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Compras'."</h3>");

			
				foreach ($consulta_detalle_compra as $mostrar){
					$this->table->add_row("<label style='color:red'>Nombre : ".$mostrar->producto_nombre."</label>");
					break;
				}
				$total = 0;
				foreach ($consulta_detalle_compra as $mostrar){
					$this->table->add_row("<label style='color:green'>Número de la factura de compra : ".$mostrar->facturacompra_id."</label>");
					$this->table->add_row("<label>Fecha de creación : ".$mostrar->facturacompra_fecha."</label>");
					$this->table->add_row("<label>Cantidad vendida : ".$mostrar->detalleproducto_cantidad."</label>");
					$this->table->add_row("<label>Valor Unitario : ".$mostrar->detalleproducto_precio."</label>");
					
					$total = $total + $mostrar->detalleproducto_cantidad;
				}
				
				$this->table->add_row("<label style='color:blue'>Cantidad total de cajas compradas : ".$total."</label>");
				echo $this->table->generate();
				 echo $this->table->clear();
				 
				 
				 
				 $acumulador = 0;
				 
			}else{
				return "No hay datos";
			}
		?>
		</div>
		
		</div>
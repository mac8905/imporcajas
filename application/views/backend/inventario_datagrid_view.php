<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text" style="color:blue; font-family:Arial; font-size:17px">Total de Inventario</p>
	</nav>
	<?php
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			$this->table->set_heading('Nombre','Descripción','Cantidad Inicial','Cantidad Venta','Cantidad Compra','Total Cajas');
			echo $this->table->set_template($plantilla);
			$promedio = 0;
			$totalcajas = 0;
			$totalmonetario = 0;
			$total = 0;
			$totalvalor = 0;
			foreach($inventario as $row){
				$this->table->add_row(
				/*"<a href=".base_url()."productos/consultarFacturas/".$row->producto_id."><span class='glyphicon glyphicon-search'></span></a>",*/
				"<a href=".base_url()."productos/kardex/".$row->producto_id."><span>"
					.$row->producto_nombre."</span></a>",
					$row->producto_descripcion,
					$row->cantidad_inicial,
					$row->cantidad_venta,
					$row->cantidad_compra,
					//"$ ".number_format($promedio = (($row->total_producto+$row->total_compra)/$row->total_numerocajas),2),
					$totalcajas = $row->total_cajas
					//"$ ".number_format($totalmonetario = ($promedio * $totalcajas),2) 
				);
				$total += $totalcajas;
				$totalvalor += $totalmonetario;
			}
			echo $this->table->generate();
			$this->table->clear();

			$this->table->add_row("<label style='color:green; font-family:Arial; font-size:15px'>CANTIDAD TOTAL DE CAJAS : ".$total."</label>");
			//$this->table->add_row("<label>Valor total de cajas : $ ".number_format($totalvalor,2)."</label>");
			
			echo $this->table->generate();
			echo $this->pagination->create_links();
			
	?>

</div>
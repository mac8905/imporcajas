
	<br/>
		<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Detalle de transacciones del producto</p>
			<!--<a class="btn btn-default navbar-btn" href="#" >Crear Factura de Venta</a>-->
		</nav>
		
		<?php
		
			if($consulta_detalle_kardex != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("Producto","Entrada Inicial","Valor Unitario","Valor Total");

				$valorinicial = 0;
				foreach ($consulta_detalle_kardex as $mostrar){
					$this->table->add_row("<label style='color:red'> ".$mostrar->producto_nombre."</label>",
					"<label>".$mostrar->cantidad_inicial."</label>",
					"<label>".number_format($mostrar->costo_inicial,2)."</label>",
					"<label>".number_format($valorinicial = $mostrar->costo_inicial * $mostrar->cantidad_inicial,2)."</label>"
					);
					break;
				}
				
				echo $this->table->generate();
				//echo $this->table->clear();
				
				$totalfacturaventa = 0;
				$totalfacturacompra = 0;
				$totalcantidad = 0;
				$valor = 0;
				$totalvalor = 0;
				
				echo "<div class='table-responsive'>";
				echo "<table class='table table-hover'>";
				echo "<tbody>";
					echo "<thead>";
					echo "<tr>";
					echo "<th colspan='2' style='text-align:center'>DETALLE</th>";
					echo "<th colspan='2' style='text-align:center'>INGRESOS</th>";
					echo "<th colspan='2' style='text-align:center'>EGRESOS</th>";
					echo "<th colspan='3' style='text-align:center'>SALDO</th>";
					echo "</tr>";
					echo "</thead>";
					
					echo "<tr>";
					echo "<th style='text-align:center'>Fecha</th>";
					echo "<th style='text-align:center'>Descripción</th>";
					echo "<th style='color:green;text-align:center'>Cantidad</th>";
					//echo "<th style='color:green;text-align:center'>Valor Unitario</th>";
					echo "<th style='color:green;text-align:center'>Valor Total</label>";
					echo "<th style='color:orange;text-align:center'>Cantidad</label>";
					//echo "<th style='color:orange;text-align:center'>Valor Unitario</label>";
					echo "<th style='color:orange;text-align:center'>Valor Total</label>";
					echo "<th style='color:#4D4DFF;text-align:center'>Cantidad</label>";
					echo "<th style='color:#4D4DFF;text-align:center'>Total</label>";
					echo "<th style='color:#4D4DFF;text-align:center'>Promedio</label>";
					echo "</tr>";					
					
				foreach($consulta_detalle_kardex as $key => $mostrar){
					if($key == 0){
						//Muestra el valor unitario de la factura venta debido al costo inicial de producto
						$valorventainicial = $mostrar->costo_inicial;
						//Muestra el total de la factura de venta, multiplica la cantidad digitada por el usuario * costo_inicial del producto
						$totalfacturaventa = $mostrar->cantidadfacturaventa * $valorventainicial;
						//Muestra la cantidad contando con la cantidad inicial del producto
						$totalcantidad = $totalcantidad + ($mostrar->cantidad_inicial)+($mostrar->cantidadfacturacompra - $mostrar->cantidadfacturaventa);
						//Muestra las operaciones de la fila, opera y otorga el resultado
						$valor = $valor + ($mostrar->costo_inicial * $mostrar->cantidad_inicial) + ($mostrar->cantidadfacturacompra * $mostrar->valorfacturacompra) - ($mostrar->cantidadfacturaventa*$mostrar->costo_inicial);	
					}
					else{
						if($mostrar->cantidadfacturaventa > 0)
						{
							$valorventainicial = $totalvalor;
						}else{
							$valorventainicial = 0;
						}
						$totalfacturaventa = $mostrar->cantidadfacturaventa*$totalvalor;	
						$totalcantidad = $totalcantidad +($mostrar->cantidadfacturacompra - $mostrar->cantidadfacturaventa);
						$valor = $valor + ($mostrar->cantidadfacturacompra * $mostrar->valorfacturacompra) - ($mostrar->cantidadfacturaventa*$totalvalor);
					}
					
					if($mostrar->facturav_id != null){
						$numerofactura = "<a href=".base_url()."facturaventa/consultar/".$mostrar->facturav_id."><span> Fact. de venta Nº ".$mostrar->facturav_id."</span></a>";
					}else{
						$numerofactura = "<a href=".base_url()."facturacompra/consultar/".$mostrar->facturacompra_id."><span> Fact. de compra Nº ".$mostrar->facturacompra_id."</span></a>";
					}
					
					$myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $mostrar->fechafacturaventa);
					$fecha = $myDateTime->format('d-m-Y');					
					
					//$this->table->add_row(
					
					echo "<tr style='text-align:center'>";
					echo  "<td>".$fecha."</td>";
						//$mostrar->fechafacturacompra,
					echo "<td>".$numerofactura."</td>";
						//Entradas
					echo "<td>".$mostrar->cantidadfacturacompra."</td>";
					//echo "<td>".number_format($mostrar->valorfacturacompra,2)."</td>";
					echo "<td>".number_format($totalfacturacompra = $mostrar->cantidadfacturacompra * $mostrar->valorfacturacompra,2)."</td>";
						//Salidas o datos de factura de venta
					echo "<td>".$mostrar->cantidadfacturaventa."</td>";//Cantidad
					//echo "<td>".number_format($valorventainicial,2)."</td>";//Valor unitario
					echo "<td>".number_format($totalfacturaventa,2)."</td>";//Valor total
						//Existencias
					echo "<td>".$totalcantidad."</td>";
					echo "<td>".number_format($valor,2)."</td>";
					echo "<td>".number_format($totalvalor = ($valor / $totalcantidad),2)."</td>";
					echo "</tr>";
					//);						
				}
				
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
				//echo $this->table->generate();
		
			}else{
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("Producto","Entrada Inicial","Valor Unitario","Valor Total");

				$valorinicial = 0;
				foreach ($consulta_detalle_solo_kardex as $row){
					$this->table->add_row("<label style='color:red'> ".$row->producto_nombre."</label>",
					"<label>".$row->cantidad_inicial."</label>",
					"<label>".number_format($row->costo_inicial,2)."</label>",
					"<label>".number_format($valorinicial = $row->costo_inicial * $row->cantidad_inicial,2)."</label>"
					);
					break;
				}
				
				echo $this->table->generate();
				echo $this->table->clear();
			}
		?>
		</div>

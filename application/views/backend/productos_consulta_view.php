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
			<p class="navbar-text">Producto de Venta</p>
			<!--<a class="btn btn-default navbar-btn" href="#" >Crear Factura de Venta</a>-->
		<?php
			if($consulta_productos != FALSE){
				foreach($consulta_productos as $enlace){
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."productos/modificar/".$enlace->producto_id.">Modificar</a>";
				}
			}else{
				return FALSE;
			}
		?>
		</nav>
		
		<?php
			if($consulta_productos != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Producto'."</h3>");
				foreach ($consulta_productos as $mostrar){
					$this->table->add_row("<label>Código : ".$mostrar->producto_id."</label>");
					$this->table->add_row("<label>Nombre : ".$mostrar->producto_nombre."</label>");
					$this->table->add_row("<label>Alto : ".$mostrar->dimension_alto."</label>");
					$this->table->add_row("<label>Ancho : ".$mostrar->dimension_ancho."</label>");
					$this->table->add_row("<label>Largo : ".$mostrar->dimension_largo."</label>");
					$this->table->add_row("<label>Costo : $ ".number_format($mostrar->producto_costo,2)."</label>");
					$this->table->add_row("<label>Precio de Venta : $ ".number_format($mostrar->producto_precioventa,2)."</label>");
					$this->table->add_row("<label>Impuesto : ".$mostrar->impuesto_porcentaje."</label>");
					$this->table->add_row("<label>Cantidad : ".$mostrar->producto_cantidadinicial."</label>");
					$this->table->add_row("<label>Descripción : ".$mostrar->producto_descripcion."</label>");
				}
				echo $this->table->generate();
			}else{
				return FALSE;
			}
		?>
		</div>
	</body>
</html>
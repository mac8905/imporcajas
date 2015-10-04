	<br/>
		<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Clientes</p>
			<a class="btn btn-default navbar-btn" href="#" >Crear Factura de Venta</a>
		<?php
			if($consulta_cliente != FALSE){
				foreach($consulta_cliente as $enlace){
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."cliente/modificar/".$enlace->relacion_id.">Modificar</a>";
				}
			}else{
				return FALSE;
			}
		?>
		</nav>
		
		<?php
			if($consulta_cliente != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Datos del Contacto'."</h3>");
				foreach ($consulta_cliente as $mostrar){
					$this->table->add_row("<label>Nombre : ".$mostrar->relacion_nombre."</label>");
					$this->table->add_row("<label>Régimen : ".$mostrar->regimen_nombre."</label>");
					$this->table->add_row("<label>Nit : ".$mostrar->relacion_nit."</label>");
					$this->table->add_row("<label>Ciudad : ".$mostrar->relacion_ciudad."</label>");
					$this->table->add_row("<label>Dirección : ".$mostrar->relacion_direccion."</label>");
					$this->table->add_row("<label>Correo Electrónico : ".$mostrar->relacion_correo."</label>");
					$this->table->add_row("<label>Teléfono : ".$mostrar->telefono."</label>");
					$this->table->add_row("<label>Móvil : ".$mostrar->relacion_movil."</label>");
					$this->table->add_row("<label>Fax : ".$mostrar->relacion_fax."</label>");
					$this->table->add_row("<label>Observación : ".$mostrar->relacion_observacion."</label>");
				}
				echo $this->table->generate();
			}else{
				return FALSE;
			}
		?>
		</div>
<br/>
	<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Grupo</p>
	<?php
		if($consulta_subcuenta != FALSE){
			foreach($consulta_subcuenta as $enlace){
				echo "<a class='btn btn-default navbar-btn' href=".base_url()."subcuenta/modificar/".$enlace->puc_id.">Modificar</a>";
			}
		}else{
			return FALSE;
		}
	?>
	</nav>
	
	<?php
		if($consulta_subcuenta != FALSE){
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading("<h3 align='center'>".'Subcuenta'."</h3>");
			foreach ($consulta_subcuenta as $mostrar){
				$this->table->add_row("<label>Nombre : ".$mostrar->puc_id."</label>");
				$this->table->add_row("<label>Perfil : ".$mostrar->puc_nombre."</label>");
				$this->table->add_row("<label>Descripción : ".$mostrar->puc_descripcion."</label>");
			}
			echo $this->table->generate();
		}else{
			return FALSE;
		}
	?>
	</div>

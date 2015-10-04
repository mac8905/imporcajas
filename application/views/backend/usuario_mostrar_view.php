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
			<p class="navbar-text">Usuario</p>
		<?php
			if($consulta_usuario != FALSE){
				foreach($consulta_usuario->result() as $enlace){
					echo "<a class='btn btn-default navbar-btn' href=".base_url()."usuario/modificar/".$enlace->usuario_id.">Modificar</a>";
				}
			}else{
				return FALSE;
			}
		?>
		</nav>
		
		<?php
			if($consulta_usuario != FALSE){
				$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
				echo $this->table->set_template($plantilla);
				$this->table->set_heading("<h3 align='center'>".'Datos del Usuario'."</h3>");
				foreach ($consulta_usuario->result() as $mostrar){
					$this->table->add_row("<label>Nombre : ".$mostrar->usuario_nombre."</label>");
					$this->table->add_row("<label>Perfil : ".$mostrar->perfil_nombre."</label>");
					$this->table->add_row("<label>Ciudad : ".$mostrar->usuario_ciudad."</label>");
					$this->table->add_row("<label>Direccion : ".$mostrar->usuario_direccion."</label>");
					$this->table->add_row("<label>Correo Electrónico : ".$mostrar->usuario_correo."</label>");
					$this->table->add_row("<label>Móvil : ".$mostrar->usuario_movil."</label>");
					$this->table->add_row("<label>Teléfono :".$mostrar->telefono_numero."</label>");
				}
				echo $this->table->generate();
			}else{
				return FALSE;
			}
		?>
		</div>
	</body>
</html>
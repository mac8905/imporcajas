<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Método de Pago</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>metodopago/index">Nuevo Método de Pago</a>
	</nav>
	<?php
		if($tabla_metodopago != ""){
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			$this->table->set_heading('Nombre','Descripción','Acciones');
			echo $this->table->set_template($plantilla);
			foreach ($tabla_metodopago as $row){
				$this->table->add_row(
					$row->metodopago_nombre,$row->metodopago_descripcion,
					"<a href=".base_url()."metodopago/modificar/".$row->metodopago_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."metodopago/eliminar/".$row->metodopago_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
				);
			}
			echo $this->table->generate();
		}else{
			return FALSE;
		}
	?>
</div>
	<script type="text/javascript">
	function confirma(){
		if (confirm("¿Desea eliminar el registro de método de pago?")){ 
				alert("El registro ha sido eliminado.") 
		}
			else { 
			return false
		}
	}
	</script>
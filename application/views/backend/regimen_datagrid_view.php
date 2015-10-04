<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Régimen</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>regimen/index">Nuevo Régimen</a>
	</nav>
	<?php
		if($tabla_regimen != ""){
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			$this->table->set_heading('Nombre','Descripción','Acciones');
			echo $this->table->set_template($plantilla);
			foreach ($tabla_regimen as $row){
				$this->table->add_row(
					$row->regimen_nombre,$row->regimen_descripcion,
					"<a href=".base_url()."regimen/modificar/".$row->regimen_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."regimen/eliminar/".$row->regimen_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
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
	if (confirm("¿Desea eliminar el registro del régimen?")){ 
			alert("El registro ha sido eliminado.") 
	}
		else { 
		return false
	}
}
</script>
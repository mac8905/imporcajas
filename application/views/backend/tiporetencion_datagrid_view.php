<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Tipo de Retención</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>tiporetencion/index">Nuevo Tipo de Retención</a>
	</nav>
	<?php
		if($tabla_tiporetencion <> ""){
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			$this->table->set_heading('Nombre','Descripción','Modificar','Eliminar');
			echo $this->table->set_template($plantilla);
			foreach ($tabla_tiporetencion as $row){
				$this->table->add_row(
					$row->tiporetencion_nombre,$row->tiporetencion_descripcion,
					"<a href=".base_url()."tiporetencion/modificar/".$row->tiporetencion_id."><span class='glyphicon glyphicon-pencil'></span></a>",
					"<a href=".base_url()."tiporetencion/eliminar/".$row->tiporetencion_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
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
	if (confirm("¿Desea eliminar el registro de tipo de retención?")){ 
			alert("El registro ha sido eliminado.") 
	}
		else { 
		return false
	}
}
</script>
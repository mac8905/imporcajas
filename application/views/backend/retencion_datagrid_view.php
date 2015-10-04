<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Retención</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>retencion/index">Nueva Retención</a>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>tiporetencion/datagrid">Nuevo Tipo de Retención</a>
	</nav>
	<?php
		if($tabla_retencion <> ""){
			$plantilla = array('table_open' => '<table class="table table-hover table-bordered">');
			$this->table->set_heading('Nombre','Base UVT','Porcentaje','Base pesos','Tipo','Descripción','Acciones');
			echo $this->table->set_template($plantilla);
			foreach ($tabla_retencion as $row){
				$this->table->add_row(
					$row->retencion_nombre,
					$row->retencion_base_uvt,
					$row->retencion_porcentaje,
					$row->retencion_base_pesos,
					$row->tiporetencion_nombre,
					$row->retencion_descripcion,
					"<a href=".base_url()."retencion/modificar/".$row->retencion_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."retencion/eliminar/".$row->retencion_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
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
	if (confirm("¿Desea eliminar el registro de retención?")){ 
			alert("El registro ha sido eliminado.") 
	}
		else { 
		return false
	}
}
</script>
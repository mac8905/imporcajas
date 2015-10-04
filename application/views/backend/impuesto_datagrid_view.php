<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Impuesto</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>impuesto/index">Nuevo Impuesto</a>
	</nav>
	<?php
		if($tabla_impuesto <> ""){
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			$this->table->set_heading('Nombre','Porcentaje','Tipo','Descripción','Acciones');
			echo $this->table->set_template($plantilla);
			foreach ($tabla_impuesto as $row){
				$this->table->add_row(
					$row->impuesto_nombre,$row->impuesto_porcentaje,
					$row->impuesto_tipo,$row->impuesto_descripcion,
					"<a href=".base_url()."impuesto/modificar/".$row->impuesto_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."impuesto/eliminar/".$row->impuesto_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
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
	if (confirm("¿Desea eliminar el registro de impuesto?")){ 
			alert("El registro ha sido eliminado.") 
	}
	else { 
		return false
	}
}
</script>
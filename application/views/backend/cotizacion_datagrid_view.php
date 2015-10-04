<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Cotizaciones</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>cotizacion">Crear Cotización</a>
	</nav>

	<?php
		if($consulta_cotizacion_datagrid != "")
		{
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Creación','Vencimiento','Observación','Descripción','Acciones');
			foreach ($consulta_cotizacion_datagrid as $cotizacion) 
			{
					$this->table->add_row(
						$cotizacion->cotizacion_fecha,$cotizacion->cotizacion_fechavencimiento,
						$cotizacion->cotizacion_observacion,$cotizacion->cotizacion_descripcion,
						"<a href=".base_url()."cotizacion/consultar/".$cotizacion->cotizacion_id."><span class='glyphicon glyphicon-search'></span></a>
						<a href=".base_url()."cotizacion/modificar/".$cotizacion->cotizacion_id."><span class='glyphicon glyphicon-pencil'></span></a>
						<a href=".base_url()."cotizacion/eliminar/".$cotizacion->cotizacion_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"
					);							
			}	
			echo $this->table->generate();
			echo $this->pagination->create_links();
		}else{
			return FALSE;
		}
							
	?>
</div>
	<script type="text/javascript">
	function confirma(){
		if (confirm("¿Desea eliminar el registro de la cotización?")){ 
				alert("El registro ha sido eliminado.") 
		}
		else { 
			return false
		}
	}
	</script>
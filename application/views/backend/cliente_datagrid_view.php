<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Clientes</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>cliente/index">Crear Cliente</a>
	</nav>
	<!-- Función que muestra en un datagrid los registros de los clientes de la tabla relación -->
	<?php
		if($consulta_cliente_datagrid != "")
		{
			$plantilla = array('table_open' => '<table id="table" class="table table-hover table-bordered">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Nombre','Nit','Ciudad','Observación','Consultar','Modificar','Eliminar');
			foreach ($consulta_cliente_datagrid as $key => $relacion) 
			{
					$this->table->add_row(
					$relacion->relacion_nombre,
					$relacion->relacion_nit,
					$relacion->relacion_ciudad,
					$relacion->relacion_observacion,
					"<a href=".base_url()."cliente/consultar/".$relacion->relacion_id."><span class='glyphicon glyphicon-search'></span></a>",
					"<a href=".base_url()."cliente/modificar/".$relacion->relacion_id."><span class='glyphicon glyphicon-pencil'></span></a>",
					"<a href=".base_url()."cliente/eliminar/".$relacion->relacion_id." onclick='if(confirma() == false) return false' id='eliminar".$key."'><span class='glyphicon glyphicon-remove'></span></a>"
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
	if (confirm("¿Desea eliminar el registro del cliente?")){ 
			alert("El registro ha sido eliminado.") 
	}
		else { 
		return false
	}
}

if (<?php echo json_encode($this->session->userdata('perfil')) ?> == 2) {
	$.each($("#table tbody").find("tr"), function(i) {
		$('#eliminar'+i).hide();
	});
}
</script>
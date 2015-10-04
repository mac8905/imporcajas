<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Pedidos</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>pedido">Crear Pedido</a>
	</nav>

	<?php
		if($consulta_pedido_datagrid != "")
		{
			$plantilla = array('table_open' => '<table id="table" class="table table-hover table-bordered">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Creación','Vencimiento','Observación','Descripción','Acciones');
			foreach ($consulta_pedido_datagrid as $key => $pedido) 
			{
					$this->table->add_row(
						$pedido->pedido_fecha,$pedido->pedido_fechavencimiento,
						$pedido->pedido_observacion,$pedido->pedido_descripcion,
						"<a href=".base_url()."pedido/consultar/".$pedido->pedido_id."><span class='glyphicon glyphicon-search'></span></a>
						<a href=".base_url()."pedido/modificar/".$pedido->pedido_id."><span class='glyphicon glyphicon-pencil'></span></a>
						<a href=".base_url()."pedido/eliminar/".$pedido->pedido_id." onclick='if(confirma() == false) return false' id='eliminar".$key."'><span class='glyphicon glyphicon-remove'></span></a>"
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
		if (confirm("¿Desea eliminar el registro del pedido?")){ 
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

<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Recibo de Caja</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>recibocaja">Crear Recibo de Caja</a>
	</nav>

	<?php
		if($consulta_recibocaja_datagrid != FALSE)
		{
			$plantilla = array('table_open' => '<table id="table" class="table table-hover table-bordered">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Número','Nombre','Fecha','Método de pago','Descripción','Acciones');
			foreach ($consulta_recibocaja_datagrid as $key => $row) 
			{
				$this->table->add_row(
					$row->recibocaja_id,$row->relacion_nombre,
					$row->recibocaja_fecha,$row->metodopago_nombre,
					$row->recibocaja_observacion,
					"<a href=".base_url()."recibocaja/consultar/".$row->recibocaja_id."><span class='glyphicon glyphicon-search'></span></a>
					<a href=".base_url()."recibocaja/modificar/".$row->recibocaja_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."recibocaja/eliminar/".$row->recibocaja_id." onclick='if(confirma() == false) return false' id='eliminar".$key."'><span class='glyphicon glyphicon-remove'></span></a>"
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
		if (confirm("¿Desea eliminar el registro del recibo de caja?")){ 
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
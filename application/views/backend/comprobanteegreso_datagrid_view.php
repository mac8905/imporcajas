
<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Comprobante de Egreso</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>comprobanteegreso">Crear Comprobante de Egreso</a>
	</nav>

	<?php
		if($consulta_comprobanteegreso_datagrid != "")
		{
			$plantilla = array('table_open' => '<table class="table table-hover table-bordered">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Factura','Nombre','Creación','Descripción','Acciones');
			foreach ($consulta_comprobanteegreso_datagrid as $key => $row) 
			{
				$this->table->add_row(
					$row->ce_id,
					$row->ce_beneficiario,
					$row->ce_fecha,
					$row->ce_observacion,
					"<a href=".base_url()."comprobanteegreso/consultar/".$row->ce_id."><span class='glyphicon glyphicon-search'></span></a>&nbsp;
					<a href=".base_url()."comprobanteegreso/modificar/".$row->ce_id."><span class='glyphicon glyphicon-pencil'></span></a>&nbsp;
					<a href=".base_url()."comprobanteegreso/eliminar/".$row->ce_id." onclick='if(confirma() == false) return false' id='eliminar".$key."'><span class='glyphicon glyphicon-remove'></span></a>"
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
		if (confirm("¿Desea eliminar el registro de la factura de venta?")){ 
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
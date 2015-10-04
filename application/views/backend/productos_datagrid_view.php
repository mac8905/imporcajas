<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Productos de Venta</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>productos/index">Nuevo Producto de Venta</a>
	</nav>
	<?php
		if($tabla_productos != null){
			$plantilla = array('table_open' => '<table id="table" class="table table-hover table-bordered">');
			$this->table->set_heading('Nombre','Alto','Ancho','Largo','Precio de Venta','Descripción','Acciones');
			echo $this->table->set_template($plantilla);
			foreach ($tabla_productos as $key => $row){
				$this->table->add_row(
					$row->producto_nombre,$row->dimension_alto,$row->dimension_ancho,$row->dimension_largo,
					$row->producto_precioventa,$row->producto_descripcion,
					"<a href=".base_url()."productos/consultar/".$row->producto_id."><span class='glyphicon glyphicon-search'></span></a>
					<a href=".base_url()."productos/modificar/".$row->producto_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."productos/eliminar/".$row->producto_id." onclick='if(confirma() == false) return false' id='eliminar".$key."'><span class='glyphicon glyphicon-remove'></span></a>"	
				);
			}
			echo $this->table->generate();
			echo $this->pagination->create_links();
		}else{
			return FALSE;
		}
	?>
	<script type="text/javascript">
		function confirma(){
			if (confirm("¿Desea eliminar el registro del plan único de cuentas?")){ 
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
</div>
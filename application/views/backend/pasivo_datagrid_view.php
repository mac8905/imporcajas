<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Pasivos</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>grupos/index">Nuevo Grupo</a>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>cuenta/index">Nueva Cuenta</a>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>subcuenta/index">Nueva Subcuenta</a>
	</nav>
	<?php
		if($datagrid_pasivos != null){
		
			$plantilla = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1" class="table table-hover">');
			$this->table->set_heading("<h4 align='center'>".'Grupo'."</h4>");
			echo $this->table->set_template($plantilla);
			echo $this->table->generate();
			
			$this->table->clear();
			
			$plantilla = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1" class="table table-hover">');		
			$this->table->set_heading('Número','Nombre','Consultar','Modificar','Eliminar');
			echo $this->table->set_template($plantilla);
		
			foreach ($datagrid_pasivos as $row){
				$this->table->add_row(
					$row->puc_id,$row->puc_nombre,
					"<a href=".base_url()."grupos/consultar/".$row->puc_id."><span class='glyphicon glyphicon-search'></span></a>",
					"<a href=".base_url()."grupos/modificar/".$row->puc_id."><span class='glyphicon glyphicon-pencil'></span></a>",
					"<a href=".base_url()."grupos/eliminar/".$row->puc_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
				);
			}
			echo $this->table->generate();
			
			$this->table->clear();
			
			$plantilla = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1" class="table table-hover">');
			$this->table->set_heading("<h4 align='center'>".'Cuenta'."</h4>");
			echo $this->table->set_template($plantilla);
			echo $this->table->generate();
			
			$this->table->clear();
			
			if($datagrid_cuenta != null){
				$plantilla = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1" class="table table-hover">');		
				$this->table->set_heading('Número','Nombre','Consultar','Modificar','Eliminar');
				echo $this->table->set_template($plantilla);
			
				foreach ($datagrid_cuenta as $row1){
					$this->table->add_row(
						$row1->puc_id,$row1->puc_nombre,
						"<a href=".base_url()."cuenta/consultar/".$row1->puc_id."><span class='glyphicon glyphicon-search'></span></a>",
						"<a href=".base_url()."cuenta/modificar/".$row1->puc_id."><span class='glyphicon glyphicon-pencil'></span></a>",
						"<a href=".base_url()."cuenta/eliminar/".$row1->puc_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
					);
					
				}
				echo $this->table->generate();
			}else{
				return FALSE;
			}
			$this->table->clear();
			
			$plantilla = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1" class="table table-hover">');
			$this->table->set_heading("<h4 align='center'>".'Subcuenta'."</h4>");
			echo $this->table->set_template($plantilla);
			echo $this->table->generate();
			
			$this->table->clear();
			
			if($datagrid_subcuenta != null){
				$plantilla = array('table_open' => '<table border="1" cellpadding="1" cellspacing="1" class="table table-hover">');		
				$this->table->set_heading('Número','Nombre','Consultar','Modificar','Eliminar');
				echo $this->table->set_template($plantilla);
			
				foreach ($datagrid_subcuenta as $row2){
					$this->table->add_row(
						$row2->puc_id,$row2->puc_nombre,
						"<a href=".base_url()."subcuenta/consultar/".$row2->puc_id."><span class='glyphicon glyphicon-search'></span></a>",
						"<a href=".base_url()."subcuenta/modificar/".$row2->puc_id."><span class='glyphicon glyphicon-pencil'></span></a>",
						"<a href=".base_url()."subcuenta/eliminar/".$row2->puc_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"	
					);
					
				}
				echo $this->table->generate();
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	?>
</div>
<script type="text/javascript">
function confirma(){
	if (confirm("¿Desea eliminar el registro del plan único de cuentas?")){ 
			alert("El registro ha sido eliminado.") 
	}
		else { 
		return false
	}
}
</script>
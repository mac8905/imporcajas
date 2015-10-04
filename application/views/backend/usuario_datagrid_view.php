<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Usuarios</p>
		<a class="btn btn-default navbar-btn" href="<?=base_url()?>usuario/index">Crear Usuario</a>
	</nav>

	<?php
		if($consulta_usuario_datagrid != "")
		{
			$plantilla = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="table table-hover">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Nombre','Correo','Perfil','Estado','Acciones');
			foreach ($consulta_usuario_datagrid as $usuario) 
			{
					$this->table->add_row($usuario->usuario_nombre,$usuario->usuario_correo,
					$usuario->perfil_nombre,$usuario->usuario_estado,
					"<a href=".base_url()."usuario/consultar/".$usuario->usuario_id."><span class='glyphicon glyphicon-search'></span></a>
					<a href=".base_url()."usuario/modificar/".$usuario->usuario_id."><span class='glyphicon glyphicon-pencil'></span></a>
					<a href=".base_url()."usuario/eliminar/".$usuario->usuario_id." onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>");							
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
	if (confirm("¿Desea eliminar el registro del usuario?")){ 
			alert("El registro ha sido eliminado.") 
	}
		else { 
		return false
	}
}
</script>
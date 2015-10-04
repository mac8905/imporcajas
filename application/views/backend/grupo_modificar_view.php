<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Modificar Grupo</p>
	</nav>
	<form class="form" role="form" id="form" name="form" action="<?=base_url()?>grupos/modificarDatos/<?= $puc_id?>" method="POST">
		
		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<?php echo form_error('grupo_numero'); ?>
					<label for="numerogrupo">Número del grupo</label>	
					<input type="text" class="form-control input-sm" name="grupo_numero" id="grupo_numero" value="<?= $puc_id?>">	
				</div>
				
				<div class="form-group">
					<?php echo form_error('grupo_nombre'); ?>
					<label for="nombregrupo">Nombre del grupo</label>
					<input type="text" class="form-control input-sm" name="grupo_nombre" id="grupo_nombre" value="<?= $puc_nombre?>">
				</div>
				
				<div class="form-group">
					<label for="Descripciongrupo">Descripción</label>
					<textarea class="form-control input-sm" name="grupo_descripcion" id="grupo_descripcion" rows="4" cols="2" style="resize: none"></textarea>
				</div>
				
				<div class="form-group">
					<a class="btn btn-default" href="<?=base_url()?>puc/datagridActivos">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Grupo">
				</div>
			</div>
		</div>
		
	</form>
</div>

	<script  type="text/javascript">
		$(document).on("ready",function() {
			$('#grupo_descripcion').val("<?= $puc_descripcion?>");
		});
	</script>
	
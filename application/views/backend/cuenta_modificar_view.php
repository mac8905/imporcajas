
<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Modificar Cuenta</p>
	</nav>
	<form class="form" role="form" id="form" name="form" action="<?=base_url()?>cuenta/modificarDatos/<?= $cuenta_id?>" method="POST">
		
		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<?php echo form_error('cuenta_numero'); ?>
					<label for="numerocuenta">Número de la cuenta</label>	
					<input type="text" class="form-control input-sm" name="cuenta_numero" id="cuenta_numero" value="<?= $cuenta_id?>">	
				</div>
				
				<div class="form-group">
					<?php echo form_error('cuenta_nombre'); ?>
					<label for="nombrecuenta">Nombre de la cuenta</label>
					<input type="text" class="form-control input-sm" name="cuenta_nombre" id="cuenta_nombre" value="<?= $cuenta_nombre?>">
				</div>
				
				<div class="form-group">
					<label for="Descripcioncuenta">Descripción</label>
					<textarea class="form-control input-sm" name="cuenta_descripcion" id="cuenta_descripcion" rows="4" cols="2" style="resize: none"></textarea>
				</div>
				
				<div class="form-group">
					<a class="btn btn-default" href="<?=base_url()?>puc/datagridActivos">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Cuenta">
				</div>
			</div>
		</div>
		
	</form>
</div>

	<script  type="text/javascript">
		$(document).on("ready",function() {
			$('#cuenta_descripcion').val("<?= $cuenta_descripcion?>");
		});
	</script>
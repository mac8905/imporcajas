<br/>
<br/>
<br/>
<div class="container">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Nueva Subcuenta</p>
	</nav>
	<form class="form" role="form" id="form" name="form" action="<?=base_url()?>subcuenta/guardar" method="POST">
		
		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<?php echo form_error('subcuenta_numero'); ?>
					<label for="numerogrupo">Número de la subcuenta</label>	
					<input type="text" class="form-control input-sm" name="subcuenta_numero" id="subcuenta_numero" value="<?php echo set_value('subcuenta_numero'); ?>">	
				</div>
				
				<div class="form-group">
					<?php echo form_error('subcuenta_nombre'); ?>
					<label for="nombregrupo">Nombre de la subcuenta</label>
					<input type="text" class="form-control input-sm" name="subcuenta_nombre" id="subcuenta_nombre" value="<?php echo set_value('subcuenta_nombre'); ?>">
				</div>
				
				<div class="form-group">
					<label for="Descripciongrupo">Descripción</label>
					<textarea class="form-control input-sm" name="subcuenta_descripcion" id="subcuenta_descripcion" rows="4" cols="2" style="resize: none"></textarea>
				</div>
				
				<div class="form-group">
					<a class="btn btn-default" href="<?=base_url()?>puc/datagridActivos">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Subcuenta">
				</div>
			</div>
		</div>
		
	</form>
</div>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url()?>css1/bootstrap.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
		<br>
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Nuevo Tipo de Retención</p>
		</nav>		
		<div class="row">
			<div class="col-md-5 col-lg-5">
		<form role="form" id="form" name="form" action="<?=base_url()?>tiporetencion/guardar" method="POST">
		
			<div class="form-group">
			<?php echo form_error('tiporetencion_nombre'); ?>
				<label for="tiporetencionnombre">Nombre tipo de retención :</label>
					
					<input type="text" class="form-control" name="tiporetencion_nombre" id="tiporetencion_nombre" value="<?php echo set_value('tiporetencion_nombre');?>">
					
			</div>
			
			<div class="form-group">
				<label for="tiporetenciondescripcion">Descripción :</label>
				
				<textarea class="form-control" name="tiporetencion_descripcion" id="tiporetencion_descripcion" rows="4" cols="2" style="resize: none"></textarea>
				
			</div>
			
			<div class="form_group">
			
				<a class="btn btn-default" href="<?=base_url()?>tiporetencion/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Tipo de Retención">
				
			</div>
			
		</form>
				</div>
			</div>
		</div><!-- Fin de container -->
	</body>
</html>
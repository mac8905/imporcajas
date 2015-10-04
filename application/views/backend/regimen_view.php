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
			<p class="navbar-text">Nuevo Usuario</p>
		</nav>		
			<div class="row">
				<div class="col-md-5 col-lg-5">	

		<form role="form" id="form" name="form" action="<?=base_url()?>regimen/guardarRegimen" method="POST">
					
			<div class="form-group">
			<?php echo form_error('regimen_nombre'); ?>
				<label for="nombreregimen">Nombre régimen :</label>
						
					<input type="text" class="form-control" name="regimen_nombre" id="nombre_regimen" value="<?php echo set_value('regimen_nombre'); ?>">
					
			</div>

			<div class="form-group">
			<?php echo form_error('regimen_descripcion'); ?>
				<label for="descripcionregimen">Descripción :</label>
					
					<textarea class="form-control" name="regimen_descripcion" id="nombre_descripcion" rows="4" cols="2" style="resize: none"></textarea>
					
			</div>
			
			<div class="form_group">
				
				<a class="btn btn-default" href="<?=base_url()?>regimen/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Régimen">
				
			</div>
		
		</form>
		
				</div>
			</div>
		</div>
	</body>
</html>
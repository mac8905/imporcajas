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
			<p class="navbar-text">Modificar Método de Pago</p>
		</nav>	
			<div class="col-md-5 col-lg-5">
				<div class="form-group">
		<form role="form" id="form" name="form" action="<?=base_url()?>metodopago/modificarDatos/<?= $metodopago_id?>" method="POST">
			
			<div class="form-group">
			<?php echo form_error('metodopago_nombre'); ?>
				<label for="nombremetodopago">Nombre :</label>
					
					<input type="text" class="form-control" name="metodopago_nombre" id="metodopago_nombre" value="<?= $metodopago_nombre?>">
					
			</div>
			
			<div class="form-group">
				<label for="descripcionmetodopago">Descripción :</label>
					
					<textarea class="form-control" name="metodopago_descripcion" id="metodopago_descripcion" rows="4" cols="2" style="resize: none"></textarea>
					
			</div>
			
			<div class="form_group">
				
				<a class="btn btn-default" href="<?=base_url()?>metodopago/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Método de Pago">
				
			</div>

		</form>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).on("ready",function() {
				$('#metodopago_descripcion').val("<?= $metodopago_descripcion?>");
			});
		</script>

	</body>
</html>
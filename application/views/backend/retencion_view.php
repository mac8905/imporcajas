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
			<p class="navbar-text">Nuevo Retención</p>
		</nav>
		<div class="row">
			<div class="col-md-5 col-lg-5">		
		<form role="form" id="form" name="form" action="<?=base_url()?>retencion/guardar" method="POST">
			
			<div class="form-group">
				<label for="nombreretencion">Nombre retención :</label>
				<input type="text" class="form-control" name="retencion_nombre" id="retencion_nombre" value="<?php echo set_value('retencion_nombre'); ?>">
			</div>

			<div class="form-group">
				<label for="nombreretencion">Base UVT :</label>
				<input type="text" class="form-control" name="retencion_base_uvt" id="retencion_base_uvt" value="<?php echo set_value('retencion_base_uvt'); ?>">
			</div>
			
			<div class="form-group">
				<label for="regimen">Tipo de Retención :</label>
					<select class="form-control" name="retencion_tipo" id="selected" >
						<?php
							if ($consulta_tiporetencion != FALSE){

								foreach ($consulta_tiporetencion->result() as $row){
										echo "<option value=".$row->tiporetencion_id.">".$row->tiporetencion_nombre."</option>";
								}
							}
							else{
								echo "No hay datos";
							}
						?>
					</select>
			</div>

			<div class="form-group">
				<label for="nombreretencion">Base pesos :</label>
				<input type="text" class="form-control" name="retencion_base_pesos" id="retencion_base_pesos" value="<?php echo set_value('retencion_base_pesos'); ?>" placeholder="(0 para 100%) o (ingrese un valor)">
			</div>
			
			<div class="form-group">
				<?php echo form_error('retencion_porcentaje'); ?>
				<label for="porcentajeretencion">Porcentaje :</label>
					<input type="text" class="form-control" name="retencion_porcentaje" id="retencion_porcentaje" value="<?php echo set_value('retencion_porcentaje'); ?>">
			</div>
			
			<div class="form-group">
				<label for="porcentajeretencion">Descripción :</label>
					
					<textarea class="form-control" name="retencion_descripcion" id="retencion_descripcion" rows="4" cols="2" style="resize: none"></textarea>
					
			</div>
			
			<div class="form_group">
				
				<a class="btn btn-default" href="<?=base_url()?>retencion/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Retención">
				
			</div>
			
			</form>
				</div>
			</div>
		</div>
		
	</body>
</html>
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
			<br/>
			<nav class="navbar navbar-default" role="navigation">
				<p class="navbar-text">Nuevo Producto de Venta</p>
			</nav>
		
			<form role="form" id="form" name="form" action="<?=base_url()?>productos/guardar" method="POST">
			
			<div class="row">
			<div class="col-md-6 col-lg-6"><!--Inicio de la primera columna-->
			
			<div class="form-group">
			<?php echo form_error('producto_nombre'); ?>
				<label for="nombreretencion" >Nombre :</label>	
				<input type="text" class="form-control" name="producto_nombre" id="producto_nombre" value="<?php echo set_value('producto_nombre'); ?>">	
			</div>
			
			<div class="form-group">
				<label for="porcentajeretencion">Descripción :</label>						
				<textarea class="form-control" name="producto_descripcion" id="producto_descripcion" rows="4" cols="2" style="resize: none"></textarea>		
			</div>

			<div class="form-group">
			<?php echo form_error('producto_precioventa'); ?>
				<label for="porcentajeretencion">Precio de venta :</label>		
				<input type="text" class="form-control" name="producto_precioventa" id="producto_precioventa" value="<?php echo set_value('producto_precioventa'); ?>">
			</div>

			

			<div class="form-group">
				<label for="regimen">Impuesto :</label>
					<select class="form-control" name="producto_impuesto" id="selected" >
						
						<?php
							if ($consulta_impuesto != FALSE){

								foreach ($consulta_impuesto->result() as $row){
										echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";
								}
							}
							else{
								echo "No hay datos";
							}
						?>
					</select>	
			</div>
			
			<!-- <div class="form-group">
				<label for="regimen">Categoría :</label>
					<select class="form-control" name="producto_tipo" id="selected" > -->
						
						<?php
							if ($consulta_impuesto != FALSE){

								foreach ($consulta_impuesto->result() as $row){
										echo "<option value=".$row->impuesto_porcentaje.">".$row->impuesto_nombre."</option>";
								}
							}
							else{
								echo "No hay datos";
							}
						?>
					<!-- </select>
			</div>-->		
		
			</div><!--Fin de la primera columna-->
			
			<div class="col-md-6 col-lg-6"><!--Inicio de la segunda columna-->
			

			
			<div class="form-group">
				<label for="productomedidas">Medidas :</label>
			</div>
			
			<div class="form-group">
			<?php echo form_error('producto_alto'); ?>
				<label for="porcentajeretencion">Alto :</label>	
				<input type="text" class="form-control" name="producto_alto" id="producto_alto" value="<?php echo set_value('producto_alto'); ?>">
					
			</div>
			
			<div class="form-group">
			<?php echo form_error('producto_ancho'); ?>
				<label for="porcentajeretencion">Ancho :</label>	
				<input type="text" class="form-control" name="producto_ancho" id="producto_ancho" value="<?php echo set_value('producto_ancho'); ?>">
			</div>

			<div class="form-group">
			<?php echo form_error('producto_largo'); ?>
				<label for="porcentajeretencion">Largo :</label>	
				<input type="text" class="form-control" name="producto_largo" id="producto_largo" value="<?php echo set_value('producto_largo'); ?>">
			</div>
			
			<br/>
			
			<div class="form-group">
			<?php echo form_error('producto_cantidadinicial'); ?>
				<label for="porcentajeretencion">Cantidad Inicial :</label>
					<input type="text" class="form-control" name="producto_cantidadinicial" id="producto_cantidadinicial" value="<?php echo set_value('producto_cantidadinicial'); ?>">
			</div>
			
			<div class="form-group">
			<?php echo form_error('producto_costo'); ?>
				<label for="porcentajeretencion">Costo Unidad :</label>
					<input type="text" class="form-control" name="producto_costo" id="producto_costo" value="<?php echo set_value('producto_costo'); ?>">
			</div>
			
			<div class="form_group">
					<a class="btn btn-default" href="<?=base_url()?>productos/datagrid">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Producto">
			</div>
			
			</div><!--Fin de la segunda columna-->
			</div><!--Fin de la fila-->
			
			</form>
			
		</div>
	</body>
</html>
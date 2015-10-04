<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url()?>css1/bootstrap.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	</head>
	<body>
	
		<div class="container">
			<br/>
			<nav class="navbar navbar-default" role="navigation">
				<p class="navbar-text">Modificar Producto de Venta</p>
			</nav>
		
			<form role="form" id="form" name="form" action="<?=base_url()?>productos/modificarEnlace/<?=$producto_id?>" method="POST">
			
			<div class="row">
			<div class="col-md-6 col-lg-6"><!--Inicio de la primera columna-->
			
			<div class="form-group">
				<label for="nombreretencion">Nombre :</label>
						
					<input type="text" class="form-control" name="producto_nombre" id="producto_nombre" value="<?=$producto_nombre?>">
					
			</div>
			
			<div class="form-group">
				<label for="porcentajeretencion">Descripción :</label>
						
					<textarea class="form-control" name="producto_descripcion" id="producto_descripcion" rows="4" cols="2" style="resize: none"></textarea>
					
			</div>

			<div class="form-group">
				<label for="porcentajeretencion">Precio de venta :</label>
					
					<input type="text" class="form-control" name="producto_precioventa" id="producto_precioventa" value="<?= $producto_precioventa?>">
					
			</div>

			

			<div class="form-group">
					<label for="regimen">Impuesto :</label>
					<select class="form-control" name="producto_impuesto" id="producto_impuesto" >
						
						<?php
							if ($consulta_impuesto != FALSE){

								foreach ($consulta_impuesto as $row){
										echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";
								}
							}
							else{
								echo "No hay datos";
							}
						?>
					</select>
					
			</div>
		
			</div><!--Fin de la primera columna-->
			
			<div class="col-md-6 col-lg-6"><!--Inicio de la segunda columna-->
			
			<div class="form-group">
				<label for="productomedidas">Medidas :</label>
			</div>
			
			<div class="form-group">
				<label for="porcentajeretencion">Alto :</label>	
					<input type="text" class="form-control" name="producto_alto" id="producto_alto" value="<?= $producto_alto?>">
					
			</div>
			
			<div class="form-group">
				<label for="porcentajeretencion">Ancho :</label>
					
					<input type="text" class="form-control" name="producto_ancho" id="producto_ancho" value="<?= $producto_ancho?>">
					
			</div>

			<div class="form-group">
				<label for="porcentajeretencion">Largo :</label>
						
					<input type="text" class="form-control" name="producto_largo" id="producto_largo" value="<?= $producto_largo?>">
					
			</div>
			
			<br/>
			
			<div class="form-group">
				<label for="porcentajeretencion">Cantidad Inicial :</label>
						
					<input type="text" class="form-control" name="producto_cantidadinicial" id="producto_cantidadinicial" value="<?= $producto_cantidadinicial?>">
					
			</div>
			
			<div class="form-group">
				<label for="porcentajeretencion">Costo Unidad :</label>
					
					<input type="text" class="form-control" name="producto_costo" id="producto_costo" value="<?= $producto_costo?>">
					
			</div>
			
			<div class="form_group">
				
					<a class="btn btn-default" href="<?=base_url()?>productos/datagrid">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Producto">
				
			</div>
			
			</div><!--Fin de la segunda columna-->
			</div><!--Fin de la fila-->
			
			</form>
			
		</div>
		<script type="text/javascript">
			$(document).on("ready",function() {
				$('#producto_descripcion').val("<?= $producto_descripcion?>");
				$('#producto_impuesto').val("<?= $impuesto_id?>");
			});
		</script>
	</body>
</html>
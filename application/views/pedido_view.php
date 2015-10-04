<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url()?>css1/bootstrap.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="all" href="css/calendar-system.css">
		<script type="text/javascript" src="js/calendar.js"></script>
		<script type="text/javascript" src="js/calendar-es.js"></script>
		<script type="text/javascript" src="js/calendar-setup.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container-fluid">
			<nav class="navbar navbar-default" role="navigation">
				<p class="navbar-text">Nuevo Pedido</p>
			</nav>
			
			<form class="form-group" role="form" id="form" name="form" action="<?=base_url()?>pedido/guardar" method="POST">
				<div class="row"><!--Inicio de la primera fila-->
					<div class="col-md-6 col-lg-6">
					
					<div class="form-group">
							<label for="pedido" class="col-md-3 col-lg-3 control-label">Cliente :</label>
							<div class="col-md-12 col-lg-12">
								<select class="form-control input-sm" name="pedido_cliente" id="pedido_cliente" >
									
									<?php
										if ($consulta_cliente != FALSE){

											foreach ($consulta_cliente->result() as $row){
													echo "<option value=".$row->relacion_id.">".$row->relacion_nombre."</option>";
											}
										}
										else{
											echo "No hay datos";
										}
									?>
								</select>
							</div>
					</div>	
						
					<div class="form-group">
						<label for="pedidoobservación" class="col-md-12 col-lg-12 control-label">Observación :</label>
							<div class="col-md-12 col-lg-12">	
								<textarea class="form-control input-sm" name="pedido_observacion" id="pedido_observacion" rows="4" cols="2" style="resize: none"></textarea>
							</div>
					</div>	
						
					</div><!--Fin de la primera columna-->
					
					<div class="col-md-6 col-lg-6">
					
						<div class="form-group">
							<label for="pedidocalendario" class="col-md-12 col-lg-12 control-label">Fecha :</label>
								<div class="col-md-12 col-lg-12">
									<div class="row">
										<div class="col-md-11 col-lg-11">
										<input type="text" class="form-control input-sm" name="fecha" id="fecha">
										</div>
										<div class="col-md-0 col-lg-0">
											<!--<img src="Calendar/img.gif" id="selector" width='20' height='15'>-->
											<span class="glyphicon glyphicon-calendar" id="selector"></span>
										</div>
									</div>
								</div>
						</div>
			
						<div class="form-group">
							<label for="pedidocalendario" class="col-md-12 col-lg-12 control-label">Fecha vencimiento :</label>
								<div class="col-md-12 col-lg-12">
									<div class="row">
										<div class="col-md-11 col-lg-11">
										<input type="text" class="form-control input-sm" name="fechavencimiento" id="fechavencimiento">
										</div>
										<div class="col-md-0 col-lg-0">
											<!--<img src="Calendar/img.gif" id="selectorv" width='20' height='15'>-->
											<span class="glyphicon glyphicon-calendar" id="selectorv"></span>
										</div>
									</div>
								</div>
						</div>
						
						<div class="form-group">
							<label for="pedidoobservación" class="col-md-12 col-lg-12 control-label">Descripción :</label>
								<div class="col-md-11 col-lg-11">	
									<textarea class="form-control input-sm" name="pedido_descripcion" id="pedido_descripcion" rows="4" cols="2" style="resize: none"></textarea>
								</div>
						</div>						

			
					</div><!--Fin de la segunda columna-->
				</div> <!-- Fin de la primera fila -->
				<br />
				<br />
				<div class="row"><!--Inicio de la segunda fila-->
					<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label for="pedido" class="col-md-0 col-lg-0 control-label">Producto 1</label>
						<div class="col-md-0 col-lg-0">
							<select class="form-control input-sm" name="pedido_producto[]" id="pedido_producto" onchange="showUser(this.value)">
								
								<?php
									if ($consulta_producto != FALSE){

										foreach ($consulta_producto->result() as $row){
												echo "<option value=".$row->producto_id.">".$row->producto_nombre."</option>";
										}
									}
									else{
										echo "No hay datos";
									}
								?>
							</select>
						</div>
					</div>
					</div>
					
					<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label for="pedidocalendario" class="col-md-0 col-lg-0 control-label">Tamaño 1</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<input type="text" class="form-control input-sm" name="pedido_tamano[]" id="pedido_tamano" placeholder="alto-ancho-largo">
							</div>
						</div>
					</div>
					</div>
					
					<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label for="pedidoprecio" class="col-md-0 col-lg-0 control-label">Precio 1</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div id="pedido_preciov">
									<input type='text' class='form-control input-sm' name='pedido_precio[]' id="pedido_precio">
								</div>
							</div>
						</div>
					</div>
					</div>

					<div class="col-md-1 col-lg-1">
					<div class="form-group">
						<label for="pedidodescuento" class="col-md-0 col-lg-0 control-label">Desc% 1</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<input type="text" class="form-control input-sm" name="pedido_descuento[]" id="pedido_descuento" value="0">
							</div>
						</div>
					</div>
					</div>
					
					<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label for="pedidoimpuesto" class="col-md-0 col-lg-0 control-label">Impuesto 1</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<select class="form-control input-sm" name="pedido_impuesto[]" id="pedido_impuesto">
								<?php
									if($consulta_impuesto != FALSE){
										foreach($consulta_impuesto->result() as $row){
											echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";
										}
									}else{
										echo "No hay datos";
									}
								?>
								</select>
							</div>
						</div>
					</div>
					</div>
			
					<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label for="pedidocantidad" class="col-md-0 col-lg-0 control-label">Cantidad 1</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<input type="number" class="form-control input-sm" name="pedido_cantidad[]" id="pedido_cantidad">
							</div>
						</div>
					</div>
					</div>		

					<div class="col-md-1 col-lg-1">
					<div class="form-group">
						<label for="pedidototal" class="col-md-0 col-lg-0 control-label">Total 1</label>
						<div class="col-md-12 col-lg-12">
							<div class="row" id="">
							</div>
						</div>
					</div>
					</div>							
				</div><!--Fin de la segunda fila-->
					
				<a href="#" id="agregar_campo">+ Agregar producto</a>
					
		</div><!--Fin container-fluid-->
				
				<br/>
				<div class="row"><!--Inicio de la tercer fila-->
					<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
					<table class="table-responsive">
						<tr>
							<td>
								<label  class="col-md-0 col-lg-0 control-label">Subtotal :</label>
							</td>
							<td>
			
							</td>
						</tr>
						<tr>
							<td>
								<label  class="col-md-0 col-lg-0 control-label">Descuento :</label>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								<label  class="col-md-0 col-lg-0 control-label">IVA :</label>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								<label  class="col-md-0 col-lg-0 control-label">Total :</label>
							</td>
							<td>
							</td>
						</tr>
						
					</table>
					</div>
				</div><!--Fin de la tercera fila-->
				
				<br/>
				<div class="row"><!--Inicio de la cuarta fila-->
					<div class="form_group">
						<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
							<a class="btn btn-default" href="<?=base_url()?>pedido/datagrid">Cancelar</a>
							<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Pedido">
						</div>
					</div>
				</div><!--Fin de la cuarta fila-->
				
			</form>
			
		
		<script type="text/javascript">
			window.onload = function() {
			  Calendar.setup({
				inputField: "fecha",
				ifFormat:   "%d / %m / %Y",
				button:     "selector"
			  });
			  
			  Calendar.setup({
				inputField: "fechavencimiento",
				ifFormat:   "%d / %m / %Y",
				button:     "selectorv"
			  });
			  
			} 
			
			jQuery.fn.generaNuevosCampos = function(indice)
			{
			   $(this).each(function(){
				  elem = $(this);
				  elem.data("indice",indice);
				  
				  elem.click(function(e){
					 e.preventDefault();
					 elem = $(this);
					 indice = elem.data("indice");
					 texto_insertar = '<div class="row"><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedido" class="col-md-0 col-lg-0 control-label">Producto '+indice+'</label><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="pedido_producto[]" id="pedido_producto'+indice+'" onchange="showUser(this.value)"><?php if ($consulta_producto != FALSE){foreach ($consulta_producto->result() as $row){echo "<option value=".$row->producto_id.">".$row->producto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidotamano" class="col-md-0 col-lg-0 control-label">Tamaño '+indice+'</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_tamano[]" id="pedido_tamano'+indice+'" placeholder="alto-ancho-largo"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidoprecio" class="col-md-0 col-lg-0 control-label">Precio '+indice+'</label><div class="col-md-12 col-lg-12"><div class="row"><div id="pedido_preciov"><input type="text" class="form-control input-sm" name="pedido_precio[]" id="pedido_precio'+indice+'"></div></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidodescuento" class="col-md-0 col-lg-0 control-label">Desc% '+indice+'</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_descuento[]" id="pedido_descuento'+indice+'" value="0"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidoimpuesto" class="col-md-0 col-lg-0 control-label">Impuesto'+indice+'</label><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="pedido_impuesto[]" id="pedido_impuesto'+indice+'"><?if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidocantidad" class="col-md-0 col-lg-0 control-label">Cantidad '+indice+'</label><div class="col-md-12 col-lg-12"><div class="row"><input type="number" class="form-control input-sm" name="pedido_cantidad[]" id="pedido_cantidad'+indice+'"></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidototal" class="col-md-0 col-lg-0 control-label">Total '+indice+'</label><div class="col-md-12 col-lg-12"><div class="row"><?$pedido = new Pedido();$pedido->totalProducto();?></div></div></div></div></div>';
					 indice ++;
					 elem.data("indice",indice);
					 nuevo_campo = $(texto_insertar);
					 elem.before(nuevo_campo);
				  });
			   });
			   return this;
			}

			$(document).ready(function(){
			   $("#agregar_campo").generaNuevosCampos(2);
			}); 
			
			/* Esta funcion sirve para cargar el precio de un producto		 */
			$(document).ready(function() {
				$("#pedido_producto").change(function() {
					$.ajax ({
						type : "POST",
						url : '<?=base_url()?>pedido/consultarPrecio',
						data : {q : $("#pedido_producto").val()},
						cache : false,
						success : function(data) {
							$('#pedido_precio').attr("value", data);
						}
					});
					return false;
				});
			});
			
		</script>

		
	</body>
</html>
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
<!-- En esta vista realizamos el formulario del cliente y proveedor -->
	<section>
	<br/>
	<div class="container">
		
			<nav class="navbar navbar-default" role="navigation">
				<p class="navbar-text">Nuevo Proveedor</p>
			</nav>

					<!-- Enviamos los datos del formulario al controlador cliente y a la funcion guardar -->
					<form class="form-horizontal" role="form" id="form" name="form" action="<?=base_url()?>proveedor/guardar" method="POST">
						<div class="row">
			<div class="col-md-6">
						<div class="form-group">
						<?php echo form_error('relacion_nombre'); ?>
							<label for="nombre" class="col-lg-3 control-label">Nombre :</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="relacion_nombre" id="nombre" title="Nombre" value="<?php echo set_value('relacion_nombre'); ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label for="nit" class="col-lg-3 control-label">Nit :</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="relacion_nit" id="nit">
							</div>
						</div>
						
						<div class="form-group">
							<label for="regimen" class="col-lg-3 control-label">Régimen :</label>
							<div class="col-lg-6">
								<select class="form-control" name="regimen_id">
									<?php
										if ($regimen_nom != FALSE){
											foreach ($regimen_nom->result() as $row){
													echo "<option value=".$row->regimen_id.">".$row->regimen_nombre."</option>";
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
							<label for="ciudad" class="col-lg-3 control-label">Ciudad :</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="relacion_ciudad" id="ciudad" value="<?php echo set_value('relacion_ciudad'); ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label for="direccion" class="col-lg-3 control-label">Dirección :</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="relacion_direccion" id="direccion" value="<?php echo set_value('relacion_direccion'); ?>">
							</div>
						</div>
						
						<?php echo form_error('relacion_telefono[]'); ?>
						<a href="#" id="agregar_campo">+ Agregar teléfono</a>
						
			</div>
			<div class="col-md-6">
			

						
						<div class="form-group">
							<label for="correo" class="col-lg-3 control-label">Correo :</label>
							<div class="col-lg-6">
								<input type="email" class="form-control" name="relacion_correo" id="correo" value="<?php echo set_value('relacion_correo'); ?>">
							</div>
						</div>
						
						<div class="form-group">
						<?php echo form_error('relacion_movil'); ?>
							<label for="movil" class="col-lg-3 control-label">Móvil :</label>
							<div class="col-lg-6">
								<input type="number" class="form-control" name="relacion_movil" id="movil" value="<?php echo set_value('relacion_movil'); ?>">
							</div>
						</div>	

						<div class="form-group">
						<?php echo form_error('relacion_fax'); ?>
							<label for="fax" class="col-lg-3 control-label">Fax :</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="relacion_fax" id="fax" value="<?php echo set_value('relacion_fax'); ?>">
							</div>
						</div>	
						
						 <div class="form-group">
							<div class="col-lg-offset-3 col-lg-1">
							  <div class="checkbox">
								<label class="checkbox-inline">
								  <input type="checkbox" id="opciones_1" name="relacion_perfil_cliente" value="1"> 
								  Cliente
								</label>
							  </div>
							</div>

							<div class="col-lg-offset-2 col-lg-1">
							  <div class="checkbox">
								<label class="checkbox-inline">
								  <input type="checkbox" id="opciones_2" name="relacion_perfil_proveedor" value="2"> 
								  Proveedor
								</label>
							  </div>
							</div>
						 </div>
						
						<div class="form-group">
								<label for="observacion" class="col-lg-3 control-label">Observación :</label>
							<div class="col-lg-6">
								<textarea class="form-control" name="relacion_observacion" id="observacion" rows="3" cols="2" style="resize: none"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-offset-5 col-lg-1">
								<a class="btn btn-default" href="<?=base_url()?>proveedor/datagrid">Cancelar</a>
								<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Proveedor">
							</div>
						</div>
						
			</div><!-- fin de la segunda columna-->
						</div><!-- fin de la primera fila-->
					</form>


	</div><!-- fin de container-->

	</section>
	

	<!-- 
		Crear nuevo campo para telefono
	-->
	<script type="text/javascript">
		jQuery.fn.generaNuevosCampos = function(etiqueta, nombreCampo, indice){
		   $(this).each(function(){
			  elem = $(this);
			  elem.data("etiqueta",etiqueta);
			  elem.data("nombreCampo",nombreCampo);
			  elem.data("indice",indice);
			  
			  elem.click(function(e){
				 e.preventDefault();
				 elem = $(this);
				 etiqueta = elem.data("etiqueta");
				 nombreCampo = elem.data("nombreCampo");
				 indice = elem.data("indice");
				 texto_insertar = '<div class="form-group" id="fila_telefono'+indice+'"><label for="'+ nombreCampo+ indice +'" class="col-lg-3 control-label">'+ etiqueta + indice +' :</label><div class="col-lg-6"><input type="tel" class="form-control" name="'+ nombreCampo +'[]" id="'+ nombreCampo + indice +'" value="<?php echo set_value('relacion_telefono[]'); ?>"></div><div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
				 indice ++;
				 elem.data("indice",indice);
				 nuevo_campo = $(texto_insertar);
				 elem.before(nuevo_campo);
			  });
		   });
		   return this;
		}

		$(document).ready(function(){
		   $("#agregar_campo").generaNuevosCampos("Teléfono", "relacion_telefono", 1);
		});

		function eliminar(id) {
			$("#fila_telefono"+id).remove();
		}
	</script>
		
</body>
</html>
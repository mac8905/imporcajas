			<nav class="navbar navbar-default">
				<p class="navbar-text">Modificar Proveedor</p>
			</nav>

				<!--Enviamos los datos del formulario al controlador proveedor y a la funcion guardar -->
				<form class="form-horizontal" role="form" id="form" name="form" action="<?=base_url()?>proveedor/modificarEnlace/<?=$relacion_id?>" method="POST">
					<div class="row">
		<div class="col-md-6">
					<div class="form-group">
						<label for="nombre" class="col-lg-3 control-label">Nombre :</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="relacion_nombre" id="nombre" title="Nombre" value="<?=$relacion_nombre?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="nit" class="col-lg-3 control-label">Nit :</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="relacion_nit" id="nit" value="<?=$relacion_nit?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="regimen" class="col-lg-3 control-label">Régimen :</label>
						<div class="col-lg-6">
							<select class="form-control" name="regimen_id" id="selected" >
								<?php
									if ($consulta_regimen != FALSE){

										foreach ($consulta_regimen->result() as $row){
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
							<input type="text" class="form-control" name="relacion_ciudad" id="ciudad" value="<?=$relacion_ciudad?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="direccion" class="col-lg-3 control-label">Dirección :</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="relacion_direccion" id="direccion" value="<?=$relacion_direccion?>">
						</div>
					</div>
					<div id="telefonos"></div>
					<a href="#" id="agregar_campo">+ Agregar teléfono</a>

		</div>
		<div class="col-md-6">
					
					<div class="form-group">
						<label for="correo" class="col-lg-3 control-label">Correo :</label>
						<div class="col-lg-6">
							<input type="email" class="form-control" name="relacion_correo" id="correo" value="<?=$relacion_correo?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="movil" class="col-lg-3 control-label">Móvil :</label>
						<div class="col-lg-6">
							<input type="number" class="form-control" name="relacion_movil" id="movil" value="<?=$relacion_movil?>">
						</div>
					</div>	

					<div class="form-group">
						<label for="fax" class="col-lg-3 control-label">Fax :</label>
						<div class="col-lg-6">
							<input type="text" class="form-control" name="relacion_fax" id="fax" value="<?=$relacion_fax?>">
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

							<textarea class="form-control" name="relacion_observacion" id="observacion" rows="3" cols="2" style="resize: none"><?= $relacion_observacion?></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-6">
							<a class="btn btn-default" href="<?=base_url()?>proveedor/datagrid">Cancelar</a>
							<input class="btn btn-default" type="submit" name="modificar" id="modificar" value="Guardar cambios" title="Guardar Proveedor">
						</div>
					</div>
					
		</div><!-- fin de la segunda columna-->
					</div><!-- fin de la primera fila-->
				</form>

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
				 texto_insertar = '<div class="form-group"><label for="'+ nombreCampo+ indice +'" class="col-lg-3 control-label">'+ etiqueta +' :</label><div class="col-lg-6"><input type="tel" class="form-control" name="'+ nombreCampo +'[]" id="'+ nombreCampo + indice +'"></div></div>';
				 indice ++;
				 elem.data("indice",indice);
				 nuevo_campo = $(texto_insertar);
				 elem.before(nuevo_campo);
			  });
		   });
		   return this;
		}

		$(document).ready(function() {
			$("#agregar_campo").generaNuevosCampos("Teléfono", "relacion_telefono", <?php echo count($telefonor_numero); ?>+1);
		   
			var nombreCampo = "relacion_telefono";
			var etiqueta = "Teléfono";
			var arr = <?php echo json_encode($telefonor_numero); ?>;
			for (var i = 0; i < arr.length; i++) {
						campo = '<div class="form-group"><label for="'+ nombreCampo+ (i+1) +'" class="col-lg-3 control-label">'+ etiqueta +' :</label><div class="col-lg-6"><input type="tel" class="form-control" id="'+ nombreCampo + (i+1) +'" value="'+ arr[i] +'" name="'+ nombreCampo +'[]"></div></div>';
						$("#telefonos").append(campo);
			}
			
			$('#selected').val(<?= $relacion_regimen?>);
			
			var arr_perfil =<?= json_encode($perfil)?>;

			if ($('#opciones_1').val() == arr_perfil[0]) {
				$('#opciones_1').prop("checked", true);
			}
			if ($('#opciones_2').val() == arr_perfil[1]) {
				$('#opciones_2').prop("checked", true);
			}
		}); 
	</script>
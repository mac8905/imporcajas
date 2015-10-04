<div class="container">
	<br>
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Modificar información de la empresa</p>
	</nav>	
	
	<div class="row">
		<div class="col-md-6 col-lg-6">
			<form role="form" id="form" name="form" action="<?=base_url()?>empresa/modificarEnlace" method="POST">
				<div class="form-group">
				<?php echo form_error('empresa_nombre'); ?>
					<label for="empresanombre">Nombre :</label>
					<input type="text" class="form-control" name="empresa_nombre" id="empresa_nombre" value="<?=$empresa_nombre?>">
				</div>
				
				<div class="form-group">
					<label for="empresanit">Nit :</label>
					<input type="text" class="form-control" name="empresa_nit" id="empresa_nit" value="<?=$empresa_nit?>">
				</div>
				
				<div class="form-group">
					<label for="empresadireccion">Dirección :</label>
					<input type="text" class="form-control" name="empresa_direccion" id="empresa_direccion" value="<?=$empresa_direccion?>">
				</div>
				
				<div class="form-group">
					<label for="empresaciudad">Ciudad :</label>
					<input type="text" class="form-control" name="empresa_ciudad" id="empresa_ciudad" value="<?=$empresa_ciudad?>">
				</div>

				<div class="form-group">
					<label for="empresamovil">Móvil :</label>
					<input type="text" class="form-control" name="empresa_movil" id="empresa_movil" value="<?=$empresa_movil?>">
				</div>
					
				<div class="form-group">
					<label for="resolucion">Resolución Dian :</label>
					<input type="text" class="form-control" name="empresa_resolucion" id="empresa_resolucion" value="<?=$empresa_resolucion?>">
				</div>
				
				<div class="form-group">
					<label for="autorizacionfinal">Número final de autorización :</label>
					<input type="text" class="form-control" name="empresa_final" id="empresa_final" value="<?=$empresa_final?>">
				</div>
				
		</div>

		<div class="col-md-6 col-lg-6">
		
				<div class="form-group">
					<?php echo form_error('empresa_telefono'); ?>
					<label for="empresatelefono">Teléfono :</label>
					<input type="text" class="form-control" name="empresa_telefono" id="empresa_telefono" value="<?=$empresa_telefono?>">
				</div>

				<div class="form-group">
					<label for="empresacorreo">Correo Electrónico :</label>
					<input type="email" class="form-control" name="empresa_correo" id="empresa_correo" value="<?=$empresa_correo?>">
				</div>		

				<div class="form-group">
					<label for="empresapagina">Sitio web :</label>
					<input type="text" class="form-control" name="empresa_pagina" id="empresa_pagina" value="<?=$empresa_pagina?>">
				</div>		

				<div class="form-group">
					<label for="regimen">Régimen :</label>
						<select class="form-control" name="empresa_regimen" id="selected" >
							
							<?php
								if ($consulta_regimen != FALSE){

									foreach ($consulta_regimen as $row){
											echo "<option value=".$row->regimen_id.">".$row->regimen_nombre."</option>";
									}
								}
								else{
									echo "No hay datos";
								}
							?>
						</select>
						
				</div>

				<div class="form-group">
					<label for="actividadeconomica">Actividad Económica :</label>
					<input type="text" class="form-control" name="empresa_actividad" id="empresa_actividad" value="<?=$empresa_actividad?>">
				</div>
				
				<div class="form-group">
					<label for="autorizacion">Número inicio de autorización :</label>
					<input type="text" class="form-control" name="empresa_inicio" id="empresa_inicio" value="<?=$empresa_inicio?>">
				</div>

				<div class="form_group">
					<a class="btn btn-default" href="<?=base_url()?>principal/bandeja_entrada">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Empresa">
				</div>				
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("ready",function() {
		$('#selected').val(<?= $regimen_nombre?>);
	});
</script>
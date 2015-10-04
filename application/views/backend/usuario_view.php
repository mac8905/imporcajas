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
					<form class="form" role="form" id="form" name="form" action="<?=base_url()?>usuario/guardar" method="POST">
						
						<div class="form-group">
						<?php echo form_error('usuario_nombre'); ?>
							<label for="nombre">Nombre :</label>
							
							<input type="text" class="form-control input-sm" name="usuario_nombre" id="usuario_nombre" title="Nombre" value="<?php echo set_value('usuario_nombre');?>">
							
						</div>
				
						<div class="form-group">
						<?php echo form_error('usuario_password'); ?>
							<label for="password">Contraseña :</label>
							
							<input type="password" class="form-control input-sm" name="usuario_password" id="usuario_password" title="Contraseña">
							
						</div>
						
						<div class="form-group">
							<label for="regimen">Perfil :</label>
							
							<select class="form-control input-sm" name="perfil_id">
								<?php
									if ($consulta_perfil != FALSE){
										foreach ($consulta_perfil->result() as $row){
												echo "<option value=".$row->perfil_id.">".$row->perfil_nombre."</option>";
										}
									}
									else{
										echo "No hay datos";
									}
								?>
							</select>
							
						</div>	

						<div class="form-group">
							<label for="direccion">Ciudad :</label>
							
							<input type="text" class="form-control input-sm" name="usuario_ciudad" id="usuario_ciudad" title="Ciudad" value="<?php echo set_value('usuario_ciudad');?>">
							
						</div>

						<div class="form-group">
							<label for="direccion">Dirección :</label>
							
							<input type="text" class="form-control input-sm" name="usuario_direccion" id="usuario_direccion" title="Dirección" value="<?php echo set_value('usuario_direccion');?>">
							
						</div>

						<div class="form-group">
							<label for="correo">Correo Electrónico :</label>
							
							<input type="email" class="form-control input-sm" name="usuario_correo" id="usuario_correo" title="Correo" value="<?php echo set_value('usuario_correo');?>">
							
						</div>

						<div class="form-group">
						<?php echo form_error('usuario_movil'); ?>
							<label for="movil">Móvil :</label>
							
							<input type="text" class="form-control input-sm" name="usuario_movil" id="usuario_movil" title="Móvil" value="<?php echo set_value('usuario_movil');?>">
							
						</div>						
				
						<div class="form-group">
						<?php echo form_error('usuario_telefono'); ?>
							<label for="telefono">Teléfono :</label>
							
							<input type="text" class="form-control input-sm" name="usuario_telefono" id="usuario_telefono" title="Teléfono" value="<?php echo set_value('usuario_telefono');?>">
							
						</div>	
						
						<div class="form-group">
							<!--<label for="estado" class="col-lg-3 control-label">Estado:</label>-->
							
							<input type="hidden" class="form-control input-sm" name="usuario_estado" id="usuario_estado" title="Estado" value="Activado" value="<?php echo set_value('usuario_estado');?>">
							
						</div>	

						<div class="form-group">
								<a class="btn btn-default" href="<?=base_url()?>usuario/datagrid">Cancelar</a>
								<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Usuario">
						</div>							
				
					</form>
				</div><!-- Fin de la fila -->
			</div>
		</div>
	</body>
	
</html>
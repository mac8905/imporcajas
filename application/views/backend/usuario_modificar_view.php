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
			<br>
			<nav class="navbar navbar-default" role="navigation">
				<p class="navbar-text">Modificar Usuario</p>
			</nav>
			
			<div class="row">
				<div class="col-md-5 col-lg-5">
					<form class="form" role="form" id="form" name="form" action="<?=base_url()?>usuario/modificarDatos/<?= $usuario_id?>" method="POST">
						
						<div class="form-group">
						<?php echo form_error('usuario_nombre'); ?>
							<label for="nombre">Nombre :</label>
							
							<input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" title="Nombre" value="<?= $usuario_nombre?>">
							
						</div>
				
						<!--<div class="form-group">
							<label for="password" class="col-lg-3 control-label">Cambiar contraseña :</label>
							<div class="col-lg-6">
								<input type="password" class="form-control" name="usuario_password" id="usuario_password" title="Contraseña">
							</div>
						</div>-->
						
						<div class="form-group">
							<label for="regimen">Perfil :</label>
							
							<select class="form-control" name="perfil_id" id="selected">
							<script type="text/javascript">
								$(document).on("ready",function() {
									$('#selected').val(<?= $perfil_nombre?>);
								});
							</script>				
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
							
							<input type="text" class="form-control input-sm" name="usuario_ciudad" id="usuario_ciudad" title="Ciudad" value="<?= $usuario_ciudad?>">
							
						</div>						
						
						<div class="form-group">
							<label for="direccion">Dirección :</label>
						
							<input type="text" class="form-control" name="usuario_direccion" id="usuario_direccion" title="Dirección" value="<?= $usuario_direccion?>">
							
						</div>

						<div class="form-group">
							<label for="correo">Correo Electrónico :</label>
							
							<input type="email" class="form-control" name="usuario_correo" id="usuario_correo" title="Correo" value="<?= $usuario_correo?>">
							
						</div>

						<div class="form-group">
							<label for="movil">Móvil :</label>
							
							<input type="text" class="form-control" name="usuario_movil" id="usuario_movil" title="Móvil" value="<?= $usuario_movil?>">
							
						</div>						
				
						<div class="form-group">
						<?php echo form_error('usuario_telefono'); ?>
							<label for="telefono">Teléfono :</label>
							
							<input type="text" class="form-control" name="usuario_telefono" id="usuario_telefono" title="Teléfono" value="<?= $usuario_telefono?>">
							
						</div>

						<div class="form-group">
							
							<a href="<?=base_url()?>usuario/modificarContrasena/<?= $usuario_id?>">Modificar Contraseña</a>
							
						</div>							

						<div class="form-group">
							
							<a class="btn btn-default" href="<?=base_url()?>usuario/datagrid">Cancelar</a>
							<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar Cambios" title="Guardar Usuario">
							
						</div>							
				
					</form>
				</div><!-- Fin de la fila -->
			</div>
		</div>

	</body>
	
</html>
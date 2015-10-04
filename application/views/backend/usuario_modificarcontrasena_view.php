<br/>
	<div class="container">
		<br>
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Modificar Contraseña</p>
		</nav>

			<form class="form" role="form" id="form" name="form" action="<?=base_url()?>usuario/modificarDatosContrasena/<?= $usuario_id?>" method="POST">
				<div class="row">
					<div class="col-md-5 col-lg-5">
						<div class="form-group">
							<?php echo form_error('usuario_password'); ?>
							<label for="password">Cambiar contraseña :</label>
							<input type="password" class="form-control" name="usuario_password" id="usuario_password" title="Contraseña">
							
						</div>
						
						<div class="form-group">
							
							<a class="btn btn-default" href="<?=base_url()?>usuario/datagrid">Cancelar</a>
							<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar Cambios" title="Guardar Contraseña">
							
						</div>
					</div>
				</div>
			</form>

	</div>
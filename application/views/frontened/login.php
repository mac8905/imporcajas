<div class="login">
	<div class="row">
		<div class="col-md-4 col-lg-4">
			<!-- base_url representa http//: www.imporcajas.com.co/ -->
			<form role="form" id="form" name="form" action="<?=base_url()?>login/validar" method="POST"> <!-- se llama al método validar de la clase login al cual se le van a enviar los datos por el método post -->

				<div class="form-group">
					<h3 class="form-signin-heading">Sistema Imporcajas</h3>
				</div>
				<!-- se muestra un input para el ingreso del correo -->
				<div class="form-group">
					<label for="email"> Correo Electrónico :</label>
					<input type="email" class="form-control" name="usuario_correo" value="<?php echo set_value('usuario_correo'); ?>" id="correo"> <!-- name es el atributo de la etiqueta que va a contener el valor del input -->
				</div>
				
				<div class="form-group">
					<label for="contraseña">Contraseña :</label>
					<input type="password" class="form-control" name="usuario_password" value="<?php echo set_value('usuario_password'); ?>" id="password">
				</div>
				<!-- se muestra un botón el cual activará la acción de enviar el formulario -->
				<div class="form-group">
					<input class="btn btn-default" type="submit" name="ingresar" id="ingresar" value="Ingresar" title="Ingresar Usuario">
				</div>
				
				<!-- visualización de los errores -->
				<div class="form-group">		
					<div class="LoginUsuariosError">
					  <?php
						  if(isset($error))
							 	echo '<p id="alert1">'.$error.'</p>';
					  	echo form_error('maillogin');
					  ?>
					</div>
				</div>
				<div class="" id="alert2"></div>
			</form>
			
		</div>
	</div>
</div>
<!-- código JavaScript y jQuery -->
<script type="text/javascript">
/*si hay errores*/
		if (<?php echo json_encode(validation_errors())?>) {
			/*muestra los errores por 10 segundos en un diálogo*/
			/*el método json_encode: codifica la variable php a la sintaxis de variable JavaScript para que la pueda interpretar y mostrar*/
			$('#alert2').attr('class','alert alert-danger').html(<?php echo json_encode(validation_errors())?>).fadeIn(10000);
			/*oculta los errores en un transcurse de 5 segundos*/
			$('#alert2').fadeOut(5000);
		}
		/*si el contenedor con id alert1 contiene texto (para este caso el texto va a ser de error)*/
		if ($('#alert1').text()) {
			$('#alert1').attr('class','alert alert-danger').fadeIn(10000);
			$('#alert1').fadeOut(5000);
		}
</script>
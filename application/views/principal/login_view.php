<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url()?>css1/bootstrap.css" type="text/css" rel="stylesheet">
	</head>
	
	<body>
		
		<?php echo validation_errors(); ?>
		
		<form role="form" id="form" name="form" action="<?=base_url()?>login/validar" method="POST">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<div class="col-lg-5">
							<h3 class="form-signin-heading">Sistema Imporcajas</h3>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="email" class="col-lg-3 control-label"> Correo Electrónico :</label>
						<div class="col-lg-5">
							<input type="email" class="form-control" name="usuario_correo" value="<?php echo set_value('usuario_correo'); ?>" id="correoelectronico">
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="contraseña" class="col-lg-3 control-label">Contraseña :</label>
							<div class="col-lg-5">
								<input type="password" class="form-control" name="usuario_password" value="<?php echo set_value('usuario_password'); ?>" id="password">
							</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<div class="col-lg-5">
							<input class="btn btn-default" type="submit" name="ingresar" id="ingresar" value="Ingresar" title="Ingresar Usuario">
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<div class="col-lg-5">			
							<div class="LoginUsuariosError">
							  <?php
							  if(isset($error)){
								 echo "<p>".$error."</p>";
							  }
							  echo form_error('maillogin');
							  ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</form>
	</body>
</html>
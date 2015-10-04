<link href="<?base_url()?>css/micss.css" type="text/css" rel="stylesheet">
<link href="css/calendar-system.css" type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/calendar-es.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>

<br/>

<div class="container-fluid">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Nuevo Ingreso</p>
	</nav>
	<form class="form-group" role="form" id="form" name="form" action="<?=base_url()?>recibocaja/agregarpago" method="POST">
	<div class="row">
	<!-- Inicio de la primera fila 
		datos basicos del recibo de caja-->
	<div class="col-md-6 col-lg-6"><!--Primera columna -->
		<div class="form-group">
			<label for="numeracion">Numeración</label>
			<input type="text" class="form-control input-sm" name="recibocaja_numero" id="recibocaja_numero">
		</div>
		
		<div class="form-group">
			<label for="cliente">Cliente</label>
			<select class="form-control input-sm" name="recibocaja_cliente" id="recibocaja_cliente">
				<?php
					if($mostrar_cliente != FALSE){
						foreach($mostrar_cliente as $row){
							echo "<option value".$row->relacion_id.">".$row->relacion_nombre."</option>";
						}
					}else{
						echo "No hay datos";
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="metodopago">Método de pago</label>
			<select class="form-control input-sm" name="recibocaja_metodo" id="recibocaja_metodo">
				<?php
					if($mostrar_metodopago != FALSE){
						foreach($mostrar_metodopago->result() as $row){
							echo "<option value=".$row->metodopago_id.">".$row->metodopago_nombre."</option>";
						}
					}else{
						echo "No hay datos";
					}
				?>
			</select>
		</div>
	</div><!--Fin de la primera columna -->
	
	
	<div class="col-md-6 col-lg-6"><!--Inicio de la segunda columna -->
		
		<div class="form-group">
			<label for="fecha">Fecha</label>
				<div class="row">
					<div class="col-md-11 col-lg-11">
						<input type="text" class="form-control input-sm" name="recibocaja_fecha" id="recibocaja_fecha">
					</div>
					<div class="col-md-0 col-lg-0">
						<!--<img src="Calendar/img.gif" id="selector" width='20' height='15'>-->
						<span class="glyphicon glyphicon-calendar" id="selector"></span>
					</div>
				</div>			
		</div>
		
		<div class="form-group">
			<label for="descripcion">Descripción</label>
			<textarea class="form-control input-sm" name="recibocaja_descripcion" id="recibocaja_descripcion" rows="4" cols="2" style="resize : none">
			</textarea>
		</div>
		
	</div><!--Fin de la segunda columna -->
	</div><!--Fin de la primera fila -->
<br/>
<hr/>
	<div class="row" id="fila_facturas1">
	</div>
	
</div><!--Fin del container -->
	</form>
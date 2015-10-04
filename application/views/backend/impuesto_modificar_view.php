	<body>
		<div class="container">
		<br>
		<nav class="navbar navbar-default" role="navigation">
			<p class="navbar-text">Modificar Impuesto</p>
		</nav>
		
		<div class="row">
			<div class="col-md-5 col-lg-5">
		<form role="form" id="form" name="form" action="<?=base_url()?>impuesto/modificarEnlace/<?=$impuesto_id?>" method="POST">
		
			<div class="form-group">
			<?php echo form_error('impuesto_nombre'); ?>
				<label for="nombreimpuesto">Nombre :</label>
					
					<input type="text" class="form-control" name="impuesto_nombre" id="impuesto_nombre" value="<?=$impuesto_nombre?>">
					
			</div>
			
			<div class="form-group">
			<?php echo form_error('impuesto_porcentaje'); ?>
				<label for="porcentajeimpuesto">Porcentaje :</label>
				
				<input type="text" class="form-control" name="impuesto_porcentaje" id="impuesto_porcentaje" value="<?=$impuesto_porcentaje?>">
				
			</div>
			
			<div class="form-group">
				<label for="tipoimpuesto">Tipo :</label>
				
					<input type="text" class="form-control" name="impuesto_tipo" id="impuesto_tipo" value="<?=$impuesto_tipo?>">
				
			</div>

			<div class="form-group">
				<label for="descripcionimpuesto">Descripción :</label>
				
					<textarea class="form-control" name="impuesto_descripcion" id="descripcion" rows="4" cols="2" style="resize: none"></textarea>
				
			</div>

			<div class="form_group">
				
				<a class="btn btn-default" href="<?=base_url()?>impuesto/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Impuesto">
				
			</div>

		</form>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).on("ready",function() {
				$('#descripcion').val("<?= $impuesto_descripcion?>");
			});
		</script>
		
	</body>
</html>
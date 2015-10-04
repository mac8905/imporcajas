<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/calendar-system.css">
<script type="text/javascript" src="<?=base_url()?>js/calendar.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/calendar-setup.js"></script>

<br/>

<div class="container-fluid">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Modificar Recibo de Caja</p>
	</nav>
	<form class="form-group" role="form" id="form" name="form" action="<?=base_url()?>recibocaja/guardarCambios/<?=$recibocaja_id?>" method="POST">
	<div class="row"><!--Fila número uno-->
	
	<div class="col-md-6 col-lg-6"><!-- Inicio de la primera columna -->
	
		<div class="form-group">
			<label for="numeracionrecibocaja">Numeración</label>
			<input type="text" class="form-control input-sm" name="recibocaja_numero" id="recibocaja_numero" value=<?=$recibocaja_id?>>
		</div>
		
		<div class="form-group">
			<label for="ClienteReciboCaja">Cliente</label>
			<select class="form-control input sm" name="recibocaja_cliente" id="recibocaja_cliente">
				<?php
					if ($consulta_cliente != FALSE){

						foreach ($consulta_cliente as $row){
								echo "<option value=".$row->relacion_id.">".$row->relacion_nombre."</option>";
						}
					}
					else{
						echo "No hay datos";
					}
				?>						
			</select>
		</div>

		<div class="form-group">
			<label for="recibocaja_metodopago">Método de Pago</label>
			<select class="form-control input sm" name="recibocaja_metodopago" id="recibocaja_metodopago">
				<?php
					if ($consulta_metodo != FALSE){

						foreach ($consulta_metodo->result() as $row){
								echo "<option value=".$row->metodopago_id.">".$row->metodopago_nombre."</option>";
						}
					}
					else{
						echo "No hay datos";
					}
				?>						
			</select>
		</div>		
	</div><!-- Fin de la primera columna -->
	
	<div class="col-md-6 col-lg-6"><!-- Inicio de la segunda columna -->
		<div class="form-group">
			<label for="recibocajaFecha">Fecha</label>		
				<div class="row">
					<div class="col-md-11 col-lg-11">
						<input type="text" class="form-control input-sm" name="recibocaja_fecha" id="recibocaja_fecha" value="<?=$recibocaja_fecha?>">
					</div>
					<div class="col-md-0 col-lg-0">
						<!--<img src="Calendar/img.gif" id="selector" width='20' height='15'>-->
						<span class="glyphicon glyphicon-calendar" id="selector"></span>
					</div>
				</div>
		</div>	
		
		<div class="form-group">
			<label for="recibocajaDescripcion">Descripción </label>
				<textarea class="form-control input-sm" name="recibocaja_descripcion" id="recibocaja_descripcion" rows="4" cols="2" style="resize: none"><?=$recibocaja_observacion?></textarea>
		</div>		
		
	</div><!-- Fin de la segunda columna -->
	
	</div><!-- Fin de la fila número uno-->
	<br/>
	<br/>
	
	<div id="fila"></div>
	<a href="#" id="agregar_campo"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar cuenta</a>
	<hr/>
	<div id="filaretencion"></div>
	<a href="#" id="agregar_camporetencion"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar retención</a>
	</div><!-- fin del container -->
	<hr/>
		<div class="row"><!--Inicio de la tercer fila-->
			<div class="col-md-3 col-lg-3 col-md-offset-8 col-lg-offset-8">
			<table class="table-responsive" style="background-color: rgba(100, 100, 100, 0.09)">
				<tr>
					<td style="text-align:right">
						<label  class="col-md-0 col-lg-0 control-label">Subtotal : &nbsp;</label>
						
					</td>
					<td >
						$ <label id="subtotal"></label>	
					</td>
				</tr>
				<tr>
					<td style="text-align:right">
						<label  class="col-md-0 col-lg-0 control-label">IVA : &nbsp;</label>
						
					</td>
					<td >
						$ <label id="iva"></label>
					</td>
				</tr>
				<tr>
					<td style="text-align:right">
						<label  class="col-md-0 col-lg-0 control-label">Retención : &nbsp; </label>
						
					</td>
					<td>
						$ - <label id="retencion"></label>
					</td>
				</tr>
				<tr>
					<td style="text-align:right">
						<label  class="col-md-0 col-lg-0 control-label">Total : &nbsp;</label>
						
					</td>
					<td >
						$ <label id="total"></label>
					</td>
				</tr>
				
			</table>
			</div>
		</div><!--Fin de la tercera fila-->	
		
		<hr/>
		<div class="row"><!--Inicio de la cuarta fila-->
			<div class="form_group">
				<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
					<a class="btn btn-default" href="<?=base_url()?>recibocaja/datagrid">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Recibo de Caja">
				</div>
			</div>
		</div><!--Fin de la cuarta fila-->	
	
	</form>
	
<script type="text/javascript">
//alert("entra");
jQuery.fn.generaNuevosCampos = function(indice)
	{
		$(this).each(function(){
		  elem = $(this);
		  elem.data("indice",indice);
		  
		  elem.click(function(e){
			 e.preventDefault();
			 elem = $(this);
			 indice = elem.data("indice");
			 texto_insertar = '	<div class="row" id="fila_cuentas'+indice+'"><hr/><div class="col-md-3 col-lg-3"><div class="form-group"><label for="recibocaja_producto">Cuenta</label><select class="form-control input-sm" name="recibocaja_puc[]" id="'+indice+'"><?php if ($consulta_puc != FALSE){foreach ($consulta_puc as $row){echo "<option value=".$row->puc_id.">".$row->puc_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_valor">Valor</label><input type="text" class="form-control input-sm" name="recibocaja_valor[]" id="recibocaja_valor'+indice+'" onkeyup="total('+indice+')"></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_impuesto">Impuesto</label><select class="form-control input-sm" name="recibocaja_impuesto[]" id="recibocaja_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_cantidad">Cantidad</label><input type="text" class="recibocaja_cantidad1 form-control input-sm" name="recibocaja_cantidad[]" id="recibocaja_cantidad'+indice+'" onkeyup="total('+indice+')"></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_total">Total</label><div id="recibocaja_total'+indice+'">0</div></div></div><div class="col-md-1 col-lg-1"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
			 indice ++;
			 elem.data("indice",indice);
			 nuevo_campo = $(texto_insertar);
			 elem.before(nuevo_campo);
		  });
		});
	   return this;
	}
	
jQuery.fn.generaNuevosCamposRetencion = function(indice)
	{
		$(this).each(function(){
		  elem = $(this);
		  elem.data("indice",indice);
		  
		  elem.click(function(e){
			 e.preventDefault();
			 elem = $(this);
			 indice = elem.data("indice");
			 texto_insertar = '	<div class="row" id="fila_retencion'+indice+'"><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_retencion">Tipo de retención</label><select class="form-control input-sm" name="recibocaja_retencion[]" id="recibocaja_retencion'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_retencion != FALSE){foreach($consulta_retencion->result() as $row){echo "<option value=".$row->retencion_id.">".$row->retencion_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_valorretencion">Valor</label><div id="recibocaja_valorretencion"><input type="text" class="form-control input-sm" name="recibocaja_valorretencion[]" id="recibocaja_valorretencion'+indice+'" onkeyup="totalRetencion('+indice+')"></div></div></div><div class="col-md-2 col-lg-2"><a href="#" id="'+indice+'" onclick="eliminarRetencion(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
			 indice ++;
			 elem.data("indice",indice);
			 nuevo_campo = $(texto_insertar);
			 elem.before(nuevo_campo);
		  });
		});
	   return this;
	}	

	$(document).ready(function(){
	
		Calendar.setup({
			inputField: "recibocaja_fecha",
			ifFormat:   "%d / %m / %Y",
			button:     "selector"
		});
	   
	   $("#agregar_campo").generaNuevosCampos(<?php echo count($puc_id)?>+1);
	   $("#agregar_camporetencion").generaNuevosCamposRetencion(<?php echo count($retencion_id)?>+1);
	   
	});
	
	var subtotal = new Array();
	
	function total(id) {
		var cantidad = $("#recibocaja_cantidad"+id).val();
		var precio = $("#recibocaja_valor"+id).val();
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>recibocaja/totalCuenta',
			data : {c : cantidad, p : precio},
			cache : false,
			success : function(data){
				var json = jQuery.parseJSON(data);
				$("#recibocaja_total"+id).html(json.total_recibocaja);
				subtotal[id]=json.total_recibocaja;
				fn_subtotal(subtotal);
				fn_impuesto(id);
				calcularTotal();
			}
		});
	}

	function eliminar(id){
		$("#fila_cuentas"+id).remove();
		var sub = $("#subtotal").html();
		var iva1 = $("#iva").html();
		var result_sub = 0;
		var result_iva = 0;
		var temp = 0;		
		result_sub = sub - subtotal[id];
		result_iva = iva1 - iva[id];
		temp = subtotal[id] + iva[id];
		subtotal.splice(id, 1, 0);
		iva.splice(id,1,0);
		$("#subtotal").html(result_sub);
		$("#iva").html(result_iva);
		resultado = resultado - temp;
		$('#total').html(resultado);	

		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>recibocaja/eliminarFila/<?=$recibocaja_id?>',
			data : {fila : id},
			cache : false
		});
		
	}
	
	function eliminarRetencion(id){
		$("#fila_retencion"+id).remove();
		var sub = $("#subtotal").html();
		var iva1 = $("#iva").html();
		var ret = $("#retencion").html();
		var result_sub = 0;
		var result_iva = 0;
		var result_ret = 0;
		var temp = 0;		
		result_sub = sub;
		result_iva = iva1;
		result_ret = ret - retencion[id];
		temp = retencion[id];
		subtotal.splice(id, 1, 0);
		iva.splice(id,1,0);
		retencion.splice(id,1,0);
		$("#subtotal").html(result_sub);
		$("#iva").html(result_iva);
		$("#retencion").html(result_ret);
		resultado = resultado + temp;
		$('#total').html(resultado);
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>recibocaja/eliminarFilaRetencion/<?=$recibocaja_id?>',
			data : {fila : id},
			cache : false
		});		
	}
	
	function fn_subtotal(subtotal) {
		var acumulador = 0;
		for(var i = 1; i < subtotal.length; i++){
			acumulador += subtotal[i];
		}
		$("#subtotal").html(acumulador);
	}

	var iva = new Array();
	function fn_impuesto(id){
		var impuesto_id = $('#recibocaja_impuesto'+id).val();
		var recibocaja_total = $('#recibocaja_total'+id).html();
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>impuesto/consultarImpuesto',
			data : {id : impuesto_id},
			cache : false,
			success : function(data){
				iva[id] = data * recibocaja_total;
				sumarIVA();
				calcularTotal();
			}
		});
	}

	function sumarIVA(){
		var acumulador = 0;
		for(var i = 1; i < iva.length; i++){
			acumulador += iva[i];
		}
		$('#iva').html(acumulador);
	}	
	
	var retencion = new Array();
	function totalRetencion(id) {
		var valor = $('#recibocaja_valorretencion'+id).val();

		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>recibocaja/retornaRetencion',
			data : {v : valor},
			cache : false,
			success : function(data){
				var json = jQuery.parseJSON(data);
				retencion[id]= json.total_retencion;
				sumarRetencion(retencion);
				calcularTotal();
			}
		});
	}	
			
	function sumarRetencion(retencion){
		var acumulador = 0;
		for(var i = 1; i < retencion.length; i++){
			acumulador += retencion[i];
		}
		$('#retencion').html(acumulador);	
	}
	
	var resultado = 0;
	function calcularTotal() {
		var subtotal = Number($('#subtotal').html());
		var iva = Number($('#iva').html());
		var retencion = Number($('#retencion').html());
		resultado = (subtotal + iva) - (retencion);
		$('#total').html(resultado);
	}
		
	$('#recibocaja_cliente').val(<?= $relacion_id?>);
	$('#recibocaja_metodopago').val(<?= $metodopago_id?>);
	
	var arrPuc_id = <?php echo json_encode($puc_id)?>;
	var arrDetalleproducto_valor = <?php echo json_encode($detallerecibo_valor)?>;
	var arrDetalleproducto_cantidad = <?php echo json_encode($detallerecibo_cantidad)?>;
	var arrImpuesto_id = <?php echo json_encode($impuesto_id)?>;

	for (var indice = 1; indice <= arrPuc_id.length; indice++) {
		texto_insertar = '<div class="row" id="fila_cuentas'+indice+'"><hr/><div class="col-md-3 col-lg-3"><div class="form-group"><label for="recibocaja_producto">Cuenta</label><select class="form-control input-sm" name="recibocaja_puc[]" id="'+indice+'"><?php if ($consulta_puc != FALSE){foreach ($consulta_puc as $row){echo "<option value=".$row->puc_id.">".$row->puc_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_valor">Valor</label><input type="text" class="form-control input-sm" name="recibocaja_valor[]" id="recibocaja_valor'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_valor[indice-1]+'"></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_impuesto">Impuesto</label><select class="form-control input-sm" name="recibocaja_impuesto[]" id="recibocaja_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_cantidad">Cantidad</label><input type="text" class="recibocaja_cantidad1 form-control input-sm" name="recibocaja_cantidad[]" id="recibocaja_cantidad'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_cantidad[indice-1]+'"></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_total">Total</label><div id="recibocaja_total'+indice+'">0</div></div></div><div class="col-md-1 col-lg-1"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
		$('#fila').append(texto_insertar);
		$('#'+indice).val(arrPuc_id[indice-1]);
		$('#recibocaja_impuesto'+indice).val(arrImpuesto_id[indice-1]);
		total(indice);
		}
		var arrRetencion_id = <?php echo json_encode($retencion_id)?>;
		var arrRetencion_valor = <?php echo json_encode($retencion_valor)?>;
		
		for (var indice = 1; indice <= arrRetencion_id.length; indice++) {
			texto_insertar = '	<div class="row" id="fila_retencion'+indice+'"><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_retencion">Tipo de retención</label><select class="form-control input-sm" name="recibocaja_retencion[]" id="recibocaja_retencion'+indice+'"><?php if($consulta_retencion != FALSE){foreach($consulta_retencion->result() as $row){echo "<option value=".$row->retencion_id.">".$row->retencion_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_valorretencion">Valor</label><input type="text" class="form-control input-sm" name="recibocaja_valorretencion[]" id="recibocaja_valorretencion'+indice+'" onkeyup="totalRetencion('+indice+')" value="'+arrRetencion_valor[indice-1]+'"></div></div><div class="col-md-2 col-lg-2"><a href="#" id="'+indice+'" onclick="eliminarRetencion(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
		$('#filaretencion').append(texto_insertar);
		$('#recibocaja_retencion'+indice).val(arrRetencion_id[indice-1]);
		totalRetencion(indice);
	}	
	
</script>	
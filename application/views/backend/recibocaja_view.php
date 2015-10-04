<link href="<?=base_url()?>css/micss.css" type="text/css" rel="stylesheet">

<br/>

<div class="container-fluid">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Nuevo Recibo de Caja</p>
	</nav>
	<form class="form-group" onsubmit="disabled_ce_beneficiario()" role="form" id="form" name="form" action="<?=base_url()?>recibocaja/guardar" method="POST">
	<div class="row"><!--Fila número uno-->
	
	<div class="col-md-6 col-lg-6"><!-- Inicio de la primera columna -->
	
		<div class="form-group">
			<label for="numeracionrecibocaja">Numeración</label>
			<input type="text" class="form-control input-sm" name="recibocaja_numero" id="recibocaja_numero" value="<?php echo $recibocaja_id ?>">
		</div>
		
		<div class="form-group">
			<label for="ClienteReciboCaja">Cliente</label>
			<select class="form-control input sm" name="recibocaja_cliente" id="recibocaja_cliente">
				<option value=""></option>
				<?php
					if ($consulta_beneficiario != FALSE){

						foreach ($consulta_beneficiario as $row){
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
			<label>Fecha</label>
			<input type="date" class="form-control input-sm" name="recibocaja_fecha" id="recibocaja_fecha" value="<?php echo date('Y-m-d') ?>" required>
		</div>
		
		<div class="form-group">
			<label for="recibocajaDescripcion">Descripción </label>
				<textarea class="form-control input-sm" name="recibocaja_descripcion" id="recibocaja_descripcion" rows="4" cols="2" style="resize: none"></textarea>
		</div>		
		
	</div><!-- Fin de la segunda columna -->
	
	</div><!-- Fin de la fila número uno-->
	<br/>
	
<!-- NAVEGACIÓN DE TABS -->
	<hr><h4>¿Asociar este pago a una factura de venta existente?</h4>
	<ul class="nav nav-tabs">
	  <li><a href="#asociar" data-toggle="tab" id="tab_asociar">Asociar</a></li>
	  <li class="active"><a href="#no_asociar" data-toggle="tab" id="tab_no_asociar">No asociar</a></li>
	</ul>
<!-- SECCIÓN DE TABS -->
	<div class="tab-content">
		<!-- ASOCIAR -->
		<div class="tab-pane fade" id="asociar">
			<br>
			<div id="agregar_fv"></div>
		</div>
		<!-- ASOCIAR -->

		<!-- NO ASOCIAR -->
		<div class="tab-pane fade in active" id="no_asociar">
			<br>
<!-- FIN NAVEGACIÓN DE TABS -->				
	
	<div class="row" id="fila_cuentas1">
	
		<div class="col-md-3 col-lg-3"><!-- Inicio de la capa cuenta -->
		<div class="form-group">
			<label for="recibocaja_producto">Cuenta</label>
				<select class="form-control input-sm" name="recibocaja_puc[]" id="1">
					
					<?php
						if ($consulta_puc != FALSE){

							foreach ($consulta_puc as $row){
									echo "<option value=".$row->puc_id.">".$row->puc_nombre."</option>";
							}
						}
						else{
							echo "No hay datos";
						}
					?>
				</select>
		</div>
		</div><!-- Fin de la capa cuenta -->
		
		<div class="col-md-2 col-lg-2"><!-- Inicio de la capa valor -->
		<div class="form-group">
			<label for="recibocaja_valor">Valor</label>
				<input type='text' class='form-control input-sm' name='recibocaja_valor[]' id="recibocaja_valor1" onkeyup="total(1)">
		</div>
		</div><!-- Fin de la capa valor-->	

		<div class="col-md-2 col-lg-2">
		<div class="form-group">
			<label for="recibocaja_impuesto">Impuesto</label>
			<select class="form-control input-sm" name="recibocaja_impuesto[]" id="recibocaja_impuesto1" onchange="fn_impuesto(1)">
			<?php
				if($consulta_impuesto != FALSE){
					foreach($consulta_impuesto->result() as $row){
						echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";
					}
				}else{
					echo "No hay datos";
				}
			?>
			</select>
		</div>
		</div>

		<div class="col-md-2 col-lg-2">
		<div class="form-group">
			<label for="recibocaja_cantidad">Cantidad</label>
				<input type="text" class="recibocaja_cantidad1 form-control input-sm" name="recibocaja_cantidad[]" id="recibocaja_cantidad1" onkeyup="total(1)">
		</div>
		</div>		

		<div class="col-md-2 col-lg-2">
		<div class="form-group">
			<label for="recibocaja_total">Total</label>
				<div id="recibocaja_total1">0</div>
		</div>
		</div>	

		<div class="col-md-1 col-lg-1">
			<a href="#" id="1" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a>
		</div>		
		
	</div><!-- Fin de la segunda fila -->
	<a href="#" id="agregar_campo"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar cuenta</a>
	<br/>
	<hr/>
	<font color="green">¿Te aplicaron alguna retención?</font>
	<br/><br/>
	
	<div class="row" id="fila_retencion1"><!-- Inicio de la tercera fila-->
	<div class="col-md-2 col-lg-2">
		<div class="form-group">
			<label for="recibocaja_retencion">Tipo de retención</label>
			<select class="form-control input-sm" name="recibocaja_retencion[]" id="recibocaja_retencion1">
			<?php
				if($consulta_retencion != FALSE){
					foreach($consulta_retencion->result() as $row){
						echo "<option value=".$row->retencion_id.">".$row->retencion_nombre."</option>";
					}
				}else{
					echo "No hay datos";
				}
			?>
			</select>
		</div>
	</div>
	
	<div class="col-md-2 col-lg-2"><!-- Inicio de la capa valor -->
	<div class="form-group">
		<label for="recibocaja_valorretencion">Valor</label>
			<input type='text' class='form-control input-sm' name='recibocaja_valorretencion[]' id="recibocaja_valorretencion1" onkeyup="totalRetencion(1)">
	</div>
	</div><!-- Fin de la capa valor-->	

	<div class="col-md-2 col-lg-2">
		<a href="#" id="1" onclick="eliminarRetencion(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a>
	</div>	
	
	</div><!-- Fin de la tercera fila-->
	<a href="#" id="agregar_camporetencion"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar retención</a>
	
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

		</div>
		<!-- FIN NO ASOCIAR -->
	</div>
	<!-- FIN SECCIÓN DE TABS -->	
	
	
<script type="text/javascript" src="<?=base_url()?>js/jquery.number.min.js"></script>
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
			 texto_insertar = '	<div class="row" id="fila_retencion'+indice+'"><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_retencion">Tipo de retención</label><select class="form-control input-sm" name="recibocaja_retencion[]" id="recibocaja_retencion'+indice+'"><?php if($consulta_retencion != FALSE){foreach($consulta_retencion->result() as $row){echo "<option value=".$row->retencion_id.">".$row->retencion_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="recibocaja_valorretencion">Valor</label><div id="recibocaja_valorretencion"><input type="text" class="form-control input-sm" name="recibocaja_valorretencion[]" id="recibocaja_valorretencion'+indice+'" onkeyup="totalRetencion('+indice+')"></div></div></div><div class="col-md-2 col-lg-2"><a href="#" id="'+indice+'" onclick="eliminarRetencion(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
			 indice ++;
			 elem.data("indice",indice);
			 nuevo_campo = $(texto_insertar);
			 elem.before(nuevo_campo);
		  });
		});
	   return this;
	}	
	
	var subtotal = new Array();
	
	function total(id) {
		var cantidad = $("#recibocaja_cantidad"+id).val();
		var precio = $("#recibocaja_valor"+id).val().replace(/,/g, '');
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>recibocaja/totalCuenta',
			data : {c : cantidad, p : precio},
			cache : false,
			success : function(data){
				var json = jQuery.parseJSON(data);
				$("#recibocaja_total"+id).html(json.total_recibocaja).number(true,2);
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
	}
	
	function fn_subtotal(subtotal) {
		var acumulador = 0;
		for(var i = 1; i < subtotal.length; i++){
			acumulador += subtotal[i];
		}
		$("#subtotal").html(acumulador).number(true,2);
	}

	var iva = new Array();
	function fn_impuesto(id){
		var impuesto_id = $('#recibocaja_impuesto'+id).val();
		var recibocaja_total = $('#recibocaja_total'+id).html().replace(/,/g, '');
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
		$('#iva').html(acumulador).number(true,2);
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
		$('#retencion').html(acumulador).number(true,2);
	}
	
	var resultado = 0;
	function calcularTotal() {
		var subtotal = Number($('#subtotal').html().replace(/,/g, ''));
		var iva = Number($('#iva').html().replace(/,/g, ''));
		var retencion = Number($('#retencion').html().replace(/,/g, ''));
		resultado = (subtotal + iva) - (retencion);
		$('#total').html(resultado).number(true,2);
	}
	
	//-------------------------------------------------------------------
	//	FACTURA DE VENTA ASOCIADA
	//-------------------------------------------------------------------
	
	/*si factura compra id no es nulo busca los datos de la factura de compra*/
	if (<?php echo json_encode($fv_id)?> != "") {
		$('#tab_asociar').click();
		buscar_beneficiario(<?php echo json_encode($fv_id)?>);
	}
	/*si se hace click sobre este tab entonces se asocia el pago a una factura de compra*/
	$('#tab_asociar').click(function(event) {
		buscar_fc(0);
	});

	$('#tab_no_asociar').click(function(event) {
		$('#recibocaja_cliente').prop('disabled', false);
	});

	function buscar_beneficiario (id) {
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>facturaventa/consultar_id_beneficiario',
			data : {id : id},
			cache : false,
			success : function(data) {
				$('#recibocaja_cliente').val(data);
				buscar_fc(data);
			}
		});
	}

	function buscar_fc (id) {
		$('#agregar_fv').html('');
		$('#recibocaja_cliente').prop('disabled', true);
		var beneficiario_id = '';
		if (id == 0) {
			beneficiario_id = $('#recibocaja_cliente').val();
		}
		else {
			beneficiario_id = id;	
		}
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>facturaventa/consultarFV',
			data : {id : beneficiario_id},
			cache : false,
			success : function(data1) {
				var json = jQuery.parseJSON(data1);
				if (json != false) {
					$("#agregar_fv").agregar_fv(json);
				};
			}
		});
	}

	/*se agregan datos correspondientes a la factura de compra*/
	jQuery.fn.agregar_fv = function(json){
		var insertar = Array();
		table_ini = '<table class="table-responsive table table-hover table-bordered">';
		table_header = '<thead><tr><th>Número</th><th>Total</th><th>Retención</th><th>Por pagar</th><th>Pagado</th><th>Valor a pagar</th></tr></thead>';
		table_body_ini = '<tbody>';
		insertar = table_ini + table_header + table_body_ini;
		var cont = 0;
		$.each(json, function(indice, value) {
			var numero = '<tr><td class="col-md-1 col-lg-1" id="fv_numero'+indice+'"># '+value.facturav_id+'</td><input type="hidden" name="fv_numero[]" value="'+value.facturav_id+'">';
			var total = '<td class="col-md-2 col-lg-2" id="fv_total'+indice+'">$'+value.fv_total+'</td>';
			var retencion = '<td class="col-md-2 col-lg-2" id="fv_val_rete'+indice+'">$'+value.fv_val_rete+'</td>';
			var x_pagar = '<td class="col-md-2 col-lg-2" id="fv_x_pagar'+indice+'">$'+value.fv_x_pagar+'<input type="hidden" name="input_fv_x_pagar[]" id="input_fv_x_pagar'+indice+'" value="'+value.fv_x_pagar+'"></td>';
			var pagado = '<td class="col-md-2 col-lg-2" id="fv_val_pagado'+indice+'">$'+value.fv_val_pagado+'</td>';
			var valor_pagar = '<td class="col-md-2 col-lg-2"><div class="input-group"><span class="input-group-addon">$</span><input type="text" class="form-control input-sm" name="fv_val_pagar[]" id="fv_val_pagar'+indice+'" ondblclick="acumularTotal_fc('+indice+')" onclick="no_modificar_total_fc('+indice+')" onblur="acumularTotal_fc('+indice+')"></div></td></tr>';
			insertar += numero + total + retencion + x_pagar + pagado + valor_pagar;
			cont++;
		});
		table_body_fin = '</tbody>';
		table_fin = '</table>';
		totales = '<div class="row" id="fc_fila_totales"><div class="col-md-3 col-lg-3 col-md-offset-10 col-lg-offset-10"><table class="table-responsive" style="background-color: rgba(100, 100, 100, 0.09)"><tr><td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">Total : &nbsp;</label></td><td >$ <label id="fv_totales">0</label><input type="hidden" name="fv_totales" id="input_fv_totales" value="0"></td></tr></table></div></div>';
		errors = '<div class="error_fc1"></div><div class="error_fc2"></div>';
		botones = '<br><div class="row"><div class="form_group"><div class="col-md-3 col-lg-3 col-md-offset-10 col-lg-offset-10"><a class="btn btn-default" href="<?=base_url()?>facturaventa/datagrid">Cancelar</a><input class="btn btn-default" onclick="guardar_fc_asoc('+cont+')" type="submit" id="guardar2" value="Guardar" title="Guardar Recibo de Caja"></div></div></div>';
		insertar += table_body_fin + table_fin + totales + errors +botones;
		$("#agregar_fv").append(insertar);
	}

	function acumularTotal_fc (id) {
		total = Number($('#fv_totales').html().replace(/,/g, ''));
		val_pagar = Number($('#fv_val_pagar'+id).val().replace(/,/g, ''));
		if (val_pagar != "") {
			total += val_pagar;
			$('#fv_totales').html(total).number(true,2);
			$('#input_fv_totales').val(total);
		}
	}

	function no_modificar_total_fc (id) {
		val_pagar = $('#fv_val_pagar'+id).val();
		total = Number($('#fv_totales').html().replace(/,/g, ''));
		$('#fv_val_pagar'+id).val(val_pagar);
		if (val_pagar != "" && total > 0) {
			total = total - val_pagar;
			$('#fv_totales').html(total).number(true,2);
		}
	}
	
	//-----------------------------------------------------------------------
	//	FUNCIONES PARA GUARDAR LAS ENTRADAS DE DINERO DE LA FACTURA DE VENTA
	//-----------------------------------------------------------------------
	
	function guardar_fc_asoc (id) {
		/*se captura el momento en el que se va a enviar el formulario*/
		$('#form').submit(function () {
			/*si el total es diferente de cero*/
			if ($('#input_fv_totales').val() != 0) {
				/*mirar que el valor a pagar sea menor o igual no superior en c/u de los campos*/
				var menor = 0;
				for (var i = 0; i < id; i++) {
					if (Number($('#fv_val_pagar'+i).val().replace(/,/g, '')) <= Number($('#input_fv_x_pagar'+i).val().replace(/,/g, ''))) {
						menor++;
					}
				}
				if(menor == id) {
					$('#form').prop('action', '<?=base_url()?>recibocaja/guardar_fv_asoc');
					return true;
				}
				else{
					$('.error_fc2').attr('class','alert alert-danger').html("Ingrese un valor menor o igual al valor por pagar").fadeIn(10000).fadeOut(10000);
					for (var i = 0; i < id; i++) {
						$('#fv_val_pagar'+i).css('box-shadow','0px 0px 5px red');
					}
					return false;
				}
			}
			else {
				/*muestra el error en un cuadro de mensaje*/
				$('.error_fc1').attr('class','alert alert-danger').html("Ingrese un valor a pagar en por lo menos una de las facturas de venta").fadeIn(10000).fadeOut(10000);
				/*recorre los input de valor a pagar y sombrea los bordes con rojo*/
				for (var i = 0; i < id; i++) {
					$('#fv_val_pagar'+i).css('box-shadow','0px 0px 5px red');
				};
				return false;
			}
		});
	}

	function disabled_ce_beneficiario (argument) {
		/*cuando se envia el formulario se habilita la selección de un beneficiario*/
			$('#recibocaja_cliente').prop('disabled', false);
	}
		
</script>
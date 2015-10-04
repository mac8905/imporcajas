<link href="<?=base_url()?>css/micss.css" type="text/css" rel="stylesheet">

<br>
<div class="container-fluid">
<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Comprobante de Egreso</p>
</nav>

<form class="form-group" onsubmit="disabled_ce_beneficiario()" role="form" id="form" action="<?=base_url()?>comprobanteegreso/guardar" name="form" method="POST"><!-- inicio formulario comprobante -->

	<div class="row"><!-- inicio fila 1 -->
		<div class="col-md-6 col-lg-6"><!-- Inicio fila 1 columna 1 -->
			<!-- NUMERACION -->
			<div class="form-group">
				<label>Numeración</label>
				<input type="text" class="form-control input-sm" name="ce_id" id="ce_id" value="<?php echo $ce_id ?>" required>
			</div>
			<!-- FIN NUMERACION -->
			<!-- BENEFICIARIO -->
			<div class="form-group">
				<label>Beneficiario</label>
				<select class="form-control input sm" name="ce_beneficiario" id="ce_beneficiario" required>
					<option value=""></option>
					<?php
						if ($consulta_beneficiario != FALSE) {
							foreach ($consulta_beneficiario as $row) {
									echo "<option value=".$row->relacion_id.">".$row->relacion_nombre."</option>";
							}
						}
						else{
							echo "No hay datos";
						}
					?>
				</select>
			</div>
			<!-- FIN BENEFICIARIO -->
			<div class="form-group">
				<label>Método de Pago</label>
				<select class="form-control input sm" name="ce_metodopago" id="ce_metodopago" required>
					<option value=""></option>
					<?php
						if ($consulta_metodo != FALSE) {
							foreach ($consulta_metodo->result() as $row) {
									echo "<option value=".$row->metodopago_id.">".$row->metodopago_nombre."</option>";
							}
						}
						else{
							echo "No hay datos";
						}
					?>						
				</select>
			</div>
		</div><!-- Fin fila 1 columna 1  -->

		<div class="col-md-6 col-lg-6"><!-- Inicio fila 1 columna 2 -->
			<div class="form-group">
				<label>Fecha</label>
				<input type="date" class="form-control input-sm"name="ce_fecha" value="<?php echo date('Y-m-d') ?>" required>
			</div>

			<div class="form-group">
				<label>Observación </label>
				<textarea class="form-control input-sm" name="ce_observacion" id="ce_observacion" rows="4" cols="2" style="resize: none"></textarea>
			</div>
		</div><!-- fin fila 1 columna 2 -->
	</div><!-- fin fila 1 -->

<!-- NAVEGACIÓN DE TABS -->
	<hr><h4>¿Asociar este pago a una factura de compra existente?</h4>
	<ul class="nav nav-tabs">
	  <li><a href="#asociar" data-toggle="tab" id="tab_asociar">Asociar</a></li>
	  <li class="active"><a href="#no_asociar" data-toggle="tab" id="tab_no_asociar">No asociar</a></li>
	</ul>
<!-- SECCIÓN DE TABS -->
	<div class="tab-content">
		<!-- ASOCIAR -->
		<div class="tab-pane fade" id="asociar">
			<br>
			<div id="agregar_fc"></div>
		</div>
		<!-- ASOCIAR -->

		<!-- NO ASOCIAR -->
		<div class="tab-pane fade in active" id="no_asociar">
			<br>

<!--INICIA FILA CATEGORÍA
		____________________________________________________________________________________________

		dce = detalle comprobante egreso
-->
			<div class="row" id="fila_categoria1">
<!-- CATEGORIA -->
				<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label class="col-md-0 col-lg-0 control-label">Categoría</label>
						<div class="col-md-0 col-lg-0">
							<select class="form-control input-sm" name="dce_categoria[]" id="1">
								<option value=""></option>
								<?php
								if ($consulta_puc != FALSE){ ?>
									<optgroup label="Egresos">
									<?php 
									foreach ($consulta_puc as $row){
											echo "<option value=".$row->puc_id.">".$row->puc_nombre."</option>";
									} ?>	
									</optgroup>
									<?php 
								}
								else{
									echo "No hay datos";
								} ?>
							</select>
						</div>
					</div>
				</div>
<!-- FIN CATEGORIA -->
<!-- VALOR -->
				<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label for="dce_valor" class="col-md-0 col-lg-0 control-label">Valor</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div id="dce_valor">
									<div class="input-group">
										<span class="input-group-addon">$</span>
										<input type='text' class='form-control input-sm' name='dce_valor[]' id="dce_valor1" onkeyup="total(1)">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<!-- FIN VALOR -->
<!-- IMPUESTO -->
				<div class="col-md-2 col-lg-2">
					<div class="form-group">
						<label class="col-md-0 col-lg-0 control-label">Impuesto</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<select class="form-control input-sm" name="dce_impuesto[]" id="dce_impuesto1" onchange="fn_impuesto(1)">
									<option value=""></option>
									<?php
									if($consulta_impuesto != FALSE){
										foreach($consulta_impuesto->result() as $row){
											echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";
										}
									}else{
										echo "No hay datos";
									} ?>
								</select>
							</div>
						</div>
					</div>
				</div>
<!-- FIN IMPUESTO -->
<!-- CANTIDAD -->
				<div class="col-md-1 col-lg-1">
					<div class="form-group">
						<label class="col-md-0 col-lg-0 control-label">Cantidad</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<input type="text" class="dce_cantidad1 form-control input-sm" name="dce_cantidad[]" id="dce_cantidad1" onkeyup="total(1)" value="0">
							</div>
						</div>
					</div>
				</div>
<!-- FIN CANTIDAD -->
<!-- TOTAL -->
				<div class="col-md-1 col-lg-1">
					<div class="form-group">
						<label class="col-md-0 col-lg-0 control-label">Total</label>
							<div class="col-md-12 col-lg-12" >
								<div class="row" id="dce_total_cat1">0</div>
								<input type="hidden" name="dce_total[]" id="dce_total1">
							</div>
					</div>
				</div>
<!-- FIN TOTAL -->
<!-- ELIMINAR -->
				<div class="col-md-3 col-lg-3">
					<a href="#" onclick="eliminar_dce_categoria(1)"><span style="padding-top: 26px;" class="eliminar glyphicon glyphicon-minus-sign"></span></a>
				</div>
<!-- FIN ELIMINAR -->
			</div>
<!--____________________________________________________________________________________________
		FIN FILA CATEGORÍA
-->
			<a href="#" id="nueva_fila_categoria"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar categoría</a>
			<hr>
			<a href="#" id="agregar_retencion"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar retención</a>

<!-- TOTALES -->
			<div class="row" id="fila_totales"><!--Inicio fila 3-->
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
								<label  class="col-md-0 col-lg-0 control-label">Retención : &nbsp; </label>
							</td>
							<td>
							-$ <label id="retencion"></label>
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
			</div><!-- fin fila 3 -->
<!-- FIN TOTALES -->
			<hr>
<!-- BOTONES -->
			<div class="row">
				<div class="form_group">
					<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
						<a class="btn btn-default" href="<?=base_url()?>comprobanteegreso/datagrid">Cancelar</a>
						<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Comprobante de egreso">
					</div>
				</div>
			</div>
<!-- FIN BOTONES -->
</form><!-- fin formulario comprobante -->

		</div>
		<!-- FIN NO ASOCIAR -->
	</div>
<!-- FIN SECCIÓN DE TABS -->

<script type="text/javascript" src="<?=base_url()?>js/jquery.number.min.js"></script>
<script type="text/javascript">
	jQuery.fn.generaNuevaRetencion = function(indice){
	$(this).each(function (){
		elem = $(this);
	  elem.data("indice",indice);
	  
	  elem.click(function(e){
			e.preventDefault();
			elem = $(this);
			indice = elem.data("indice");
			ini_rete = '';
			ini_val = '';
			estilo_eliminar = '';
			fin = '</div>';
			if (indice == 1) {
				ini_rete = '<label>Retención</label>';
				ini_val = '<label>Valor</label>';
				estilo_eliminar = 'style="padding-top: 26px;"';
			}
			
			ini = '<div class="row" id="fila_ce_retencion'+indice+'">';
			retencion = '<div class="col-md-3 col-lg-3"><div class="form-group">'+ini_rete+'<select class="form-control input-sm" name="ce_retencion[]" onchange="ce_retencion('+indice+')" id="ce_retencion'+indice+'"><option value=""></option><?php if ($consulta_retencion) { foreach ($consulta_retencion->result() as $row) { echo "<option value=".$row->retencion_id.">".$row->retencion_nombre." - (".$row->retencion_porcentaje."%)</option>"; } } else { echo "<option value=\"\">No hay datos</option>"; } ?> </select>'+fin+'</div>';
			valor = '<div class="col-md-3 col-lg-3"><div class="form-group">'+ini_val+'<div class="input-group"><span class="input-group-addon">$</span><input id="rete_valor'+indice+'" class="form-control input-sm" type="text" name="rete_valor[]"></div>'+fin+'</div>';
			eliminar = '<div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminarRetencion(this.id)"><span '+estilo_eliminar+' class="eliminar glyphicon glyphicon-minus-sign"></span></a></div>';
			fin ='</div>';
			texto_insertar = ini + retencion + valor + eliminar + fin;
			indice ++;
			elem.data("indice",indice);
			nuevo_campo = $(texto_insertar);
			elem.before(nuevo_campo);
		});
	});
	return this;
	}
	jQuery.fn.agregar_categoria = function(indice){
		$(this).each(function(){
		  elem = $(this);
		  elem.data("indice",indice);
		  
		  elem.click(function(e){
			 	e.preventDefault();
			 	elem = $(this);
			 	indice = elem.data("indice");
				var ini = '<div class="row" id="fila_categoria1">';
				var categoria = '<div class="col-md-2 col-lg-2"><div class="form-group"><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="dce_categoria[]" id="'+indice+'"><option value=""></option><?php if ($consulta_puc != FALSE){ ?> <optgroup label="Egresos"><?php foreach ($consulta_puc as $row){ echo "<option value=".$row->puc_id.">".$row->puc_nombre."</option>"; } ?>	</optgroup><?php }else{ echo "No hay "; } ?> </select></div></div></div>';
				var valor = '<div class="col-md-2 col-lg-2"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><div id="dce_valor"><div class="input-group"><span class="input-group-addon">$</span><input type="text" class="form-control input-sm" name="dce_valor[]" id="dce_valor'+indice+'" onkeyup="total('+indice+')"></div></div></div></div></div></div>';
				var impuesto = '<div class="col-md-2 col-lg-2"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="dce_impuesto[]" id="dce_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"> <option value=""></option><?php if($consulta_impuesto != FALSE){ foreach($consulta_impuesto->result() as $row){ echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>"; } }else{ echo "No hay datos"; } ?> </select></div></div></div></div>';
				var cantidad = '<div class="col-md-1 col-lg-1"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="dce_cantidad'+indice+' form-control input-sm" name="dce_cantidad[]" id="dce_cantidad'+indice+'" onkeyup="total('+indice+')" value="0"></div></div></div></div>';
				var total = '<div class="col-md-1 col-lg-1"><div class="form-group"><div class="col-md-12 col-lg-12" ><div class="row" id="dce_total_cat'+indice+'">0</div><input type="hidden" name="dce_total[]" id="dce_total'+indice+'"></div></div></div>';
				var eliminar = '<div class="col-md-3 col-lg-3"><a href="#" onclick="eliminar_dce_categoria('+indice+')"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div>';
				var fin = '</div>';
				var texto_insertar = ini + categoria + valor + impuesto + cantidad + total + eliminar + fin;
				indice ++;
		 		elem.data("indice",indice);
		 		nuevo_campo = $(texto_insertar);
		 		elem.before(nuevo_campo);
	  	});
		});
	  return this;
	}

	$(document).ready(function() {
	   
		$("#agregar_retencion").generaNuevaRetencion(1);
		$("#nueva_fila_categoria").agregar_categoria(2);
	   
	});
	
	var subtotal = new Array();
	
	function total(id) {
		var cantidad = $("#dce_cantidad"+id).val();
		var valor = $("#dce_valor"+id).val();
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>comprobanteegreso/totalCategoria',
			data : {c : cantidad, p : valor},
			cache : false,
			success : function(data) {
				var json = jQuery.parseJSON(data);
				$("#dce_total_cat"+id).html(json.dce_total);
				$("#dce_total"+id).val(json.dce_total);
				subtotal[id]=json.dce_total;
				fn_subtotal(subtotal);
				fn_impuesto(id);
				calcularTotal();
			}
		});
	}

	// function eliminar(id) {
	// 	$("#fila_cuentas"+id).remove();
	// 	var sub = $("#subtotal").html();
	// 	var iva1 = $("#iva").html();
	// 	var result_sub = 0;
	// 	var result_iva = 0;
	// 	var temp = 0;		
	// 	result_sub = sub - subtotal[id];
	// 	result_iva = iva1 - iva[id];
	// 	temp = subtotal[id] + iva[id];
	// 	subtotal.splice(id, 1, 0);
	// 	iva.splice(id,1,0);
	// 	$("#subtotal").html(result_sub);
	// 	$("#iva").html(result_iva);
	// 	resultado = resultado - temp;
	// 	$('#total').html(resultado);		
	// }
	
	// function eliminarRetencion(id) {
	// 	$("#fila_retencion"+id).remove();
	// 	var sub = $("#subtotal").html();
	// 	var iva1 = $("#iva").html();
	// 	var ret = $("#retencion").html();
	// 	var result_sub = 0;
	// 	var result_iva = 0;
	// 	var result_ret = 0;
	// 	var temp = 0;		
	// 	result_sub = sub;
	// 	result_iva = iva1;
	// 	result_ret = ret - retencion[id];
	// 	temp = retencion[id];
	// 	subtotal.splice(id, 1, 0);
	// 	iva.splice(id,1,0);
	// 	retencion.splice(id,1,0);
	// 	$("#subtotal").html(result_sub);
	// 	$("#iva").html(result_iva);
	// 	$("#retencion").html(result_ret);
	// 	resultado = resultado + temp;
	// 	$('#total').html(resultado);
	// }
	
	function fn_subtotal(subtotal) {
		var acumulador = 0;
		for(var i = 1; i < subtotal.length; i++) {
			acumulador += subtotal[i];
		}
		$("#subtotal").html(acumulador);
	}

	// var iva = new Array();
	// function fn_impuesto(id) {
	// 	var impuesto_id = $('#comprobante_impuesto'+id).val();
	// 	var comprobante_total = $('#comprobante_total'+id).html();
	// 	$.ajax({
	// 		type : "POST",
	// 		url : '<?=base_url()?>impuesto/consultarImpuesto',
	// 		data : {id : impuesto_id},
	// 		cache : false,
	// 		success : function(data) {
	// 			iva[id] = data * comprobante_total;
	// 			sumarIVA();
	// 			calcularTotal();
	// 		}
	// 	});
	// }

	// function sumarIVA() {
	// 	var acumulador = 0;
	// 	for(var i = 1; i < iva.length; i++) {
	// 		acumulador += iva[i];
	// 	}
	// 	$('#iva').html(acumulador);
	// }	
	
	// var retencion = new Array();
	// function totalRetencion(id) {
	// 	var valor = $('#rete_valor'+id).val();

	// 	$.ajax ({
	// 		type : "POST",
	// 		url : '<?=base_url()?>comprobanteegreso/retornaRetencion',
	// 		data : {v : valor},
	// 		cache : false,
	// 		success : function(data) {
	// 			var json = jQuery.parseJSON(data);
	// 			retencion[id]= json.total_retencion;
	// 			sumarRetencion(retencion);
	// 			calcularTotal();
	// 		}
	// 	});
	// }	
			
	// function sumarRetencion(retencion) {
	// 	var acumulador = 0;
	// 	for(var i = 1; i < retencion.length; i++) {
	// 		acumulador += retencion[i];
	// 	}
	// 	$('#retencion').html(acumulador);	
	// }
	
	// var resultado = 0;
	// function calcularTotal() {
	// 	var subtotal = Number($('#subtotal').html());
	// 	var iva = Number($('#iva').html());
	// 	var retencion = Number($('#retencion').html());
	// 	resultado = (subtotal + iva) - (retencion);
	// 	$('#total').html(resultado);
	// }

	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
																	FACTURA DE COMPRA ASOCIADA
		+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

	/*si factura compra id no es nulo busca los datos de la factura de compra*/
	if (<?php echo json_encode($fc_id)?> != "") {
		$('#tab_asociar').click();
		buscar_beneficiario(<?php echo json_encode($fc_id)?>);
	}
/*si se hace click sobre este tab entonces se asocia el pago a una factura de compra*/
	$('#tab_asociar').click(function(event) {
		buscar_fc(0);
	});

	$('#tab_no_asociar').click(function(event) {
		$('#ce_beneficiario').prop('disabled', false);
	});

	function buscar_beneficiario (id) {
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>facturacompra/consultar_id_beneficiario',
			data : {id : id},
			cache : false,
			success : function(data) {
				$('#ce_beneficiario').val(data);
				buscar_fc(data);
			}
		});
	}

	function buscar_fc (id) {
		$('#agregar_fc').html('');
		$('#ce_beneficiario').prop('disabled', true);
		var beneficiario_id = '';
		if (id == 0) {
			beneficiario_id = $('#ce_beneficiario').val();
		}
		else {
			beneficiario_id = id;	
		}
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>facturacompra/consultarFC',
			data : {id : beneficiario_id},
			cache : false,
			success : function(data1) {
				var json = jQuery.parseJSON(data1);
				if (json != false) {
					$("#agregar_fc").agregar_fc(json);
				};
			}
		});
	}

	function ce_retencion(id) {
		var ce_subtotal = $('#subtotal').html().replace(/,/g, '');
		var rete_id = $('#ce_retencion'+id).val().replace(/,/g, '');
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>retencion/consultarRetencion',
			data : {id : rete_id},
			cache : false,
			success : function(ptj_rete) {
				valor = ptj_rete * ce_subtotal;
				$('#rete_valor'+id).val(valor).number(true,2);
			}
		});
	}

	/*se agregan datos correspondientes a la factura de compra*/
	jQuery.fn.agregar_fc = function(json){
		var insertar = Array();
		table_ini = '<table class="table-responsive table table-hover table-bordered">';
		table_header = '<thead><tr><th>Número</th><th>Total</th><th>Retención</th><th>Por pagar</th><th>Pagado</th><th>Valor a pagar</th></tr></thead>';
		table_body_ini = '<tbody>';
		insertar = table_ini + table_header + table_body_ini;
		var cont = 0;
		$.each(json, function(indice, value) {
			var numero = '<tr><td class="col-md-1 col-lg-1" id="fc_numero'+indice+'"># '+value.facturacompra_id+'</td><input type="hidden" name="fc_numero[]" value="'+value.facturacompra_id+'">';
			var total = '<td class="col-md-2 col-lg-2" id="fc_total'+indice+'">$'+value.fc_total+'</td>';
			var retencion = '<td class="col-md-2 col-lg-2" id="fc_val_rete'+indice+'">$'+value.fc_val_rete+'</td>';
			var x_pagar = '<td class="col-md-2 col-lg-2" id="fc_x_pagar'+indice+'">$'+value.fc_x_pagar+'<input type="hidden" name="input_fc_x_pagar[]" id="input_fc_x_pagar'+indice+'" value="'+value.fc_x_pagar+'"></td>';
			var pagado = '<td class="col-md-2 col-lg-2" id="fc_val_pagado'+indice+'">$'+value.fc_val_pagado+'</td>';
			var valor_pagar = '<td class="col-md-2 col-lg-2"><div class="input-group"><span class="input-group-addon">$</span><input type="text" class="form-control input-sm" name="fc_val_pagar[]" id="fc_val_pagar'+indice+'" ondblclick="acumularTotal_fc('+indice+')" onclick="no_modificar_total_fc('+indice+')" onblur="acumularTotal_fc('+indice+')"></div></td></tr>';
			insertar += numero + total + retencion + x_pagar + pagado + valor_pagar;
			cont++;
		});
		table_body_fin = '</tbody>';
		table_fin = '</table>';
		totales = '<div class="row" id="fc_fila_totales"><div class="col-md-3 col-lg-3 col-md-offset-10 col-lg-offset-10"><table class="table-responsive" style="background-color: rgba(100, 100, 100, 0.09)"><tr><td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">Total : &nbsp;</label></td><td >$ <label id="fc_totales">0</label><input type="hidden" name="fc_totales" id="input_fc_totales" value="0"></td></tr></table></div></div>';
		errors = '<div class="error_fc1"></div><div class="error_fc2"></div>';
		botones = '<br><div class="row"><div class="form_group"><div class="col-md-3 col-lg-3 col-md-offset-10 col-lg-offset-10"><a class="btn btn-default" href="<?=base_url()?>facturacompra/datagrid">Cancelar</a><input class="btn btn-default" onclick="guardar_fc_asoc('+cont+')" type="submit" id="guardar2" value="Guardar" title="Guardar Comprobante de Egreso"></div></div></div>';
		insertar += table_body_fin + table_fin + totales + errors +botones;
		$("#agregar_fc").append(insertar);
	}

	function acumularTotal_fc (id) {
		total = Number($('#fc_totales').html().replace(/,/g, ''));
		val_pagar = Number($('#fc_val_pagar'+id).val().replace(/,/g, ''));
		if (val_pagar != "") {
			total += val_pagar;
			$('#fc_totales').html(total).number(true,2);
			$('#input_fc_totales').val(total);
		}
	}

	function no_modificar_total_fc (id) {
		val_pagar = $('#fc_val_pagar'+id).val().replace(/,/g, '');
		total = Number($('#fc_totales').html().replace(/,/g, ''));
		$('#fc_val_pagar'+id).val(val_pagar).number(true,2);
		if (val_pagar != "" && total > 0) {
			total = total - val_pagar;
			$('#fc_totales').html(total).number(true,2);
		}
	}

	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
										Funcion para guardar la factura de compra asociada
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

	function guardar_fc_asoc (id) {
		/*se captura el momento en el que se va a enviar el formulario*/
		$('#form').submit(function () {
			/*si el total es diferente de cero*/
			if ($('#input_fc_totales').val() != 0) {
				/*mirar que el valor a pagar sea menor o igual no superior en c/u de los campos*/
				var menor = 0;
				for (var i = 0; i < id; i++) {
					if (Number($('#fc_val_pagar'+i).val().replace(/,/g, '')) <= Number($('#input_fc_x_pagar'+i).val().replace(/,/g, ''))) {
						menor++;
					}
				}
				if(menor == id) {
					$('#form').prop('action', '<?=base_url()?>comprobanteegreso/guardar_fc_asoc');
					return true;
				}
				else{
					$('.error_fc2').attr('class','alert alert-danger').html("Ingrese un valor menor o igual al valor por pagar").fadeIn(10000).fadeOut(10000);
					for (var i = 0; i < id; i++) {
						$('#fc_val_pagar'+i).css('box-shadow','0px 0px 5px red');
					}
					return false;
				}
			}
			else {
				/*muestra el error en un cuadro de mensaje*/
				$('.error_fc1').attr('class','alert alert-danger').html("Ingrese un valor a pagar en por lo menos una de las facturas de compra").fadeIn(10000).fadeOut(10000);
				/*recorre los input de valor a pagar y sombrea los bordes con rojo*/
				for (var i = 0; i < id; i++) {
					$('#fc_val_pagar'+i).css('box-shadow','0px 0px 5px red');
				};
				return false;
			}
		});
	}

	function disabled_ce_beneficiario (argument) {
		/*cuando se envia el formulario se habilita la selección de un beneficiario*/
			$('#ce_beneficiario').prop('disabled', false);
	}

</script>
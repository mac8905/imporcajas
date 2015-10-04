<br />
<div class="container-fluid">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Nueva Factura de Compra</p>
	</nav>
	<form class="form-group" role="form" id="form" name="form" action="<?=base_url()?>facturacompra/guardar" method="POST">
		<div class="row"><!-- Inicio de la primera fila-->
			<div class="col-md-6 col-lg-6"><!--Inicio de la primera columna -->
				<div class="form-group">
					<label>Número</label>
						<input type="text" class="form-control input-sm" name="facturacompra_numero" id="facturacompra_numero" value="<?php echo $fc_id ?>" required>
				</div>
				
				<div class="form-group">
					<label>Proveedor</label>
						<select class="form-control input sm" name="facturacompra_proveedor" id="facturacompra_proveedor" required>
							<?php
								if ($consulta_proveedor != FALSE){

									foreach ($consulta_proveedor as $row){
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
					<label>Observación </label>
						<textarea class="form-control input-sm" name="facturacompra_observacion" id="facturacompra_observacion" rows="4" cols="2" style="resize: none"></textarea>
				</div>
				
			</div><!--Fin de la primera columna -->
			
			<div class="col-md-6 col-lg-6"><!--Inicio de la segunda columna -->
			
				<div class="form-group">
					<label>Fecha :</label>
					<input type="date" class="form-control input-sm" name="fecha" value="<?php echo date('Y-m-d') ?>" required>
				</div>

				<div class="form-group">
					<label>Fecha vencimiento :</label>
					<input type="date" class="form-control input-sm" name="fechavencimiento" value="<?php echo date('Y-m-d') ?>" required>
				</div>
				
			</div><!--Fin de la segunda columna -->
			
		</div><!--Fin de la primera fila -->
		<hr>

		<div class="row" id="fila_productos1"><!--Inicio de la segunda fila-->
			<div class="col-md-2 col-lg-2">
				<div class="form-group">
					<label for="facturacompra_producto" class="col-md-0 col-lg-0 control-label">Categoría</label>
					<div class="col-md-0 col-lg-0">
						<select class="form-control input-sm" name="facturacompra_producto[]" id="1" required>
							<option value=""></option>
							<?php
								if ($consulta_categoria){ ?>
									<optgroup label="Items inventariables">
									<?php 
									foreach ($consulta_categoria['item']['categoria_id'] as $key => $id) {
											echo "<option value=".$id.">".$consulta_categoria['item']['categoria_nombre'][$key]."</option>";
									} ?>	
									</optgroup>
									<optgroup label="Egresos">
									<?php 
									foreach ($consulta_categoria['puc']['categoria_id'] as $key => $id) {
											echo "<option value=".$id.">".$consulta_categoria['puc']['categoria_nombre'][$key]."</option>";
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
			
			<div class="col-md-2 col-lg-2">
				<div class="form-group">
					<label for="facturacompra_precio" class="col-md-0 col-lg-0 control-label">Precio</label>
					<div class="col-md-12 col-lg-12">
						<div class="row">
							<div id="facturacompra_preciov">
								<div class="input-group">
									<span class="input-group-addon">$</span>
									<input type='text' class='form-control input-sm' name='facturacompra_precio[]' id="facturacompra_precio1" onkeyup="total(1)" required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-1 col-lg-1">
				<div class="form-group">
					<label for="facturacompra_descuento" class="col-md-0 col-lg-0 control-label">Desc%</label>
					<div class="col-md-12 col-lg-12">
						<div class="row">
							<input type="text" class="form-control input-sm" name="facturacompra_descuento[]" id="facturacompra_descuento1" onkeyup="total(1)" value="0">
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-2 col-lg-2">
				<div class="form-group">
					<label for="facturacompra_impuesto" class="col-md-0 col-lg-0 control-label">Impuesto</label>
					<div class="col-md-12 col-lg-12">
						<div class="row">
							<select class="form-control input-sm" name="facturacompra_impuesto[]" id="facturacompra_impuesto1" onchange="fn_impuesto(1)">
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
				</div>
			</div>

			<div class="col-md-1 col-lg-1">
				<div class="form-group">
					<label for="facturacompra_cantidad" class="col-md-0 col-lg-0 control-label">Cantidad</label>
					<div class="col-md-12 col-lg-12">
						<div class="row">
							<input type="text" class="facturacompra_cantidad1 form-control input-sm" name="facturacompra_cantidad[]" id="facturacompra_cantidad1" onkeyup="total(1)" value="1" required>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-1 col-lg-1">
				<div class="form-group">
					<label for="facturacompra_total" class="col-md-0 col-lg-0 control-label">Total</label>
						<div class="col-md-12 col-lg-12" >
							<div class="row" id="facturacompra_total1">0</div>
						</div>
				</div>
			</div>
			<div class="col-md-3 col-lg-3">
				<a href="#" id="1" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign" style="padding-top: 26px;"></span></a>
			</div>
		</div><!--Fin de la segunda fila-->

		<a href="#" id="agregar_campo"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar categoría</a>
		<hr>
		<a href="#" id="agregar_retencion"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar retención</a>
		<hr>

</div><!--Fin container-fluid-->
		
		<div class="row"><!--Inicio de la tercer fila-->
			<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
			<table class="table-responsive" style="background-color: rgba(100, 100, 100, 0.09)">
				<tr>
					<td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">Subtotal : &nbsp;</label></td>
					<td>$ <label id="subtotal_sin_desc"></label></td>
					<input type="hidden" name="fc_subtotal_sin_desc" id="fc_subtotal_sin_desc">
				</tr>
				<tr>
					<td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">Descuento : &nbsp;</label></td>
					<td>-$ <label id="descuento"></label></td>
					<input type="hidden" name="fc_descuento" id="fc_descuento">
				</tr>
				<tr>
					<td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">Subtotal : &nbsp;</label></td>
					<td>$ <label id="subtotal"></label></td>
					<input type="hidden" name="fc_subtotal" id="fc_subtotal">
				</tr>
				<tr>
					<td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">IVA : &nbsp;</label></td>
					<td>$ <label id="iva"></label></td>
					<input type="hidden" name="fc_iva" id="fc_iva">
				</tr>
				<tr>
					<td style="text-align:right"><label  class="col-md-0 col-lg-0 control-label">Total : &nbsp;</label></td>
					<td>$ <label id="total"></label></td>
					<input type="hidden" name="fc_total" id="fc_total">
				</tr>
			</table>
			</div>
		</div><!--Fin de la tercera fila-->
			
		<br/> <!-- Botones cancelar y guardar -->
		<div class="row"><!--Inicio de la cuarta fila-->
			<div class="form_group">
				<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
					<a class="btn btn-default" href="<?=base_url()?>facturacompra/datagrid">Cancelar</a>
					<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Factura de Compra">
				</div>
			</div>
		</div><!--Fin de la cuarta fila-->
	</form>

<!-- agregar el plugin para el formato de precios -->
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
			var ini_rete = '';
			var ini_val = '';
			var estilo_eliminar = '';
			fin = '</div>';
			if (indice == 1) {
				ini_rete = '<label>Retención</label>';
				ini_val = '<label>Valor</label>';
				estilo_eliminar = 'style="padding-top: 26px;"';
			}
			
			var ini = '<div class="row" id="fila_ce_retencion'+indice+'">';
			var retencion = '<div class="col-md-3 col-lg-3"><div class="form-group">'+ini_rete+'<select class="form-control input-sm" name="ce_retencion[]" onchange="retencion('+indice+')" id="ce_retencion'+indice+'"><option value=""></option><?php if ($consulta_retencion) { foreach ($consulta_retencion->result() as $row) { echo "<option value=".$row->retencion_id.">".$row->retencion_nombre." - (".$row->retencion_porcentaje."%)</option>"; } } else { echo "<option value=\"\">No hay datos</option>"; } ?> </select>'+fin+'</div>';
			var valor = '<div class="col-md-2 col-lg-2"><div class="form-group">'+ini_val+'<div class="input-group"><span class="input-group-addon">$</span><input id="rete_valor'+indice+'" class="form-control input-sm" type="text" name="rete_valor[]"></div>'+fin+'</div>';
			var eliminar = '<div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar_retencion(this.id)"><span '+estilo_eliminar+' class="eliminar glyphicon glyphicon-minus-sign"></span></a></div>';
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

jQuery.fn.generaNuevosCampos = function(indice){
	$(this).each(function(){
	  elem = $(this);
	  elem.data("indice",indice);
	  
	  elem.click(function(e){
		 	e.preventDefault();
		 	elem = $(this);
		 	indice = elem.data("indice");
		 	texto_insertar = '<div class="row" id="fila_productos'+indice+'"><div class="col-md-2 col-lg-2"><div class="form-group"><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="facturacompra_producto[]" id="'+indice+'" required><option value=""></option><?php if ($consulta_categoria != FALSE){ ?> <optgroup label="Items inventariables"><?php foreach ($consulta_categoria['item']['categoria_id'] as $key => $id) {echo "<option value=".$id.">".$consulta_categoria['item']['categoria_nombre'][$key]."</option>";} ?>	</optgroup><optgroup label="Egresos"><?php foreach ($consulta_categoria['puc']['categoria_id'] as $key => $id) {echo "<option value=".$id.">".$consulta_categoria['puc']['categoria_nombre'][$key]."</option>";} ?></optgroup> <?php }else{echo "No hay datos";}?></select></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><div id="facturacompra_preciov"><div class="input-group"><span class="input-group-addon">$</span><input type="text" class="form-control input-sm" name="facturacompra_precio[]" id="facturacompra_precio'+indice+'" onkeyup="total('+indice+')" required></div></div></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturacompra_descuento[]" id="facturacompra_descuento'+indice+'" onkeyup="total('+indice+')" value="0"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="facturacompra_impuesto[]" id="facturacompra_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturacompra_cantidad[]" id="facturacompra_cantidad'+indice+'" onkeyup="total('+indice+')" value="1" required></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><div class="col-md-12 col-lg-12"><div class="row" id="facturacompra_total'+indice+'">0</div></div></div></div><div class="col-md-3 col-lg-3"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
		 		indice ++;
		 		elem.data("indice",indice);
		 		nuevo_campo = $(texto_insertar);
		 		elem.before(nuevo_campo);
  	});
	});
  return this;
	}

	$(document).ready(function(){
	   
	  $("#agregar_campo").generaNuevosCampos(2);
	  $("#agregar_retencion").generaNuevaRetencion(1);
	   
	  $(this).change(function(e) {
			$.ajax ({
				type : "POST",
				url : '<?=base_url()?>facturacompra/consultarPrecio',
				data : {q : $(e.target).val()},
				cache : false,
				success : function(data) {
					var temp = jQuery.parseJSON(data);
					$("#facturacompra_precio"+(e.target.id)).val(temp.precio).number(true);
					$("#input_precio"+(e.target.id)).val(temp.precio);
					$("#facturacompra_impuesto"+(e.target.id)).val(temp.impuesto);
					total(e.target.id);
				}
			});
			return false;
		});
	});
	
	var subtotal = new Array();
	var descuento = new Array();
	var subtotal_sin_desc = new Array();
	descuento[0]=0;
	
	function total(id) {
		var cantidad = $("#facturacompra_cantidad"+id).val();
		var precio = $("#facturacompra_precio"+id).val().replace(/,/g, '');
		var desc = $("#facturacompra_descuento"+id).val();
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>facturacompra/totalProducto',
			data : {c : cantidad, p : precio, d : desc},
			cache : false,
			success : function(data){
				var json = jQuery.parseJSON(data);
				$("#facturacompra_total"+id).html(json.total_facturacompra).number(true);
				subtotal[id]=json.total_facturacompra;
				descuento[id]=json.des;
				subtotal_sin_desc[id]=json.sub;
				fn_subtotal(subtotal, subtotal_sin_desc);
				fn_descuento(descuento);
				fn_impuesto(id);
				calcularTotal();
			}
		});
	}
	
	function fn_subtotal(subtotal, subtotal_sin_desc) {
		var acumulador1 = 0;
		var acumulador2 = 0;
		for(var i = 1; i < subtotal.length; i++){
			acumulador1 += subtotal[i];
			acumulador2 += subtotal_sin_desc[i];
		}
		$("#subtotal").html(acumulador1).number(true);
		$("#fc_subtotal").val(acumulador1);
		$("#subtotal_sin_desc").html(acumulador2).number(true);
		$("#fc_subtotal_sin_desc").val(acumulador2);

	}	
	
	function fn_descuento(descuento) {
		var acumulador = 0;
		for(var i = 1; i < descuento.length; i++){
			acumulador += descuento[i];
		}
		$("#descuento").html(acumulador).number(true);
		$("#fc_descuento").val(acumulador);
	}
	
	function eliminar(id) {
		if ($("#facturacompra_cantidad"+id).val() != 0) {
			var sub = $("#subtotal").html().replace(/,/g, '');
			var des = $("#descuento").html().replace(/,/g, '');
			var sub_sin_desc = $("#subtotal_sin_desc").html().replace(/,/g, '');
			var iva1 = $("#iva").html().replace(/,/g, '');
			var result_sub = 0;
			var result_des = 0;
			var result_sub_sin_desc = 0;
			var result_iva = 0;
			var temp = 0;		
			result_sub = sub - subtotal[id];
			result_des = des - descuento[id];
			result_sub_sin_desc = sub_sin_desc - subtotal_sin_desc[id];
			result_iva = iva1 - iva[id];
			temp = subtotal[id] + iva[id];
			subtotal.splice(id, 1, 0);
			descuento.splice(id, 1, 0);
			subtotal_sin_desc.splice(id, 1, 0);
			iva.splice(id,1,0);
			$("#subtotal").html(result_sub).number(true);
			$("#descuento").html(result_des).number(true);
			$("#subtotal_sin_desc").html(result_sub_sin_desc).number(true);
			$("#iva").html(result_iva).number(true);
			resultado = resultado - temp;
			$('#total').html(resultado).number(true);
		}
		$("#fila_productos"+id).remove();
	}
	
	var iva = new Array();
	function fn_impuesto(id) {
		var impuesto_id = $('#facturacompra_impuesto'+id).val().replace(/,/g, '');
		var facturacompra_total = $('#facturacompra_total'+id).html().replace(/,/g, '');
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>impuesto/consultarImpuesto',
			data : {id : impuesto_id},
			cache : false,
			success : function(data) {
				iva[id] = data * facturacompra_total;
				sumarIVA();
				calcularTotal();
			}
		});
	}
	
	function sumarIVA() {
		var acumulador = 0;
		for(var i = 1; i < iva.length; i++){
			acumulador += iva[i];
		}
		$('#iva').html(acumulador).number(true,2);
		$('#fc_iva').val(acumulador);
	}

	var resultado = 0;
	function calcularTotal() {
		var subtotal = Number($('#subtotal').html().replace(/,/g, ''));
		var descuento = Number($('#descuento').html().replace(/,/g, ''));
		var iva = Number($('#iva').html().replace(/,/g, ''));
		resultado = (subtotal) + iva;
		$('#total').html(resultado).number(true,2);
		$('#fc_total').val(resultado);
	}

	function retencion (id) {
		var subtotal = $('#subtotal').html().replace(/,/g, '');
		var rete_id = $('#ce_retencion'+id).val().replace(/,/g, '');
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>retencion/consultarRetencion',
			data : {id : rete_id},
			cache : false,
			success : function(ptj_rete) {
				valor = ptj_rete * subtotal;
				$('#rete_valor'+id).val(valor).number(true,2);
			}
		});
	}

	function eliminar_retencion (id) {
		$('#fila_ce_retencion'+id).remove();
	}
</script>
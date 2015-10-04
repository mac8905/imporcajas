
<!-- fila -->
<br />
<div class="container-fluid">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Modificar Factura de Venta</p>
	</nav>
	
<form class="form-group" role="form" id="form" name="form" action="<?=base_url()?>facturaventa/guardarCambios/<?=$id?>" method="POST">
		<div class="row"><!--Inicio de la primera fila-->
			<div class="col-md-6 col-lg-6">
			
			<div class="form-group">
					<label for="facturav_cliente" class="col-md-3 col-lg-3 control-label">Cliente :</label>
					<div class="col-md-12 col-lg-12">
						<select class="form-control input-sm" name="facturav_cliente" id="facturav_cliente" >
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
			</div>	
				
			<div class="form-group">
				<label for="facturav_observación" class="col-md-12 col-lg-12 control-label">Observación :</label>
					<div class="col-md-12 col-lg-12">	
						<textarea class="form-control input-sm" name="facturav_observacion" id="facturav_observacion" rows="4" cols="2" style="resize: none"><?= $facturav_observacion?></textarea>
					</div>
			</div>	
				
			</div><!--Fin de la primera columna-->
			
			<div class="col-md-6 col-lg-6">
			
				<div class="form-group">
					<label for="FacturaVentaFecha" class="col-md-12 col-lg-12 control-label">Fecha :</label>
					<input type="date" class="form-control input-sm" name="fecha" value="<?= $facturav_fecha?>"required>
				</div>
				
				<div class="form-group">
					<label for="FacturaVentaFechaVencimiento" class="col-md-12 col-lg-12 control-label">Fecha vencimiento :</label>
					<input type="date" class="form-control input-sm" name="fechavencimiento" value="<?= $facturav_fechavencimiento?>" required>
				</div>
				
				<div class="form-group">
					<label for="facturav_observación" class="col-md-12 col-lg-12 control-label">Descripción :</label>
						<div class="col-md-11 col-lg-11">	
							<textarea class="form-control input-sm" name="facturav_descripcion" id="facturav_descripcion" rows="4" cols="2" style="resize: none"><?= $facturav_descripcion?></textarea>
						</div>
				</div>						
			</div><!--Fin de la segunda columna-->
		</div> <!-- Fin de la primera fila -->
		<br />
		<br />
		<div id="fila"></div>
		<a href="#" id="agregar_campo"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar producto</a>
		<hr/>
		<div id="filaretencion"></div>
		<a href="#" id="agregar_camporetencion"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar retención</a>
			
</div><!--Fin container-fluid-->
		
		
	<br/>
	<div class="row"><!--Inicio de la tercer fila-->
		<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
		<table class="table-responsive" style="background-color: rgba(100, 100, 100, 0.09)">
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">Subtotal : &nbsp;</label>
					
				</td>
				<td >
					$ <label id="subtotal_sin_des"></label>	
				</td>
				<input type="hidden" name="fv_subtotal_sin_des" id="fv_subtotal_sin_des">
			</tr>
			
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">Descuento : &nbsp;</label>
					
				</td>
				<td >
					$ - <label id="descuento"></label>
				</td>
				<input type="hidden" name="fv_descuento" id="fv_descuento">
			</tr>
			
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">Subtotal : &nbsp;</label>
					
				</td>
				<td >
					$ <label id="subtotal"></label>	
				</td>
				<input type="hidden" name="fv_subtotal" id="fv_subtotal">
			</tr>			
			
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">IVA : &nbsp;</label>
					
				</td>
				<td >
					$ <label id="iva"></label>
				</td>
				<input type="hidden" name="fv_iva" id="fv_iva">
			</tr>
			
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">Retenciones : &nbsp;</label>
					
				</td>
				<td >
					$ <label id="retencion"></label>
				</td>
				<input type="hidden" name="fv_retencion" id="fv_retencion">
			</tr>			
			
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">Total : &nbsp;</label>
					
				</td>
				<td >
					$ <label id="total"></label>
					<!-- agregar cambios -->
					<input type="hidden" id="fv_total" name="fv_total" value="">
				</td>
			</tr>
			
		</table>
		</div>
	</div><!--Fin de la tercera fila-->
	
	<br/>
	<div class="row"><!--Inicio de la cuarta fila-->
		<div class="form_group">
			<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
				<a class="btn btn-default" href="<?=base_url()?>facturaventa/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Factura Venta">
			</div>
		</div>
	</div><!--Fin de la cuarta fila-->
	
</form>

<script type="text/javascript" src="<?=base_url()?>js/jquery.number.min.js"></script>	
<script type="text/javascript"> 
jQuery.fn.generaNuevosCampos = function(indice)
	{
		$(this).each(function(){
		  elem = $(this);
		  elem.data("indice",indice);
		  
		  elem.click(function(e){
			 e.preventDefault();
			 elem = $(this);
			 indice = elem.data("indice");
			 texto_insertar = '<div class="row" id="fila_productos'+indice+'"><hr /><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa" class="col-md-0 col-lg-0 control-label">Producto</label><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="facturaventa_producto[]" id="'+indice+'"><?php if ($consulta_producto != FALSE){echo "<option>Seleccione un producto</option>"; foreach ($consulta_producto as $row){echo "<option value=".$row->producto_id.">".$row->producto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa_tamano" class="col-md-0 col-lg-0 control-label">Tamaño</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturaventa_tamano[]" id="facturaventa_tamano'+indice+'" placeholder="alto-ancho-largo" title="alto-ancho-largo"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa_precio" class="col-md-0 col-lg-0 control-label">Precio</label><div class="col-md-12 col-lg-12"><div class="row"><div id="facturaventa_preciov"><div class="input-group"><span class="input-group-addon">$</span><input type="text" class="form-control input-sm" name="facturaventa_precio[]" id="facturaventa_precio'+indice+'" onkeyup="total('+indice+')"></div></div></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="facturaventa_descuento" class="col-md-0 col-lg-0 control-label">Desc%</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturaventa_descuento[]" id="facturaventa_descuento'+indice+'" onkeyup="total('+indice+')" value="0"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa_impuesto" class="col-md-0 col-lg-0 control-label">Impuesto</label><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="facturaventa_impuesto[]" id="facturaventa_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="facturaventa_cantidad" class="col-md-0 col-lg-0 control-label">Cantidad</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturaventa_cantidad[]" id="facturaventa_cantidad'+indice+'" onkeyup="total('+indice+')"></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="facturaventa_total" class="col-md-0 col-lg-0 control-label">Total</label><div class="col-md-12 col-lg-12"><div class="row" id="facturaventa_total'+indice+'">0</div></div></div></div><div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
			 indice ++;
			 elem.data("indice",indice);
			 nuevo_campo = $(texto_insertar);
			 elem.before(nuevo_campo);
		  });
		});
	   return this;
	}
	
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
			var retencion = '<div class="col-md-3 col-lg-3"><div class="form-group">'+ini_rete+'<select class="form-control input-sm" name="ce_retencion[]" onchange="retencionTotal('+indice+')" id="ce_retencion'+indice+'"><option value=""></option><?php if ($consulta_retencion) { foreach ($consulta_retencion->result() as $row) { echo "<option value=".$row->retencion_id.">".$row->retencion_nombre." - (".$row->retencion_porcentaje."%)</option>"; } } else { echo "<option value=\"\">No hay datos</option>"; } ?> </select>'+fin+'</div>';
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

	$(document).ready(function(){
	   
		$("#agregar_campo").generaNuevosCampos(<?php echo count($producto_id)?>+1);
	    $("#agregar_camporetencion").generaNuevaRetencion(<?php echo count($retencion_id)?>+1);
	   
	   $(this).change(function(e) {
			$.ajax ({
				type : "POST",
				url : '<?=base_url()?>facturaventa/consultarPrecio',
				data : {q : $(e.target).val()},
				cache : false,
				success : function(data) {
					var temp = jQuery.parseJSON(data);
					$("#facturaventa_tamano"+(e.target.id)).attr("value", temp.tamano);
					$("#facturaventa_precio"+(e.target.id)).attr("value", temp.precio);
					$("#facturaventa_impuesto"+(e.target.id)).val(temp.impuesto);
				}
			});
			return false;
		});
	}); 
	
	var subtotal = new Array();
	var descuento = new Array();
	var subtotal_sin_des = new Array();
	descuento[0]=0;
	
	function total(id) {
		var cantidad = $("#facturaventa_cantidad"+id).val();
		var precio = $("#facturaventa_precio"+id).val().replace(/,/g, '');
		var desc = $("#facturaventa_descuento"+id).val();
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>facturaventa/totalProducto',
			data : {c : cantidad, p : precio, d : desc},
			cache : false,
			success : function(data){
				var json = jQuery.parseJSON(data);
				$("#facturaventa_total"+id).html(json.total_facturaventa).number(true,2);
				subtotal[id]=json.total_facturaventa;
				descuento[id]=json.des;
				subtotal_sin_des[id]=json.sub;
				fn_subtotal(subtotal,subtotal_sin_des);
				fn_descuento(descuento);
				fn_impuesto(id);
				calcularTotal();
				retencionTotal(id);
			}
		});
		
	}
	
	function fn_subtotal(subtotal,subtotal_sin_des) {
		var acumulador1 = 0;
		var acumulador2 = 0;
		for(var i = 1; i < subtotal.length; i++){
			acumulador1 += subtotal[i];
			acumulador2 += subtotal_sin_des[i];
		}
		$("#subtotal").html(acumulador1).number(true,2);
		$("#fv_subtotal").val(acumulador1);
		$("#subtotal_sin_des").html(acumulador2).number(true,2);
		$("#fv_subtotal_sin_des").val(acumulador2);		
	}	
	
	function fn_descuento(descuento) {
		var acumulador = 0;
		for(var i = 1; i < descuento.length; i++){
			acumulador += descuento[i];
		}
		$("#descuento").html(acumulador).number(true,2);
		$("#fv_descuento").val(acumulador);
	}
	
	function eliminar(id) {
		if ($("#facturaventa_cantidad"+id).val() != 0) {
			var sub = $("#subtotal").html().replace(/,/g, '');
			var des = $("#descuento").html().replace(/,/g, '');
			var sub_sin_desc = $("#subtotal_sin_des").html().replace(/,/g, '');
			var iva1 = $("#iva").html().replace(/,/g, '');
			var result_sub = 0;
			var result_des = 0;
			var result_sub_sin_des = 0;
			var result_iva = 0;
			var temp = 0;		
			result_sub = sub - subtotal[id];
			result_des = des - descuento[id];
			result_sub_sin_des = sub_sin_desc - subtotal_sin_des[id];
			result_iva = iva1 - iva[id];
			temp = subtotal[id] + iva[id];
			subtotal.splice(id, 1, 0);
			descuento.splice(id, 1, 0);
			subtotal_sin_des.splice(id, 1, 0);
			iva.splice(id,1,0);
			$("#subtotal").html(result_sub).number(true,2);
			$("#descuento").html(result_des).number(true,2);
			$("#subtotal_sin_des").html(result_sub_sin_des).number(true,2);
			$("#iva").html(result_iva).number(true,2);
			resultado = resultado - temp;
			$('#total').html(resultado).number(true,2);
		}
		$("#fila_productos"+id).remove();
	}	
	
	var iva = new Array();
	function fn_impuesto(id) {
		var impuesto_id = $('#facturaventa_impuesto'+id).val().replace(/,/g, '');
		var facturaventa_total = $('#facturaventa_total'+id).html().replace(/,/g, '');
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>impuesto/consultarImpuesto',
			data : {id : impuesto_id},
			cache : false,
			success : function(data) {
				iva[id] = data * facturaventa_total;
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
		$('#fv_iva').val(acumulador);
	}
	
	var retenciones = new Array();
	function retencionTotal (id) {
		var subtotal = $('#subtotal').html().replace(/,/g, '');
		var rete_id = $('#ce_retencion'+id).val().replace(/,/g, '');
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>retencion/consultarRetencion',
			data : {id : rete_id},
			cache : false,
			success : function(ptj_rete) {
				retenciones[id] = ptj_rete * subtotal;
				$('#rete_valor'+id).val(retenciones[id]).number(true,2);
				sumarRetencion(retenciones);
				calcularTotal();
			}
		});
	}

	/*function retencionTotal1 (id) {
		var subtotal = $('#subtotal').html().replace(/,/g, '');
		var rete_id = $('#ce_retencion1'+id).val().replace(/,/g, '');
		alert(rete_id);
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>retencion/consultarRetencion',
			data : {id : rete_id},
			cache : false,
			success : function(ptj_rete) {
				retenciones[id] = ptj_rete * subtotal;
				$('#rete_valor1'+id).val(retenciones[id]).number(true,2);
				sumarRetencion(retenciones);
				calcularTotal();
			}
		});
	}*/
	
	function sumarRetencion(retenciones){
		var retenacumulador = 0;
		for(var i = 1; i < retenciones.length; i++){
			retenacumulador += retenciones[i];
		}
		$('#retencion').html(retenacumulador).number(true,2);
		$('#fv_retencion').val(retenacumulador);		
	}
	
	function eliminar_retencion(id) {
		if ($("#rete_valor"+id).val() != 0) {			
			var sub = $("#subtotal").html().replace(/,/g, '');
			var des = $("#descuento").html().replace(/,/g, '');
			var sub_sin_desc = $("#subtotal_sin_des").html().replace(/,/g, '');
			var iva1 = $("#iva").html().replace(/,/g, '');
			var ret = $("#retencion").html().replace(/,/g, '');
			var result_sub = 0;
			var result_des = 0;
			var result_sub_sin_des = 0;
			var result_iva = 0;
			var result_ret = 0;
			var temp = 0;		
			result_sub = sub;
			result_des = des;
			result_sub_sin_des = sub_sin_desc;
			result_iva = iva1;
			result_ret = ret - retenciones[id];
			temp = retenciones[id];
			subtotal.splice(id, 1, 0);
			descuento.splice(id, 1, 0);
			subtotal_sin_des.splice(id, 1, 0);
			iva.splice(id,1,0);
			retenciones.splice(id,1,0);
			$("#subtotal").html(result_sub).number(true,2);
			$("#descuento").html(result_des).number(true,2);
			$("#subtotal_sin_des").html(result_sub_sin_des).number(true,2);
			$("#iva").html(result_iva).number(true,2);
			$("#retencion").html(result_ret).number(true,2);
			resultado = resultado + temp;
			$('#total').html(resultado).number(true,2);
		}
		$('#fila_ce_retencion'+id).remove();
	}
	
	var resultado = 0;
	function calcularTotal() {
		var subtotal = Number($('#subtotal').html().replace(/,/g, ''));
		var descuento = Number($('#descuento').html().replace(/,/g, ''));
		var iva = Number($('#iva').html().replace(/,/g, ''));
		var retencion1 = Number($('#retencion').html().replace(/,/g, ''));
		resultado = ((subtotal) + iva) - retencion1;
		$('#total').html(resultado).number(true,2);
		$('#fv_total').val(resultado);
		//resultado = (subtotal) + iva;
		//$('#total').html(resultado);
	}	
	
	$('#facturav_cliente').val(<?= $relacion_id?>);
	var arrProducto_id = <?php echo json_encode($producto_id)?>;
	var arrDetalleproducto_tamano = <?php echo json_encode($detalleproducto_tamano)?>;
	var arrDetalleproducto_precio = <?php echo json_encode($detalleproducto_precio)?>;
	var arrDetalleproducto_descuento = <?php echo json_encode($detalleproducto_descuento)?>;
	var arrImpuesto_id = <?php echo json_encode($impuesto_id)?>;
	var arrDetalleproducto_cantidad = <?php echo json_encode($detalleproducto_cantidad)?>;
	
	for (var indice = 1; indice <= arrProducto_id.length; indice++) {
		texto_insertar = '<div class="row" id="fila_productos'+indice+'"><hr /><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa" class="col-md-0 col-lg-0 control-label">Producto</label><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="facturaventa_producto[]" id="'+indice+'"><?php if ($consulta_producto != FALSE){echo "<option>Seleccione un producto</option>"; foreach ($consulta_producto as $row){echo "<option value=".$row->producto_id.">".$row->producto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa_tamano" class="col-md-0 col-lg-0 control-label">Tamaño</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturaventa_tamano[]" id="facturaventa_tamano'+indice+'" placeholder="alto-ancho-largo" title="alto-ancho-largo" value="'+arrDetalleproducto_tamano[indice-1]+'"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa_precio" class="col-md-0 col-lg-0 control-label">Precio</label><div class="col-md-12 col-lg-12"><div class="row"><div id="facturaventa_preciov"><div class="input-group"><span class="input-group-addon">$</span><input type="text" class="form-control input-sm" name="facturaventa_precio[]" id="facturaventa_precio'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_precio[indice-1]+'"></div></div></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="facturaventa_descuento" class="col-md-0 col-lg-0 control-label">Desc%</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturaventa_descuento[]" id="facturaventa_descuento'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_descuento[indice-1]+'"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="facturaventa_impuesto" class="col-md-0 col-lg-0 control-label">Impuesto</label><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="facturaventa_impuesto[]" id="facturaventa_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="facturaventa_cantidad" class="col-md-0 col-lg-0 control-label">Cantidad</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="facturaventa_cantidad[]" id="facturaventa_cantidad'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_cantidad[indice-1]+'"></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="facturaventa_total" class="col-md-0 col-lg-0 control-label">Total</label><div class="col-md-12 col-lg-12"><div class="row" id="facturaventa_total'+indice+'">0</div></div></div></div><div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
		$('#fila').append(texto_insertar);
		$('#'+indice).val(arrProducto_id[indice-1]);
		$('#facturaventa_impuesto'+indice).val(arrImpuesto_id[indice-1]);
		total(indice);
	}
	
	var arrRetencion_id = <?php echo json_encode($retencion_id)?>;
	var arrRetencion_valor = <?php echo json_encode($retencion_valor)?>;
	
	for (var indice = 1; indice <= arrRetencion_id.length; indice++) {	
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
			var retencion = '<div class="col-md-3 col-lg-3"><div class="form-group">'+ini_rete+'<select class="form-control input-sm" name="ce_retencion[]" onchange="retencionTotal('+indice+')" id="ce_retencion'+indice+'"><option value=""></option><?php if ($consulta_retencion) { foreach ($consulta_retencion->result() as $row) { echo "<option value=".$row->retencion_id.">".$row->retencion_nombre." - (".$row->retencion_porcentaje."%)</option>"; } } else { echo "<option value=\"\">No hay datos</option>"; } ?> </select>'+fin+'</div>';
			var valor = '<div class="col-md-2 col-lg-2"><div class="form-group">'+ini_val+'<div class="input-group"><span class="input-group-addon">$</span><input id="rete_valor'+indice+'" class="form-control input-sm" type="text" name="rete_valor[]" value="'+arrRetencion_valor[indice-1]+'"></div>'+fin+'</div>';
			var eliminar = '<div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar_retencion(this.id)"><span '+estilo_eliminar+' class="eliminar glyphicon glyphicon-minus-sign"></span></a></div>';
			fin ='</div>';
			texto_insertar = ini + retencion + valor + eliminar + fin;		
		$('#filaretencion').append(texto_insertar);
		$('#ce_retencion'+indice).val(arrRetencion_id[indice-1]);
	}
	setTimeout(function() {for (var indice = 1; indice <= arrRetencion_id.length; indice++) {	
		retencionTotal(indice);
	}},500);
	
</script>
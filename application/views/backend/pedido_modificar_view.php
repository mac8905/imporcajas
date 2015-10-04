<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>css/calendar-system.css">
<script type="text/javascript" src="<?=base_url()?>js/calendar.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/calendar-setup.js"></script>

<br />
<div class="container-fluid">
	<nav class="navbar navbar-default" role="navigation">
		<p class="navbar-text">Modificar Pedido</p>
	</nav>
	
<form class="form-group" role="form" id="form" name="form" action="<?=base_url()?>pedido/guardarCambios/<?=$id?>" method="POST">
		<div class="row"><!--Inicio de la primera fila-->
			<div class="col-md-6 col-lg-6">
			
			<div class="form-group">
					<label for="pedido" class="col-md-3 col-lg-3 control-label">Cliente :</label>
					<div class="col-md-12 col-lg-12">
						<select class="form-control input-sm" name="pedido_cliente" id="pedido_cliente" >
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
				<label for="pedidoobservación" class="col-md-12 col-lg-12 control-label">Observación :</label>
					<div class="col-md-12 col-lg-12">	
						<textarea class="form-control input-sm" name="pedido_observacion" id="pedido_observacion" rows="4" cols="2" style="resize: none"><?= $pedido_observacion?></textarea>
					</div>
			</div>	
				
			</div><!--Fin de la primera columna-->
			
			<div class="col-md-6 col-lg-6">
			
				<div class="form-group">
					<label for="pedidocalendario" class="col-md-12 col-lg-12 control-label">Fecha :</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div class="col-md-11 col-lg-11">
								<input type="text" class="form-control input-sm" name="fecha" id="fecha" value="<?= $pedido_fecha?>">
								</div>
								<div class="col-md-0 col-lg-0">
									<!--<img src="Calendar/img.gif" id="selector" width='20' height='15'>-->
									<span class="glyphicon glyphicon-calendar" id="selector"></span>
								</div>
							</div>
						</div>
				</div>
	
				<div class="form-group">
					<label for="pedidocalendario" class="col-md-12 col-lg-12 control-label">Fecha vencimiento :</label>
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div class="col-md-11 col-lg-11">
								<input type="text" class="form-control input-sm" name="fechavencimiento" id="fechavencimiento" value="<?= $pedido_fechavencimiento?>">
								</div>
								<div class="col-md-0 col-lg-0">
									<!--<img src="Calendar/img.gif" id="selectorv" width='20' height='15'>-->
									<span class="glyphicon glyphicon-calendar" id="selectorv"></span>
								</div>
							</div>
						</div>
				</div>
				
				<div class="form-group">
					<label for="pedidoobservación" class="col-md-12 col-lg-12 control-label">Descripción :</label>
						<div class="col-md-11 col-lg-11">	
							<textarea class="form-control input-sm" name="pedido_descripcion" id="pedido_descripcion" rows="4" cols="2" style="resize: none"><?= $pedido_descripcion?></textarea>
						</div>
				</div>						
			</div><!--Fin de la segunda columna-->
		</div> <!-- Fin de la primera fila -->
		<br />
		<br />
		
		<div id="fila"></div>
		<a href="#" id="agregar_campo"><span class="agregar glyphicon glyphicon-plus-sign"></span> Agregar producto</a>
			
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
					$ <label id="subtotal"></label>	
				</td>
			</tr>
			<tr>
				<td style="text-align:right">
					<label  class="col-md-0 col-lg-0 control-label">Descuento : &nbsp;</label>
					
				</td>
				<td >
					 - $ <label id="descuento"></label>
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
					<label  class="col-md-0 col-lg-0 control-label">Total : &nbsp;</label>
					
				</td>
				<td >
					$ <label id="total"></label>
				</td>
			</tr>
			
		</table>
		</div>
	</div><!--Fin de la tercera fila-->
	
	<br/>
	<div class="row"><!--Inicio de la cuarta fila-->
		<div class="form_group">
			<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9">
				<a class="btn btn-default" href="<?=base_url()?>pedido/datagrid">Cancelar</a>
				<input class="btn btn-default" type="submit" name="guardar" id="guardar" value="Guardar" title="Guardar Pedido">
			</div>
		</div>
	</div><!--Fin de la cuarta fila-->
	
</form>

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
			 texto_insertar = '<div class="row" id="fila_productos'+indice+'"><hr /><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedido" class="col-md-0 col-lg-0 control-label">Producto</label><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="pedido_producto[]" id="'+indice+'"><?php if ($consulta_producto != FALSE){foreach ($consulta_producto as $row){echo "<option value=".$row->producto_id.">".$row->producto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidotamano" class="col-md-0 col-lg-0 control-label">Tamaño</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_tamano[]" id="pedido_tamano'+indice+'" placeholder="alto-ancho-largo" title="alto-ancho-largo"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidoprecio" class="col-md-0 col-lg-0 control-label">Precio</label><div class="col-md-12 col-lg-12"><div class="row"><div id="pedido_preciov"><input type="text" class="form-control input-sm" name="pedido_precio[]" id="pedido_precio'+indice+'" onkeyup="total('+indice+')"></div></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidodescuento" class="col-md-0 col-lg-0 control-label">Desc%</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_descuento[]" id="pedido_descuento'+indice+'" onkeyup="total('+indice+')" value="0"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidoimpuesto" class="col-md-0 col-lg-0 control-label">Impuesto</label><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="pedido_impuesto[]" id="pedido_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidocantidad" class="col-md-0 col-lg-0 control-label">Cantidad</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_cantidad[]" id="pedido_cantidad'+indice+'" onkeyup="total('+indice+')"></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidototal" class="col-md-0 col-lg-0 control-label">Total</label><div class="col-md-12 col-lg-12"><div class="row" id="pedido_total'+indice+'">0</div></div></div></div><div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
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
			inputField: "fecha",
			ifFormat:   "%d / %m / %Y",
			button:     "selector"
		});
	  
		Calendar.setup({
			inputField: "fechavencimiento",
			ifFormat:   "%d / %m / %Y",
			button:     "selectorv"
		});
	   
	   $("#agregar_campo").generaNuevosCampos(<?php echo count($producto_id)?>+1);
	   
	   $(this).change(function(e) {
			$.ajax ({
				type : "POST",
				url : '<?=base_url()?>pedido/consultarPrecio',
				data : {q : $(e.target).val()},
				cache : false,
				success : function(data) {
					var temp = jQuery.parseJSON(data);
					$("#pedido_tamano"+(e.target.id)).attr("value", temp.tamano);
					$("#pedido_precio"+(e.target.id)).attr("value", temp.precio);
					$("#pedido_impuesto"+(e.target.id)).val(temp.impuesto);
				}
			});
			return false;
		});
	}); 
	
	var subtotal = new Array();
	var descuento = new Array();
	descuento[0]=0;
	
	function total(id) {
		var cantidad = $("#pedido_cantidad"+id).val();
		var precio = $("#pedido_precio"+id).val();
		var desc = $("#pedido_descuento"+id).val();
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>pedido/totalProducto',
			data : {c : cantidad, p : precio, d : desc},
			cache : false,
			success : function(data){
				var json = jQuery.parseJSON(data);
				$("#pedido_total"+id).html(json.total_pedido);
				subtotal[id]=json.total_pedido;
				descuento[id]=json.des;
				fn_subtotal(subtotal);
				fn_descuento(descuento);
				fn_impuesto(id);
				calcularTotal();
			}
		});
		
	}
	
	function fn_subtotal(subtotal) {
		var acumulador = 0;
		for(var i = 1; i < subtotal.length; i++){
			acumulador += subtotal[i];
		}
		$("#subtotal").html(acumulador);
	}	
	
	function fn_descuento(descuento) {
		var acumulador = 0;
		for(var i = 1; i < descuento.length; i++){
			acumulador += descuento[i];
		}
		$("#descuento").html(acumulador);
	}
	
	function eliminar(id) {
		$("#fila_productos"+id).remove();
		var sub = $("#subtotal").html();
		var des = $("#descuento").html();
		var iva1 = $("#iva").html();
		var result_sub = 0;
		var result_des = 0;
		var result_iva = 0;
		var temp = 0;
		result_sub = sub - subtotal[id];
		result_des = des - descuento[id];
		result_iva = iva1 - iva[id];
		temp = subtotal[id] + iva[id];
		subtotal.splice(id, 1, 0);
		descuento.splice(id, 1, 0);
		iva.splice(id,1,0);
		$("#subtotal").html(result_sub);
		$("#descuento").html(result_des);
		$("#iva").html(result_iva);
		resultado = resultado - temp;
		$('#total').html(resultado);
		
		$.ajax ({
			type : "POST",
			url : '<?=base_url()?>pedido/eliminarFila/<?=$id?>',
			data : {fila : id},
			cache : false
		});
	}
	
	var iva = new Array();
	function fn_impuesto(id) {
		var impuesto_id = $('#pedido_impuesto'+id).val();
		var pedido_total = $('#pedido_total'+id).html();
		$.ajax({
			type : "POST",
			url : '<?=base_url()?>impuesto/consultarImpuesto',
			data : {id : impuesto_id},
			cache : false,
			success : function(data) {
				iva[id] = data * pedido_total;
				sumarIVA();
				calcularTotal()
			}
		});
	}
	
	function sumarIVA() {
		var acumulador = 0;
		for(var i = 1; i < iva.length; i++){
			acumulador += iva[i];
		}
		$('#iva').html(acumulador);
	}
	var resultado = 0;
	function calcularTotal() {
		var subtotal = Number($('#subtotal').html());
		var descuento = Number($('#descuento').html());
		var iva = Number($('#iva').html());
		resultado = (subtotal) + iva;
		$('#total').html(resultado);
	}
	$('#pedido_cliente').val(<?= $relacion_id?>);
	var arrProducto_id = <?php echo json_encode($producto_id)?>;
	var arrDetalleproducto_tamano = <?php echo json_encode($detalleproducto_tamano)?>;
	var arrDetalleproducto_precio = <?php echo json_encode($detalleproducto_precio)?>;
	var arrDetalleproducto_descuento = <?php echo json_encode($detalleproducto_descuento)?>;
	var arrImpuesto_id = <?php echo json_encode($impuesto_id)?>;
	var arrDetalleproducto_cantidad = <?php echo json_encode($detalleproducto_cantidad)?>;
	
	for (var indice = 1; indice <= arrProducto_id.length; indice++) {
		texto_insertar = '<div class="row" id="fila_productos'+indice+'"><hr /><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedido" class="col-md-0 col-lg-0 control-label">Producto</label><div class="col-md-0 col-lg-0"><select class="form-control input-sm" name="pedido_producto[]" id="'+indice+'"><?php if ($consulta_producto != FALSE){foreach ($consulta_producto as $row){echo "<option value=".$row->producto_id.">".$row->producto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidotamano" class="col-md-0 col-lg-0 control-label">Tamaño</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_tamano[]" id="pedido_tamano'+indice+'" placeholder="alto-ancho-largo" title="alto-ancho-largo" value="'+arrDetalleproducto_tamano[indice-1]+'"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidoprecio" class="col-md-0 col-lg-0 control-label">Precio</label><div class="col-md-12 col-lg-12"><div class="row"><div id="pedido_preciov"><input type="text" class="form-control input-sm" name="pedido_precio[]" id="pedido_precio'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_precio[indice-1]+'"></div></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidodescuento" class="col-md-0 col-lg-0 control-label">Desc%</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_descuento[]" id="pedido_descuento'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_descuento[indice-1]+'"></div></div></div></div><div class="col-md-2 col-lg-2"><div class="form-group"><label for="pedidoimpuesto" class="col-md-0 col-lg-0 control-label">Impuesto</label><div class="col-md-12 col-lg-12"><div class="row"><select class="form-control input-sm" name="pedido_impuesto[]" id="pedido_impuesto'+indice+'" onchange="fn_impuesto('+indice+')"><?php if($consulta_impuesto != FALSE){foreach($consulta_impuesto->result() as $row){echo "<option value=".$row->impuesto_id.">".$row->impuesto_nombre."</option>";}}else{echo "No hay datos";}?></select></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidocantidad" class="col-md-0 col-lg-0 control-label">Cantidad</label><div class="col-md-12 col-lg-12"><div class="row"><input type="text" class="form-control input-sm" name="pedido_cantidad[]" id="pedido_cantidad'+indice+'" onkeyup="total('+indice+')" value="'+arrDetalleproducto_cantidad[indice-1]+'"></div></div></div></div><div class="col-md-1 col-lg-1"><div class="form-group"><label for="pedidototal" class="col-md-0 col-lg-0 control-label">Total</label><div class="col-md-12 col-lg-12"><div class="row" id="pedido_total'+indice+'">0</div></div></div></div><div class="col-md-0 col-lg-0"><a href="#" id="'+indice+'" onclick="eliminar(this.id)"><span class="eliminar glyphicon glyphicon-minus-sign"></span></a></div></div>';
		$('#fila').append(texto_insertar);
		$('#'+indice).val(arrProducto_id[indice-1]);
		$('#pedido_impuesto'+indice).val(arrImpuesto_id[indice-1]);
		total(indice);
	}
	
	
</script>
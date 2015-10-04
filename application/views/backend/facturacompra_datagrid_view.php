
<br/>
	<nav class="navbar navbar-default navbar-form" role="navigation">
		<div class="row">
			<div class="col-md-4 col-lg-4">
				<p class="navbar-text">Factura de Compra</p>
				<a class="btn btn-default navbar-btn" href="<?=base_url()?>facturacompra"><span class="glyphicon glyphicon-plus-sign"> Crear</span></a>
			</div>
			<div class="col-md-8 col-lg-8">
				<form class="navbar-form navbar-left" role="search">
					de
	        <div class="form-group">
	          <input id="fecha_ini"type="date" class="form-control" placeholder="Search" value="<?php echo date('Y-m-d') ?>">
	        </div>
	        a
	        <div class="form-group">
	          <input id="fecha_fin"type="date" class="form-control" placeholder="Search" value="<?php echo date('Y-m-d') ?>">
	        </div>
	        <a id="buscar_fecha" onclick="buscar_fecha()" class="btn btn-default" title="BUSCAR POR FECHA DE VENCIMIENTO"><span class="glyphicon glyphicon-search"> Buscar</span></a>
	        <a id="cancelar_busqueda" onclick="cancelar_busqueda()" class="btn btn-default" title="CANCELAR LA BUSQUEDA"><span class="glyphicon glyphicon-remove-circle"> Cancelar</span></a>
	        <a href="javascript:history.back()" class="btn btn-default" title="VOLVER"><span class="glyphicon glyphicon-circle-arrow-left"> Atras</span></a>
	      </form>
			</div>
		</div>
	</nav>

	<?php
		if($consulta_facturacompra_datagrid != "")
		{
			$plantilla = array('table_open' => '<table id="table" class="table table-hover table-bordered">');
			echo $this->table->set_template($plantilla);
			$this->table->set_heading('Factura','Beneficiario','Creacion','Vencimiento','Total','Pagado','Por pagar','Acciones');
			$filas = 0;
			foreach ($consulta_facturacompra_datagrid as $key => $row) 
			{
				$myDateTime = DateTime::createFromFormat('Y-m-d', $row->facturacompra_fecha);
				$fecha = $myDateTime->format('d-m-Y');
				$myDateTime = DateTime::createFromFormat('Y-m-d', $row->facturacompra_fechavencimiento);
				$fechavencimiento = $myDateTime->format('d-m-Y');
				$this->table->add_row(
					$row->facturacompra_id,
					$row->relacion_nombre,
					$fecha,
					'<div id="fecha'.$key.'">'.$fechavencimiento.'</div>',
					'$ '.number_format($row->fc_total,2),
					'<div id="estilo_val_pagado'.$key.'">$ '.number_format($row->fc_val_pagado,2).'</div>',
					'<div id="estilo_x_pagar'.$key.'">$ '.number_format($row->fc_x_pagar,2).'</div>',
					"<a href=".base_url()."facturacompra/consultar/".$row->facturacompra_id." title='Consultar'><span class='glyphicon glyphicon-search'></span></a>&nbsp;
					<a id='modificar".$key."' href=".base_url()."facturacompra/modificar/".$row->facturacompra_id." title='Modificar'><span class='glyphicon glyphicon-pencil'></span></a>&nbsp;
					<a id='agregar".$key."' href=".base_url()."comprobanteegreso/index/".$row->facturacompra_id." title='Agregar Pago'><span class='glyphicon glyphicon-usd'></span></a>&nbsp;
					<a id='eliminar".$key."' href=".base_url()."facturacompra/eliminar/".$row->facturacompra_id." title='Eliminar' onclick='if(confirma() == false) return false'><span class='glyphicon glyphicon-remove'></span></a>"
				);
				$filas++;				
			}
			echo '<input id="filas" type="hidden" value="'.$filas.'">';
			echo $this->table->generate();
			echo $this->pagination->create_links();
		}else{
			return FALSE;
		}				
	?>
	
<script type="text/javascript">
	filas = $('#filas').val();
	for (var i = 0; i < filas; i++) {
		if ($("#estilo_x_pagar"+i).html() != '$ 0.00') {
				$("#estilo_val_pagado"+i).css("color","black");
				$("#estilo_x_pagar"+i).css("color","red");
			}/*de lo contrario el valor por pagar se colorea de negro y el pagado de verde*/
		else {
			$("#estilo_val_pagado"+i).css("color","#6CDD22");
			$("#estilo_x_pagar"+i).css("color","black");
			$('#modificar'+i).remove();
			$('#agregar'+i).remove();
			$('#eliminar'+i).remove();
		}
	};
		
	function confirma(){
		if (confirm("¿Desea eliminar el registro de la factura de compra?")){ 
				alert("El registro ha sido eliminado.") 
		}
		else { 
			return false
		}
	}

	function buscar_fecha() {
		$.each($("#table tbody").find("tr"), function(i) {
        if(formato_fecha($('#fecha_ini').val()) <= $('#fecha'+i).html() && $('#fecha'+i).html() <= formato_fecha($('#fecha_fin').val()))
         	$(this).show();
        else
         	$(this).hide();                
    });
	}

	function cancelar_busqueda() {
		$.each($("#table tbody").find("tr"), function(i) {$(this).show();});
		$('#fecha_ini').val(<?php echo json_encode(date('Y-m-d')) ?>);
		$('#fecha_fin').val(<?php echo json_encode(date('Y-m-d')) ?>);
	}

	function formato_fecha(fecha) {
		var formato = new Date(fecha);
		var day = formato.getDate();
		day++;
		var month = formato.getMonth();
		month++;
		var year = formato.getFullYear();
		if (day <= 9)
			day = '0'+day;
		if (month <= 9)
			month = '0'+month;
		var nueva_fecha = day+'-'+month+'-'+year;
		return nueva_fecha;
	}

	if (<?php echo json_encode($this->session->userdata('perfil')) ?> == 2) {
		$.each($("#table tbody").find("tr"), function(i) {
			$('#eliminar'+i).hide();
		});
	}
</script>
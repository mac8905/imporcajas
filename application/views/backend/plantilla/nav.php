<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" role="banner"> <!-- barra de navegación superior -->
	<div class="container">		
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?= $titulo?></a>
		</div>
		  
		<nav class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
			
				<li><a href="<?=base_url()?>principal/bandeja_entrada"><span class="glyphicon glyphicon-home"></span></a></li>
				
				<li><!-- Menú Relaciones -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					Relaciones <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url()?>cliente/datagrid">Clientes</a></li>
						 <li class="divider"></li>
						<li><a href="<?=base_url()?>proveedor/datagrid">Proveedores</a></li>
					</ul>	
				</li><!-- Fin Relaciones -->
				
				<li><!-- Menú Ingresos -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					Ingresos <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url()?>facturaventa/datagrid">Facturas de venta</a></li>
						 <li class="divider"></li>
						<li><a href="<?=base_url()?>recibocaja/datagrid">Pagos Obtenidos</a></li>
						 <li class="divider"></li>
						<li><a href="<?=base_url()?>pedido/datagrid">Pedidos</a></li>
						 <li class="divider"></li>
						<li><a href="<?=base_url()?>cotizacion/datagrid">Cotizaciones</a></li>
					</ul>
				</li><!-- Fin Ingresos -->
				
				<li><!-- Menú gastos -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					Gastos <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url()?>facturacompra/datagrid">Facturas de compra</a></li>
						 <li class="divider"></li>
						<li><a href="<?=base_url()?>comprobanteegreso/datagrid">Pagos</a></li>
					</ul>
				</li><!-- Fin Gastos -->
				
				<li><!-- Menú Inventario -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					Inventario <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url()?>productos/datagrid">Productos de venta</a></li>
						 <li class="divider"></li>
						<li><a href="<?=base_url()?>productos/datagridInventario">Total de inventario</a></li>
					</ul>
				</li><!-- Fin Inventario -->
				
				<li><a href="<?=base_url()?>puc/index">PUC</a></li>
				<!-- <li><a href="#">Reportes</a></li> -->
				
					<li><!-- Menú Configuración -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Configuración <b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<?php if ($this->session->userdata('perfil') != 2): ?>
							<li><a href="<?=base_url()?>usuario/datagrid">Usuarios</a></li>
							 <li class="divider"></li>
							<?php endif ?>
							<li><a href="<?=base_url()?>regimen/datagrid">Régimen</a></li>
							<li class="divider"></li>
							<li><a href="<?=base_url()?>impuesto/datagrid">Impuestos</a></li>
							<li class="divider"></li>
							<li><a href="<?=base_url()?>retencion/datagrid">Retenciones</a></li>
							<li class="divider"></li>
							<li><a href="<?=base_url()?>metodopago/datagrid">Métodos de Pago</a></li>
							<li class="divider"></li>
							<li><a href="<?=base_url()?>empresa/modificar">Empresa</a></li>						
						</ul>
					</li><!-- Fin Configuración -->

				<li><a href="<?=base_url()?>principal/logout">Cerrar Sesión</a></li>
			</ul>
		</nav><!-- /.navbar-collapse -->
	</div>
</div> <!-- fin de la barra de navegación superior -->
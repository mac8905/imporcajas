
	<div class="metro">

		<div class="btn-group">
			<h1>
				Imporcajas
				<div class="button-dropdown">
					<div data-target="#" href="page.html" data-toggle="dropdown" class="button bg-transparent">
						<?= $this->session->userdata('correo') ?>
						<i class="icon-user-2 on-left"></i>
					</div>
					<!--<ul class="dropdown-menu">
						<li><a href="#">Configuración</a></li>
						<li><a href="#">Cerrar sesión</a></li>
					</ul>-->
				</div>
				
			</h1>
		</div><!-- header -->
		
		<div class="streamer">
			<div class="events" style="overflow-x: scroll">
				<div class="events-area" style="width: 1800px"> <!-- width 2350 -->
					   
					   <div class="event-group double"> <!-- capa relaciones -->
							<div class="event-super padding20">
								<h2>Relaciones</h2>
								<div class="tile bg-darkCyan">
									<a href="<?=base_url()?>cliente/datagrid">
										<div class="tile-content icon">
											<i class="icon-user-2"></i>
										</div>
										<div class="tile-status">
											<span class="name">Clientes</span>
										</div>
									</a>
								</div>
								
								<div class="tile bg-darkCyan">
									<a href="<?=base_url()?>proveedor/datagrid">
										<div class="tile-content icon">
											<i class="icon-user-2"></i>
										</div>
										<div class="tile-status">
											<span class="name">Proveedores</span>
										</div>
									</a>
								</div>
								
							</div>
						</div><!-- fin capa relaciones -->
						
						<div class="event-group double"> <!-- capa ingresos -->
							<div class="event-super padding20">
								<h2>Ingresos</h2>
								<div class="tile bg-darkGreen"><!--Inicio de facturas de venta -->
									<a href="<?=base_url()?>facturaventa/datagrid">
									<div class="tile-content icon">
										<i class="icon-arrow-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Facturas de venta</span>
									</div>
									</a>
								</div><!--Fin de facturas de venta-->
								<div class="tile bg-darkGreen">
									<a href="<?=base_url()?>recibocaja/datagrid">
										<div class="tile-content icon">
											<i class="icon-arrow-up"></i>
										</div>
										<div class="tile-status">
											<span class="name">Pagos obtenidos</span>
										</div>
									</a>
								</div>
								
								<div class="tile bg-darkGreen"><!--Inicio de pedidos-->
									<a href="<?=base_url()?>pedido/datagrid">
										<div class="tile-content icon">
											<i class="icon-arrow-up"></i>
										</div>
										<div class="tile-status">
											<span class="name">Pedidos</span>
										</div>
									</a>
								</div><!--Fin de pedidos-->
								
								<div class="tile bg-darkGreen"><!--Inicio de cotización-->
									<a href="<?=base_url()?>cotizacion/datagrid">
									<div class="tile-content icon">
										<i class="icon-arrow-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Cotizaciones</span>
									</div>
									</a>
								</div><!--Fin de cotización-->
							</div>
						</div> <!-- fin capa ingresos -->

						<div class="event-group double"> <!-- capa gastos -->
							<div class="event-super padding20">
								<h2>Gastos</h2>
								<div class="tile bg-darkRed">
									<a href="<?=base_url()?>facturacompra/datagrid">
										<div class="tile-content icon">
											<i class="icon-arrow-down"></i>
										</div>
										<div class="tile-status">
											<span class="name">Facturas de compra</span>
										</div>
									</a>
								</div>
								<div class="tile bg-darkRed">
									<a href="<?=base_url()?>comprobanteegreso/datagrid">
										<div class="tile-content icon">
											<i class="icon-arrow-down"></i>
										</div>
										<div class="tile-status">
											<span class="name">Pagos</span>
										</div>
									</a>
								</div>
							</div>
						</div> <!-- fin capa gastos -->
						
						<div class="event-group double"> <!-- capa inventario -->
							<div class="event-super padding20">
								<h2>Inventario</h2>
								
								<div class="tile bg-darkOrange"><!-- Inicio Producto de Venta-->
									<a href="<?=base_url()?>productos/datagrid">
										<div class="tile-content icon">
											<i class="icon-search"></i>
										</div>
										<div class="tile-status">
											<span class="name">Productos de venta</span>
										</div>
									</a>
								</div><!-- Fin Producto de Venta-->
								
								<div class="tile bg-darkOrange">
									<a href="<?=base_url()?>productos/datagridInventario">
									<div class="tile-content icon">
										<i class="icon-search"></i>
									</div>
									<div class="tile-status">
										<span class="name">Total de inventario</span>
									</div>
									</a>
								</div>
							</div>
						</div> <!-- fin capa inventario -->
						
						<div class="event-group"> <!-- capa puc -->
							<div class="event-super padding20">
								<h2>PUC</h2>
								<a href="<?=base_url()?>puc/index">
								<div class="tile bg-darkBlue">
									<div class="tile-content icon">
										<i class="icon-book"></i>
									</div>
									<div class="tile-status">
										<span class="name">Cuentas</span>
									</div>
								</a>	
								</div>
							</div>
						</div> <!-- fin capa puc -->
						
						<!-- <div class="event-group triple"> capa reportes
							<div class="event-super padding20" style="width: 562px;">
								<h2>Reportes</h2>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Ventas por cliente</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Ventas por producto</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Flujo de efectivo</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Cuentas por cobrar</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Cuentas por pagar</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Estado financiero</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Ingresos y egresos</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Inventario</span>
									</div>
								</div>
								<div class="tile bg-darker">
									<div class="tile-content icon">
										<i class="icon-stats-up"></i>
									</div>
									<div class="tile-status">
										<span class="name">Balance general</span>
									</div>
								</div>
							</div>
						</div> fin capa reportes -->
						
							<div class="event-group double"> <!-- capa configuración -->
								<div class="event-super padding20" style="width: 450px;">
									<h2>Configuración</h2>
						<?php if ($this->session->userdata('perfil') != 2): ?>			
									<div class="tile bg-darkTeal"> <!-- Inicio Usuario-->
										<a href="<?=base_url()?>usuario/datagrid">
										<div class="tile-content icon">
											<i class="icon-cog"></i>
										</div>
										<div class="tile-status">
											<span class="name">Usuario</span> 
										</div>
										</a>
									</div> <!-- Fin Usuario-->
						<?php endif ?>	
									<div class="tile bg-darkTeal"> <!-- Inicio Régimen-->
										<a href="<?=base_url()?>regimen/datagrid">
											<div class="tile-content icon">
												<i class="icon-cog"></i>
											</div>
											<div class="tile-status">
												<span class="name">Régimen</span>
											</div>
										</a>
									</div> <!-- Fin Régimen-->
									
									<div class="tile bg-darkTeal"> <!-- Inicio Impuestos-->
										<a href="<?=base_url()?>impuesto/datagrid">
											<div class="tile-content icon">
												<i class="icon-cog"></i>
											</div>
											<div class="tile-status">
												<span class="name">Impuestos</span>
											</div>
										</a>
									</div> <!-- Fin Impuestos-->
									
									<div class="tile bg-darkTeal"> <!-- Inicio Retención-->
										<a href="<?=base_url()?>retencion/datagrid">
											<div class="tile-content icon">
												<i class="icon-cog"></i>
											</div>
											<div class="tile-status">
												<span class="name">Retención</span>
											</div>
										</a>
									</div> <!-- Fin Retención-->
									
									<div class="tile bg-darkTeal"> <!-- Inicio Método de Pago-->
										<a href="<?=base_url()?>metodopago/datagrid">
											<div class="tile-content icon">
												<i class="icon-cog"></i>
											</div>
											<div class="tile-status">
												<span class="name">Método de Pago</span>
											</div>
										</a>
									</div> <!-- Fin Método de Pago-->	

									<div class="tile bg-darkTeal"> <!-- Inicio Empresa-->
										<a href="<?=base_url()?>empresa/modificar">
											<div class="tile-content icon">
												<i class="icon-cog"></i>
											</div>
											<div class="tile-status">
												<span class="name">Empresa</span>
											</div>
										</a>
									</div> <!-- Fin Empresa-->								
									
								</div>
							</div> <!-- fin capa configuración -->

				</div> <!-- events-area -->
			</div><!-- events -->
		</div> <!-- streamer -->
	</div> <!-- metro -->
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
				<li class="active"><a href="<?=base_url()?>principal">Bienvenido</a></li>
				<li><a href="<?=base_url()?>principal/acercade">Acerca de</a></li>
				<!-- <li><a href="#">Contáctenos</a></li> -->
				<li><a href="<?=base_url()?>principal/login">Iniciar Sesión</a></li>
			</ul>
		</nav><!-- /.navbar-collapse -->
	</div>
</div> <!-- fin de la barra de navegación superior -->
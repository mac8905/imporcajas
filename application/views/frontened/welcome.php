<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bienvenido a Imporcajas</title>
	<style type="text/css">
		img{
			display:block;
			margin:auto;
		}
		
		.justificado{
			text-align : justify;
		}
		
		.letra{
			font-family:arial;
			font-size:18px;
		}
		
		#footer {
			border-top: 7px solid #1c1b1e;
			background: #302e33;
		}		
		
		#footer .last {
			margin-top: 10px;
			padding: 12px 0;
			font-size: 12px;
			background: #1c1b1e;
		}
		
		#footer p {
			color: #bbb;
		}
		
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-4">
				<img src="<?=base_url()?>images/Logo.png" alt="Logo">
			</div>
			<div class="col-md-4 col-lg-4">		
				<img src="<?=base_url()?>images/logo_nombre.jpg" alt="Nombre">
			</div>
		</div>
	</div>
	<br/>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
			<!-- <div class="container"> -->
				<img src="<?=base_url()?>images/imporcajas.jpg" alt="First slide">
				<div class="carousel-caption">
				  <h1>Imporcajas.</h1>
				  <p class="letra">Fabricamos cajas de cartón corrugado</p>
				  <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p> -->
				</div>
			<!-- </div> -->
        </div>
        <div class="item">
          <img src="<?=base_url()?>images/productos.jpg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Nuestros Productos.</h1>
              <p class="letra">Ofrecemos la construcción de cajas de cartón corrugados nuevas o de segunda a los tamaños deseados.</p>
              <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>-->
            </div>
          </div>
        </div>
        <div class="item">
          <img src="<?=base_url()?>images/contáctenos.jpg" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Contáctenos.</h1>
              <p class="letra">Pueden encontrarnos en la dirección Carrera 65A Nº 2C - 54, barrio el Galán.</p>
              <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>-->
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->
	
	<br/>
	<br/>
	<div class="container marketing">
      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-md-4 col-lg-4">
          <img class="img-rounded" src="<?=base_url()?>images/caja1.jpg" alt="Imporcajas" width="250px" height="250px">
          <h3 align="center">Acerca de Nosotros</h3>
			<p class="justificado">
				Nuestra empresa IMPORCAJAS fundada en 1996, durante estos 17 años hemos ofrecido nuestros servicios en la producción de empaques de cartón corrugado.
				Somos una empresa con visión futurista y gran sentido ecológico que busca posesionarse como una de las mejores a nivel nacional, contribuyendo así a un mejor desarrollo industrial del país.
			</p>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-md-4 col-lg-4">
          <img class="img-rounded" src="<?=base_url()?>images/caja4.jpg" alt="Imporcajas" width="250 px" height="250 px">
          <h3 align="center">Ubicación</h3>
          <p>Nos encontramos en el barrio Galán en la direección Carrera 65A Nº 2C - 54.</p>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-md-4 col-lg-4">
          <img class="img-rounded" src="<?=base_url()?>images/caja3.jpg" alt="Imporcajas" width="250px" height="250px">
          <h3 align="center">Nuestros Servicios</h3>
          <p class="justificado">Cajas Tipo Regular.<br>Las cajas regulares o de tipo normal tienen el proceso de fabricación más simple y son generalmente las mas usadas por sus costos y facilidad de apilamiento.<br>
		Estas varían solamente en sus dimensiones y están compuestas por una lamina doblada y sellada para dar una forma rectangular o cuadrada al empaque.</p>
          <p><a class="btn btn-default" href="#" role="button">Ver detalles &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
	 </div><!-- container marketing--> 

</body>
</html>
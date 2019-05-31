<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Allegiant</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
	<link rel="stylesheet" href="css/estilosIndex.css">
	<link rel="stylesheet" href="fonts.css">
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
	<script>
		$(document).ready(function(e){
			$.backstretch([
				"imagenes/fondo1.jpg",
				"imagenes/fondo2.jpg",
				"imagenes/fondo3.jpg",
				],{
				fade:750,
				duration:1800
			});
		});
	</script>


	<link rel="apple-touch-icon" sizes="57x57" href="favicon/favicon-index/apple-icon-57x57.png">

	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-index/apple-icon-60x60.png">

	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-index/apple-icon-72x72.png">

	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-index/apple-icon-76x76.png">

	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-index/apple-icon-114x114.png">

	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-index/apple-icon-120x120.png">

	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-index/apple-icon-144x144.png">

	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-index/apple-icon-152x152.png">

	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-index/apple-icon-180x180.png">

	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-index/android-icon-192x192.png">

	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-index/favicon-32x32.png">

	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-index/favicon-96x96.png">

	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-index/favicon-16x16.png">

	<link rel="manifest" href="favicon/favicon-index/manifest.json">
</head>
<body>
	<header>
			<div class="logo">
				<img src="imagenes/logo.png" alt="">
			</div>
			<div class="logo-xs">
				<img src="imagenes/logo-xs.jpg" alt="">
				<h2 class="titulo-xs">Sistema de Control de Gastos</h2>
			</div>
		
			<nav class="menu">
				<a href="index.php">Inicio</a>

				<a href="login.php">Iniciar sesión</a>

				<a href="registrate.php">Registrarte</a>
			</nav>

			<div class="contenedor">
				<div class="titulo">
					Sistema de control de gastos
				</div>
			</div>
	</header>

	<section class="main">
		<div class="descripcion">
			<div class="contenedor">
			
				<p class="titulo-descripcion">BIENVENIDO A ALLEGIANT ES UN SISTEMA DE CONTROL DE GASTOS</p>
				<p class="divisoria">••••••••••••••<span class="icon-diamonds"></span>••••••••••••••</p>
				<!--<p class="p1">A lo largo del tiempo gastamos más y más dinero de manera desordenada. Uno gasta sin tener en cuenta que su dinero es mucho menor. Esto debido a que no leva una cuenta real de sus gastos. Por eso, nuestra aplicación web resolverá ese problema. Esta app web está disponible para usuarios de iOS, Android y escritorio.</p>-->
				<p  class="p2">Esta APP WEB desarrolla una interfaz intuitiva para el usuario. Esto quiere decir que puede ser usada desde computadora, smartphone o tablet. Te permitira realizar un correcto registro de los gastos e ingresos,además te brindará didácticos cuadros estadísticos. Permite utilizar diferentes tipos de moneda de esa manera esta app web puede ser usada de cualquier parte del mundo. Para poder ingresar solo necesitas crearte una cuenta y tener conexión a internet. Que esperas para usarla.</p>
			</div>
			
		</div>
		<div class="recomendaciones">
			<p class="titulo">Añade a tu uso diario. Ten el control en tus cuentas.</p>
			<div class="disenado1">
				<span class="laptop icon-laptop"></span>
				<p class="disenado-titulo">Diseñado para PC</p>
				<p class="disenado-texto">Allegiant es una APP WEB donde podrás tener una de las mejores experiencias en lo que respecta a control de gastos. Podrás generar reportes de tus gastos e ingresos. Además obtendras gráficos estadísticos de diversos colores. Lo mejor de todo no gastarás espacio de almacenamiento.</p>
			</div>
			<div class="disenado2">
				<span class="mobile2 icon-mobile2"></span>
				<p class="disenado-titulo">Diseñado para Smartphone</p>
				<p class="disenado-texto">Allegiant además esta adaptada para que la uses desde tu smartphone android o IOS. Podrás llevar una cuenta de tus gastos e ingresos. Podrás generar reportes de tus gastos e ingresos. Además obtendras gráficos estadísticos de diversos colores. Lo mejor de todo no gastarás espacio de almacenamiento.</p>
			</div>
		</div>
	</section>
	<footer>
		<div class="autor">
			<p>Creado por grupo de Ingeniería de Requisitos - FISI - UNMSM</p>
		</div>
		
		<div class="redes-sociales">
			<a href="https://www.facebook.com/1551UNMSM/">Facebook</a>
			<a href="http://sistemas.unmsm.edu.pe/">Pagina web</a>
		</div>
	</footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

	<link rel="stylesheet" href="css/normalize.css">
 	<link rel="stylesheet" href="css/estilosReportes.css">	
	<link rel="stylesheet" href="fonts.css">
	<title>Reportes</title>

	<link rel="apple-touch-icon" sizes="57x57" href="favicon/favicon-reportes/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-reportes/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-reportes/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-reportes/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-reportes/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-reportes/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-reportes/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-reportes/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-reportes/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-reportes/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-reportes/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-reportes/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-reportes/favicon-16x16.png">
	<link rel="manifest" href="favicon/favicon-reportes/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="favicon/favicon-reportes/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!-- link calendar resources -->
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/tcal.css" />
	<script type="text/javascript" src="js/tcal.js"></script> 
</head>
<body>
	<header>
			<div class="menu_bar">
				<a href="#" class="bt-menu"><span class="icon-menu"></span>Menu</a>
			</div>
	 
			<nav>
				<ul>
				<li><a href="contenido.php"><span class="icon-coin-dollar"></span>Transacciones</a></li>
				<li><a href="modificarDatos.php"><span class="icon-clipboard"></span>Modificar Datos</a></li>
				<li><a href="estadisticas.php"><span class="icon-table2"></span>Estadísticas</a></li>
				<li><a href="reportes.php"><span class="icon-rocket"></span>Reportes</a></li>
				<li><a href="cerrar.php"><span class="icon-cancel-circle"></span>Cerrar sesión</a></li>
				</ul>
			</nav>
	</header>

	<section class="main">
		<div class="contenedor">
			<h2 class="titulo"><span class="icon-file-text"> </span>Generar Reporte</h2>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="form-ingreso" class="formulario">
				<div class="rango">
					<div class="contenedor-dia">
							<h2 class="titulo-dia">Desde</h2>
								<input type="text" class="tcal" id="fechaDesde" name="fechaDesde" value="<?php echo $fechaDesde?>" placeholder="Desde:" readonly="readonly">
					</div>

					<div class="contenedor-dia">
							<h2 class="titulo-dia">Hasta</h2>
								<input type="text" class="tcal" id="fechaHasta" name="fechaHasta" value="<?php echo $fechaHasta?>" placeholder="Hasta:" readonly="readonly">
					</div>
					
					<div class="contenedor-moneda">
						<h2 class="titulo-moneda">Moneda</h2>
						<select class="input-moneda" name="moneda" id="moneda">
									<?php
										foreach($listaMonedas as $list){
											echo '<option value="'.$list['codMoneda'].'">'.$list['codMoneda'].' - '.$list['nombreMoneda'].'</option>';
										}
									?>
									<script type="text/javascript">
										document.getElementById('moneda').value = '<?php echo $monedaSelec?>';
									</script>
						</select>
					</div>
					<div class="inputs">
						<input type="submit" name="id" class="btn-pdf" value="Generar PDF" onclick="form-ingreso.submit()">
						<input type="submit" name="id" class="btn-excel" value="Generar EXCEL" onclick="form-ingreso.submit()">
					</div>
					
				</div>
			</form>
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


	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/menu.js"></script>
</body>
</html>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, 
	initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	
	<link rel="stylesheet" href="css/normalize.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	
 	<link rel="stylesheet" href="css/estilosEstadistica.css">	
	<link rel="stylesheet" href="fonts.css">
	<title>
		Estadísticas
	</title>

	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/favicon-estadisticas/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-estadisticas/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-estadisticas/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-estadisticas/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-estadisticas/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-estadisticas/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-estadisticas/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-estadisticas/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-estadisticas/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-estadisticas/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-estadisticas/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-estadisticas/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-estadisticas/favicon-16x16.png">
	<link rel="manifest" href="favicon/favicon-estadisticas/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="favicon/favicon-estadisticas/ms-icon-144x144.png">
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

	<section id="contenido_estadistica">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="form-gasto" class="formulario">
				<div class="contenedor-center">
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
					<input type="submit" class="boton-enviar" value="Buscar" name="Buscar-pagos" onclick="form-gasto.submit()">
				</div>
			</form>
			<div id="cont_graf_circ" >
				<canvas id="canvas" width="900px" height="600px"></canvas>
			</div>
		<div>
			<!--
			<table  class="tablaGastos">
				<thead>
					<Tr>
						<Th>Tipo</Th><Th>Categoria</Th><Th>Fecha<Th>Descripcion</Th><Th>Monto</Th><Th>Moneda</Th>
					</Tr>
				</thead>
				<?php 
					

				?>				
			</table>
			-->
		</div>
	</section>
	
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/menu.js"></script>
	<script src="https://code.highcharts.com/highcharts.src.js"></script>
</body>

	<script type="text/javascript">
		//La lista de porcentajes debe sumar 1 para que se muestre correctamente el grafico
		listaMontos=[
		<?php foreach ($gastosArticulos as $gastoA): ?>
			<?php echo (($gastoA['MontoEst']))?> ,
		<?php endforeach ?>];

		listaTipos=[
		<?php foreach ($gastosArticulos as $gastoArt): ?>
			"<?php echo $gastoArt['nombreCatGasto'] ?>" ,
		<?php endforeach ?>
		];

		miTipoMoneda = "<?php echo $monedaSelec?>";
	</script>
	<script src="js/estadisticas.js"></script>

</html>
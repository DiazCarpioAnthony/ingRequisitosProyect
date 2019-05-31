<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Transaccion</title>
	<meta name="viewport" content="width=device-width, user-scalable=no,
	initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	
	<!-- link calendar resources -->
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/tcal.css" />
	<script type="text/javascript" src="js/tcal.js"></script> 

	
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/estilos.css">	
	<link rel="stylesheet" href="fonts.css">
	
	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/favicon-transaccion/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-transaccion/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-transaccion/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-transaccion/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-transaccion/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-transaccion/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-transaccion/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-transaccion/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-transaccion/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-transaccion/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-transaccion/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-transaccion/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-transaccion/favicon-16x16.png">
	<link rel="manifest" href="favicon/favicon-transaccion/manifest.json">
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
		<h1 class="titulo">Transacciones</h1>
	</header>

	<section class="main">
		<section class="gastos-ingresos">
			
			<div class="contenedor-left">
				<div class="gasto">
					<h2 class="titulo-gasto">Gasto</h2>
					<input type="text" class="input-gasto" value="<?php echo $totalPago?>" readonly="readonly" >
				</div>
				<div class="ingreso">
					<h2 class="titulo-ingreso">Ingreso</h2>
					<input type="text" class="input-ingreso" value="<?php echo $totalIngreso?>" readonly="readonly">
				</div>
			</div>
		</section>

		<section class="transaccion-tabla">
			<section class="transaccion">
				<section class="transaccion-pago">
					<div class="contenedor-center">
						<div class="contenedor-center-up">
							<h2 class="titulo-transaccion-pago"><span class="icon-coin-dollar"> </span>Pagos</h2>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="form-gasto" class="formulario">
								<div class="datos">
									<div class="contenedor-categoria">
										<h2 class="titulo-categoria">Categoría</h2>
										<select class="input-categoria" name="categoria" id="categoria">
											<option value="null">--Seleccione--</option>
											<?php
												foreach($categoriasGasto as $list){
													echo '<option value="'.$list['idCatGasto'].'">'.$list['nombreCatGasto'].'</option>';
												}
											?>
										</select>
									</div>
									
									<div class="contenedor-dia">
										<h2 class="titulo-dia">Dia</h2>
										<input type="text" class="tcal" name="date" value="" placeholder="Dia:"  readonly="readonly">
									</div>
									
									<div class="contenedor-nota">
										<h2 class="titulo-nota">Nota</h2>
										<input type="text" class="input-nota" name="nota" id="nota" placeholder="Escriba nota:">
									</div>
									
									<div class="contenedor-costo">
										<h2 class="titulo-costo">Costo</h2>
										<input type="text" class="input-costo"  name="costo" id="costo" placeholder="Costo:">
									</div>
									
									<div class="contenedor-moneda">
										<h2 class="titulo-moneda">Moneda</h2>
										<select class="input-moneda" name="moneda" id="moneda">
											<option value="null">--Seleccione--</option>
											<?php
												foreach($listaMonedas as $list){
													echo '<option value="'.$list['codMoneda'].'">'.$list['codMoneda'].' - '.$list['nombreMoneda'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<input type="submit" class="boton-enviar" value="Agregar pago" name="Enviar" onclick="form-gasto.submit()">
							</form>
						</div>
					</div>
				</section>

				<section class="transaccion-ingreso">
					<div class="contenedor-center">
						<div class="contenedor-center-center">
							<h2 class="titulo-transaccion-ingreso"><span class="icon-coin-dollar"> </span>Ingresos</h2>
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="form-ingreso" class="formulario">
								<div class="datos">
									<div class="contenedor-categoria">
										<h2 class="titulo-categoria">Categoría</h2>
										<select class="input-categoria" name="categoria" id="categoria">
											<!--
											<option value="Renta">Renta</option>
											<option value="Impuestos">Impuestos</option>
											<option value="Otro">Otro</option>
										-->
										<option value="null">--Seleccione--</option>
											<?php
												foreach($categoriasIng as $list){
													echo '<option value="'.$list['idCatIngreso'].'">'.$list['nombreCatIngreso'].'</option>';
												}
											?>
										</select>
									</div>
									
									<div class="contenedor-dia">
										<h2 class="titulo-dia">Dia</h2>
										<input type="text" class="tcal" name="date" value="" placeholder="Dia:"  readonly="readonly">
									</div>
									
									<div class="contenedor-nota">
										<h2 class="titulo-nota">Nota</h2>
										<input type="text" class="input-nota" name="nota" id="nota" placeholder="Escriba nota:">
									</div>
									
									<div class="contenedor-costo">
										<h2 class="titulo-costo">Costo</h2>
										<input type="text" class="input-costo" name="costo" id="costo" placeholder="Costo:">
									</div>
									
									<div class="contenedor-moneda">
										<h2 class="titulo-moneda">Moneda</h2>
										<select class="input-moneda" name="moneda" id="moneda">
											<option value="null">--Seleccione--</option>
											<?php
												foreach($listaMonedas as $list){
													echo '<option value="'.$list['codMoneda'].'">'.$list['codMoneda'].' - '.$list['nombreMoneda'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<input type="submit" class="boton-enviar" value= "Agregar ingreso" name="Enviar" onclick="form-ingreso.submit()">
							</form>
						</div>
					</div>
				</section>
			</section>

			<section class="tabla">
				<div class="contenedor-center">
					<div class="contenedor-center-down">
						<form action="borrar.php" method="POST" name="borrar" class="fomulario-tabla" >	
								<h2 class="titulo-tabla">TABLA DE GASTOS - INGRESOS</h1>
								<div class="tabla-container">
									<table  class="tablaGastos">
										<thead>
											<Tr>
												<Th>Tipo</Th><Th>Categoria</Th><Th>Fecha<Th>Descripcion</Th><Th>Monto</Th><Th>Moneda</Th><Th>Borrar</Th>
											</Tr>
										</thead>
										<?php foreach ($gastosArticulos as $gastoArt): ?>
											<Tr>
												<td>Gasto</td><Td><?php echo $gastoArt['nombreCatGasto'] ?></Td><Td><?php echo $gastoArt['dia'] ?></Td><Td><?php if($gastoArt['nota']==''): ?>
													<?php  echo '-'; ?>
													<?php  else: ?>
													<?php echo $gastoArt['nota']; ?>
													<?php endif; ?>
												</Td><Td><?php echo $gastoArt['monto'] ?></Td><Td><?php echo $gastoArt['nombreMoneda'] ?></Td>
												<Td><input type="submit" class="boton-borrar" name="id" onclick="borrar.submit()" value="BorrarG <?php echo $gastoArt['idGasto'] ?>"></Td>
											</Tr>
										<?php endforeach ?>
										
										<?php foreach ($listaIngresos as $ingr): ?>
											<Tr>
												<td>Ingreso</td><Td><?php echo $ingr['nombreCatIngreso'] ?></Td><Td><?php echo $ingr['dia'] ?></Td><Td><?php if($ingr['nota']==''): ?>
													<?php  echo '-'; ?>
													<?php  else: ?>
													<?php echo $ingr['nota']; ?>
													<?php endif; ?>
												</Td><Td><?php echo $ingr['monto'] ?></Td><Td><?php echo $ingr['nombreMoneda'] ?></Td>
												<Td><input type="submit" class="boton-borrar" name="id" onclick="borrar.submit()" value="BorrarI <?php echo $ingr['idIngreso'] ?>"></Td>
											</Tr>
										<?php endforeach ?>
									</table>
								</div>
						</form>
					</div>
				</div>
			</section>
		</section>

		<section class="mostrar-cuenta">
			<div class="contenedor-right">
				<div class="saldo-inicial">
					<h2 class="titulo-saldo-inicial">Saldo inicial</h2>
					<input type="text" class="input-saldo-inicial"  value="<?php echo $montoInicial?>" readonly="readonly">
				</div>
				<div class="total-gasto">
					<h2 class="titulo-total-gasto">Gasto total</h2>
					<input type="text" class="input-total-gasto" value="<?php echo $totalPago?>" readonly="readonly">
				</div>
				<div class="total-ingreso">
					<h2 class="titulo-total-ingreso">Ingreso total</h2>
					<input type="text" class="input-total-ingreso" value="<?php echo $totalIngreso?>" readonly="readonly">
				</div>
				<div class="monto-queda">
					<h2 class="titulo-monto-queda">Saldo actual</h2>
					<input type="text" class="input-monto-queda" value="<?php echo $montoQueda?>" readonly="readonly">
				</div>
			</div>
		</section>
	</section>
	
	<footer>
		<div class="autor">
			<p>Creado por grupo de oIngeniería de Requisitos - FISI - UNMSM</p>
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
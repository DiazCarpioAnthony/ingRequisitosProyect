<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

	<link rel="stylesheet" href="css/normalize.css">
 	<link rel="stylesheet" href="css/estilosModificarDatos.css">	
	<link rel="stylesheet" href="fonts.css">
	<title>Modificar datos</title>

	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/favicon-modificarDatos/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-modificarDatos/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-modificarDatos/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-modificarDatos/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-modificarDatos/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-modificarDatos/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-modificarDatos/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-modificarDatos/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-modificarDatos/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-modificarDatos/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-modificarDatos/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-modificarDatos/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-modificarDatos/favicon-16x16.png">
	<link rel="manifest" href="favicon/favicon-modificarDatos/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="favicon/favicon-modificarDatos/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
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
		<section class="modContrasena">
			<div class="contenedor-up">
				<h2 class="titulo"><span class="icon-key"> </span>Cambiar contraseña</h2>
				<h3 class="recomendacion">Se recomienda usar una contraseña segura que no uses para ningún otro sitio</h3>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form-contrasena">
					<div class="contrasena-actual">
						<h3 class="titulo-actual">Contraseña actual :</h3>
						<input type="password" name="passActual" class="actual">
					</div>
					<div class="contrasena-nueva1">
						<h3 class="titulo-nueva1">Contraseña nueva :</h3>
						<input type="password" name="passNuevo1" class="nueva1">
					</div>
					<div class="contrasena-nueva2">
						<h3 class="titulo-nueva2">Repita la contraseña :</h3>
						<input type="password" name="passNuevo2" class="nueva2">
					</div>
					<div>
					<input type="submit" class="btn" name="enviar" value="Modificar">
					</div>
					<?php if(!empty($errores)): ?>
						<div class="resultado">
							<ul>
								<?php echo $errores; ?>
							</ul>
						</div>
					<?php endif; ?>
					<?php if(!empty($realizado)): ?>
						<div class="resultado">
							<ul>
								<?php echo $realizado; ?>
							</ul>
						</div>
					<?php endif; ?>
				</form>
				
			</div>
		</section>
		
		<section class="modSaldo">
			<div class="contenedor-down">
				<h2 class="titulo"><span class="icon-quill"> </span>Cambiar saldo</h2>
				<div class="linea"></div>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"  class="form-saldo">
					<div class="saldo-nuevo">
						<h3 class="titulo-nuevo">Nuevo saldo : (Precio em doláres EEUU))</h3>
						<input type="text" name="saldoNuevo" class="actual">
					</div>
					<input type="submit" name="enviar" class="btn" value="Actualizar">
					<?php if(!empty($erroresSaldo)): ?>
						<div class="resultado">
							<ul>
								<?php echo $erroresSaldo; ?>
							</ul>
						</div>
					<?php endif; ?>
					<?php if(!empty($realizadoSaldo)): ?>
						<div class="resultado">
							<ul>
								<?php echo $realizadoSaldo; ?>
							</ul>
						</div>
					<?php endif; ?>
				</form>
			</div>
		</section>

	</section>

	<footer>
		<div class="autor">
			<p>Creado por grupo de organizacion y administación - FISI - UNMSM</p>
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	 initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	 <link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	 <link rel="stylesheet" href="css/estilosLogin.css">
	<title>Iniciar Sesión</title>
	
	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/favicon-user/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-user/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-user/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-user/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-user/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-user/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-user/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-user/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-user/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicon/favicon-user/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-user/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-user/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-user/favicon-16x16.png">
	<link rel="manifest" href="favicon/favicon-user/manifest.json">
</head>
<body>
	<div class="contenedor">
		<h1 class="titulo">Iniciar Sesión</h1>
		<hr class="border">

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login">
			<div class="form-group">
				<i class="icono izquierda fa fa-user"></i><input type="text" name="usuario" class="usuario" placeholder="Usuario">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-lock"></i><input type="password" name="password" class="password_btn" placeholder="Contraseña">
				<i class="submit-btn fa fa-arrow-right" onclick="login.submit()"></i>
			</div>

			<?php if(!empty($errores)): ?>
				<div class="error">
					<ul>
						<?php echo $errores; ?>
					</ul>
				</div>
			<?php endif; ?>
		</form>

		<p class="texto-registrate">
			¿ Aun no tienes cuenta ?
			<a href="registrate.php">Regístrate</a>
		</p>
	</div>
</body>
</html>
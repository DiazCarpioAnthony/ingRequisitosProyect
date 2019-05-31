<?php session_start();

if (!isset($_SESSION['idUsuario'])) {
		header('Location: index.php');
	} 

	$idUsuario = $_SESSION['idUsuario'];
	$conexion = '';
	try{
		
	$conexion = new PDO('mysql:host=localhost;dbname=gastos_bd','root','');	
	} catch (PDOException $e){
		echo "Error" . $e->getMessage();
		die();
	}


	$monedaSelec = 'USD';
	
	$MYMFechaGasto = $conexion->prepare("SELECT MIN(dia) as diaMin,MAX(dia) as diaMax FROM gastos WHERE idUsuario = :idUsuario" );
	$MYMFechaGasto->execute(array(
			':idUsuario' => $idUsuario,
	));
	$MYMFechaGasto=$MYMFechaGasto->fetch();
	/*Para que no esten vacias las variables*/
	$MYMFechaGasto['diaMin'] = $MYMFechaGasto['diaMin'] ? $MYMFechaGasto['diaMin'] : '99/99/9999';
	$MYMFechaGasto['diaMax'] = $MYMFechaGasto['diaMax'] ? $MYMFechaGasto['diaMax'] : '00/00/0000';

	$MYMFechaIngreso = $conexion->prepare("SELECT MIN(dia) as diaMin,MAX(dia) as diaMax FROM ingresos WHERE idUsuario = :idUsuario" );
	$MYMFechaIngreso->execute(array(
			':idUsuario' => $idUsuario,
	));
	$MYMFechaIngreso=$MYMFechaIngreso->fetch();
	/*Para que no esten vacias las variables*/
	$MYMFechaIngreso['diaMin'] = $MYMFechaIngreso['diaMin'] ? $MYMFechaIngreso['diaMin'] : '99/99/9999';
	$MYMFechaIngreso['diaMax'] = $MYMFechaIngreso['diaMax'] ? $MYMFechaIngreso['diaMax'] : '00/00/0000';

	$fechaDesde = min($MYMFechaGasto['diaMin'],$MYMFechaIngreso['diaMin']);
	$fechaHasta = max($MYMFechaGasto['diaMax'],$MYMFechaIngreso['diaMax']);


	$factor = $conexion->prepare("SELECT tipoDeCambio FROM monedas WHERE codMoneda = :codMoneda");
	$factor->execute(array(
			':codMoneda' => $monedaSelec
	));
	$factor=$factor->fetch();
	$factor = $factor['tipoDeCambio'];

	$gastosArticulos =$conexion->prepare("SELECT nombreCatGasto, SUM(monto*tipoDeCambio/:factor) AS MontoEst FROM (gastos NATURAL JOIN monedas) NATURAL JOIN categoriagasto WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta GROUP BY idCatGasto");
	$gastosArticulos->execute(array(
			':factor' => $factor,
			':idUsuario' => $idUsuario,
			':fechaDesde' => $fechaDesde,
			':fechaHasta' => $fechaHasta,
	));
	$gastosArticulos=$gastosArticulos->fetchAll();

	$listaMonedas = $conexion->prepare("SELECT tipoDeCambio,codMoneda,nombreMoneda FROM monedas ORDER BY codMoneda");
	$listaMonedas->execute();
	$listaMonedas = $listaMonedas->fetchAll();

	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$fechaDesde = $_POST['fechaDesde'];
		$fechaHasta = $_POST['fechaHasta'];
		$monedaSelec = $_POST['moneda'];

		$factor = $conexion->prepare("SELECT tipoDeCambio FROM monedas WHERE codMoneda = :codMoneda");
		$factor->execute(array(
				':codMoneda' => $monedaSelec
		));
		$factor=$factor->fetch();
		$factor = $factor['tipoDeCambio'];

		$gastosArticulos =$conexion->prepare("SELECT monto,nombreCatGasto, SUM(monto*tipoDeCambio/:factor) AS MontoEst FROM (gastos NATURAL JOIN monedas) NATURAL JOIN categoriagasto WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta GROUP BY idCatGasto");
		$gastosArticulos->execute(array(
				':factor' => $factor,
				':idUsuario' => $idUsuario,
				':fechaDesde' => $fechaDesde,
				':fechaHasta' => $fechaHasta,
		));
		$gastosArticulos=$gastosArticulos->fetchAll();

		$minFecha = $conexion->prepare("SELECT MIN(dia) as diaMin FROM gastos WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta" );
		$minFecha->execute(array(
				':idUsuario' => $idUsuario,
				':fechaDesde' => $fechaDesde,
				':fechaHasta' => $fechaHasta,
		));
		$minFecha=$minFecha->fetch();
		$minFecha = $minFecha['diaMin'];

		$maxFecha = $conexion->prepare("SELECT MAX(dia) as diaMax FROM gastos WHERE idUsuario = :idUsuario AND dia BETWEEN :fechaDesde AND :fechaHasta" );
		$maxFecha->execute(array(
				':idUsuario' => $idUsuario,
				':fechaDesde' => $fechaDesde,
				':fechaHasta' => $fechaHasta,
		));
		$maxFecha=$maxFecha->fetch();
		$maxFecha=$maxFecha['diaMax'];
	
	}

	require "views/estadisticas.view.php";


?>
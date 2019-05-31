<?php session_start();
/*FUNCIONA*/
if (!isset($_SESSION['idUsuario'])) {
	header('Location: index.php');
}

$idUsuario = $_SESSION['idUsuario'];

try{
	$conexion = new PDO('mysql:host=localhost;dbname=gastos_bd','root','');		
} catch (PDOException $e){
	echo "Error" . $e->getMessage();
	die();
}
/*OBTENER DATOS USUARIO*/
$user = $conexion->prepare("SELECT * FROM usuarios WHERE idUsuario = :idUsuario");
$user->execute(array(
	':idUsuario' => $idUsuario
));
$user = $user->fetch();
$montoInicial = $user['montoInicial'] ? $user['montoInicial'] : 0.0;

/*OBTENER LISTA DE CATEGORIAS GASTO*/
$categoriasGasto = $conexion->prepare("SELECT * FROM categoriagasto ORDER BY nombreCatGasto");
$categoriasGasto->execute();
$categoriasGasto = $categoriasGasto->fetchAll();
//---------------------------------------------------------------------

/*OBTENER LISTA DE CATEGORIAS INGRESOS*/
$categoriasIng =  $conexion->prepare("SELECT * FROM categoriaingreso ORDER BY nombreCatIngreso");
$categoriasIng->execute();
$categoriasIng = $categoriasIng->fetchAll();
//---------------------------------------------------------------------

/*OBTENER LISTA DE MONEDAS*/
$listaMonedas = $conexion->prepare("SELECT * FROM monedas ORDER BY codMoneda");
$listaMonedas->execute();
$listaMonedas = $listaMonedas->fetchAll();
//---------------------------------------------------------------------

$totalPago =$conexion->prepare("SELECT SUM(monto*tipoDeCambio) AS MontoTotal FROM (gastos NATURAL JOIN monedas) WHERE idUsuario = :idUsuario");
$totalPago->execute(array(
			':idUsuario' => $idUsuario
	));
$totalPago=$totalPago->fetch();
$totalPago=round($totalPago['MontoTotal'],2);

$totalIngreso =$conexion->prepare("SELECT SUM(monto*tipoDeCambio) AS MontoTotal FROM (ingresos NATURAL JOIN monedas) WHERE idUsuario = :idUsuario");
	$totalIngreso->execute(array(
			':idUsuario' => $idUsuario
	));
$totalIngreso=$totalIngreso->fetch();
$totalIngreso=round($totalIngreso['MontoTotal'],2);

$montoQueda = $montoInicial + $totalIngreso - $totalPago;

$gastosArticulos =$conexion->prepare("SELECT * FROM (gastos NATURAL JOIN monedas) NATURAL JOIN categoriagasto WHERE idUsuario = :idUsuario");
$gastosArticulos->execute(array(
		':idUsuario' => $idUsuario
	));

$gastosArticulos=$gastosArticulos->fetchAll();


$listaIngresos = $conexion->prepare("SELECT * FROM (ingresos NATURAL JOIN monedas) NATURAL JOIN categoriaIngreso WHERE idUsuario = :idUsuario");
$listaIngresos->execute(array(
		':idUsuario' => $idUsuario
	));

$listaIngresos=$listaIngresos->fetchAll();

	$gastosArticulos =$conexion->prepare("SELECT * FROM (gastos NATURAL JOIN monedas) NATURAL JOIN categoriagasto WHERE idUsuario = :idUsuario");
			$gastosArticulos->execute(array(
					':idUsuario' => $idUsuario
				));
			$gastosArticulos=$gastosArticulos->fetchAll();
			
		$listaIngresos = $conexion->prepare("SELECT * FROM (ingresos NATURAL JOIN monedas) NATURAL JOIN categoriaingreso WHERE idUsuario = :idUsuario");
			$listaIngresos->execute(array(
					':idUsuario' => $idUsuario
				));

			$listaIngresos=$listaIngresos->fetchAll();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$tipo = $_POST['Enviar'];
	$categoria = $_POST['categoria'];
	$dia = $_POST['date'];
	$nota = filter_var($_POST['nota'], FILTER_SANITIZE_STRING);
	$monto = $_POST['costo'];
	$moneda = $_POST['moneda'];

	$errores='';
	if(empty($dia) or empty($monto)){
		$errores .= '<li>Por favor rellene los campos obligatorios</li>';
	}

	if ($errores == '') {
		if($tipo == 'Agregar pago'){
			$statement = $conexion->prepare('INSERT INTO gastos (idGasto, codMoneda, idUsuario, idCatGasto, dia , nota, monto) VALUES (null, :codMoneda, :idUsuario, :idCatGasto, :dia , :nota, :monto)');
			$statement->execute(array(
				':codMoneda' => $moneda,
				':idUsuario' => $idUsuario,
				':idCatGasto' => $categoria,
				':dia' => $dia,
				':nota' => $nota,
				':monto' => $monto
			));
			

		}
		if($tipo == 'Agregar ingreso'){
			$statement = $conexion->prepare('INSERT INTO ingresos (idIngreso, codMoneda, idUsuario, idCatIngreso, dia , nota, monto) VALUES (null, :codMoneda, :idUsuario, :idCatGasto, :dia , :nota, :monto)');
			$statement->execute(array(
				':codMoneda' => $moneda,
				':idUsuario' => $idUsuario,
				':idCatGasto' => $categoria,
				':dia' => $dia,
				':nota' => $nota,
				':monto' => $monto
			));
		
			
		}
		header('Location: contenido.php');
	}
}

	 
require 'views/contenido.view.php';

?>
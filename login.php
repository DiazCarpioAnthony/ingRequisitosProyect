<?php session_start();

if (isset($_SESSION['idUsuario'])) {
	header('Location: index.php');
}

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password = hash('sha512', $password);
	//Subcadena de password para que coincida con la longitud del campo en la BD
	$password = substr($password, 0, 40);
	

	try {
		
	$conexion = new PDO('mysql:host=localhost;dbname=gastos_bd','root','');	
	} catch (PDOException $e) {
		echo "Error:" . $e->getMessage();;
	}

	$statement = $conexion->prepare(
		'SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password'
	);
	//print($password);
	$statement->execute(array(
		':usuario' => $usuario,
		':password' => $password
	));
	//Devolver la siguiente fila como un array indexado por nombre de colunmna;
	$resultado = $statement->fetch(PDO::FETCH_ASSOC);
	//print_r($statement);
	if ($resultado) {
	//	print("encontrado");
		$_SESSION['idUsuario'] = $resultado['idUsuario'];
		header('Location: index.php');
	} else {
	//	print("No encontrado");
		$errores .= '<li>Datos Incorrectos</li>';
	}
}

require 'views/login.view.php';

?>
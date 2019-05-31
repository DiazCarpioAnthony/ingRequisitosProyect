<?php session_start();

if (!isset($_SESSION['idUsuario'])) {
	header('Location: index.php');
}

try{
	$conexion = new PDO('mysql:host=localhost;dbname=gastos_bd','root','root');		
} catch (PDOException $e){
	echo "Error" . $e->getMessage();
	die();
} 


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$id = $_POST['id'];
	$id = substr($id,8,strlen($id));

	$tipo = substr($_POST['id'],0,7);
	if($tipo  == 'BorrarG'){
		$gastosE =$conexion->prepare("DELETE FROM gastos WHERE idGasto = :idGasto");
		$gastosE->execute(array(
			':idGasto' => $id
		));
	}

	if($tipo  == 'BorrarI'){
		$gastosE =$conexion->prepare("DELETE FROM ingresos WHERE idIngreso = :idIngreso");
		$gastosE->execute(array(
			':idIngreso' => $id
		));
	}
}

	
header('Location: contenido.php');


 ?>
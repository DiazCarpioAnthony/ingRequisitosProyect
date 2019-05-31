<?php session_start();


if (!isset($_SESSION['idUsuario'])) {
	header('Location: index.php');
} 

$idUsuario = $_SESSION['idUsuario'];
$errores = '';
$realizado = '';
$erroresSaldo ='';
$realizadoSaldo = '';
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
//$montoInicial = $user['montoInicial'] ? $user['montoInicial'] = 0.0;
//$nombreUsuario = $user['usuario'];
$pass = $user['password'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$tipo = $_POST['enviar'];

	if($tipo == 'Modificar'){
		$passActual = $_POST['passActual'];
		//echo($passActual.'<<>>');
		$passActual = hash('sha512', $passActual);
		//Subcadena de password para que coincida con la longitud del campo en la BD
		$passActual = substr($passActual, 0, 40);
		$passNuevo1 =  $_POST['passNuevo1'];
		$passNuevo2 =  $_POST['passNuevo2'];

		if ($pass != $passActual) {
			$errores .= '<li class="text-error">La contraseña no es correcta</li>';
		}else if(!$passNuevo1 || !$passNuevo2){
			$errores .= '<li class="text-error">Debe llenar todos los campos</li>';
		}else if($passNuevo1 != $passNuevo2){
			$errores .= '<li class="text-error">Los campos contraseña no coinciden</li>';
		}
		//echo($errores);
		//echo($pass."<<>>");
		//echo($passActual);
		if($errores == ''){
			$passNuevo1 = hash('sha512', $passNuevo1);
			//Subcadena de password para que coincida con la longitud del campo en la BD
			$passNuevo1 = substr($passNuevo1, 0, 40);
			$statement = $conexion->prepare('UPDATE usuarios SET password = :passNuevo WHERE idUsuario = :idUsuario');
			$statement->execute(array(
				':idUsuario' => $idUsuario,
				':passNuevo' => $passNuevo1
			));
			$realizado.='<li class="text-aceptado">Contraseña actualizada correctamente</li>';
		}
	
	}
	if($tipo == 'Actualizar'){
		$saldoNuevo =  $_POST['saldoNuevo'];
		if ($saldoNuevo=='') {
			$erroresSaldo .= '<li class="text-error">Por favor digite el campo.</li>';
		}
		if($erroresSaldo == ''){
			$statement = $conexion->prepare('UPDATE usuarios SET montoInicial = :saldoNuevo WHERE idUsuario = :idUsuario');
			$statement->execute(array(
				':saldoNuevo' => $saldoNuevo,
				':idUsuario' => $idUsuario
			));

			$realizadoSaldo .='<li class="text-aceptado">Saldo actualizado correctamente</li>';
		}
	}
	
	//header('Location: modificarDatos.php');
}

require 'views/modificarDatos.view.php';

?>
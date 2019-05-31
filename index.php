<?php session_start();

if (isset($_SESSION['idUsuario'])) {
	header('Location: contenido.php');
} 
require "views/index.view.php";
 ?>
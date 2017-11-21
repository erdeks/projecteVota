<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password'])){
		session_start();
		require "conexionBBDD.php";
		$conexion = abrirConexion();
		$email = $_POST['email'];
		$password = sha1(md5($_POST['password']));

		$query = $conexion->prepare("SELECT idUsuario, validado FROM usuarios WHERE email = '$email' AND password = '$password';");
		$query->execute();
		if($row = $query->fetch()){
			$_SESSION['usuario'] = [
				"id" => $row['idUsuario'], 
				"email" => $email, 
				"contraseña" => $password,
				"validado" => $row['validado'] == 1 ? true : false];

		}else{
			if(isset($_SESSION['usuario']))
				unset($_SESSION['usuario']);
		}
		
		cerrarConexion($conexion);
		header("Location: ../index.php");
	}

	function existeYnoEstaVacio($variable){
		return (isset($variable) && $variable != "");
	}
//Java script slash menu
?>
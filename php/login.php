<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password'])){
		session_start();
		require "conexionBBDD.php";
		$conexion = abrirConexion();
		$email = $_POST['email'];
		$password = sha1(md5($_POST['password']));

		$query = $conexion->prepare("SELECT idUsuario, validado FROM usuarios WHERE email = '$email' AND password = '$password';");
		$query->execute();
		cerrarConexion($conexion);
		if($row = $query->fetch()){
			if($row['validado'] == 1){
				$_SESSION['usuario'] = [
					"id" => $row['idUsuario'], 
					"email" => $email, 
					"contraseña" => $password];
				header("Location: ../index.php");
			}else{
				destruirUsuario();
				header("Location: ../pagina/validacion.php");
			}
		}else{
			destruirUsuario();
			header("Location: ../pagina/login.php?error=1");
		}
	}else{
		destruirUsuario();
		header("Location: ../pagina/login.php?error=2");
	}

	function existeYnoEstaVacio($variable){
		return (isset($variable) && $variable != "");
	}

	function destruirUsuario(){
		if(isset($_SESSION['usuario']))
			unset($_SESSION['usuario']);
	}
//Java script slash menu
?>
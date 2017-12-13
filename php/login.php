<?php
	require "inicializar.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password'])){
		$conexion = abrirConexion();
		$email = $_POST['email'];
		if(correoValido($email)){
			$password = hash('sha256', $_POST['password']);

			$query = $conexion->prepare("SELECT idUsuario, validado, idPermiso FROM usuarios WHERE email = :email AND password = :password;");
			$query->bindParam(":email", $email);
			$query->bindParam(":password", hash('sha256', $password));
			$query->execute();
			cerrarConexion($conexion);
			if($row = $query->fetch()){
				if($row['validado'] == 1){
					$_SESSION['usuario'] = [
						"id" => $row['idUsuario'],
						"email" => $email,
						"idPermiso" => $row['idPermiso'],
						"password" => $password];
					irAIndex();
				}else{
					destruirUsuario();
					enviarValidacion($row['idUsuario']);
				}
			}else{
				destruirUsuario();
				$_SESSION['mensaje'][] = [0, "El usuario o contraseña estan mal."];
				irALogin();
			}
		}else{
			$_SESSION['mensaje'][] = [0, "Formato de email es incorrecto."];
			irALogin();
		}
	}else{
		destruirUsuario();
		$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
		irALogin();
	}

	function destruirUsuario(){
		if(isset($_SESSION['usuario']))
			unset($_SESSION['usuario']);
	}

	function irAIndex(){
		header("Location: ../index.php");
	}
	function irALogin(){
		header("Location: ../pagina/login.php");
	}
	function enviarValidacion($id){
		header("Location: ../php/enviarValidacion.php?id=".$id);
	}
?>
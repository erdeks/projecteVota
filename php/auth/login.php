<?php
	require "../inicializar.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password'])){
		$conexion = abrirConexion();
		$email = trim($_POST['email']);
		if(correoValido($email)){
			$password = hash('sha256', trim($_POST['password']));
			$passwordEncrypt = hash('sha256', $password);
			$query = $conexion->prepare("SELECT idUsuario, validado, idPermiso FROM usuarios WHERE email = :email AND password = :password;");
			$query->bindParam(":email", $email);
			$query->bindParam(":password", $passwordEncrypt);
			$query->execute();
			if($row = $query->fetch()){
				if($row['validado'] == 1){
					if(estaActivadoCambiarContra($conexion, $email))
						desactivarCambiarContra($conexion, $email);

					$_SESSION['usuario'] = [
						"id" => $row['idUsuario'],
						"email" => $email,
						"idPermiso" => $row['idPermiso'],
						"password" => $password];
						
					if(existeYnoEstaVacio($_POST['idEncuesta'])) irAVotarEncuesta($_POST['idEncuesta']);
					else irAIndex();
				}else{
					destruirUsuario();
					enviarValidacion($row['idUsuario']);
				}
			}else{
				destruirUsuario();
				$_SESSION['mensaje'][] = [0, "El usuario o contraseña estan mal."];
				irALogin();
			}
			cerrarConexion($conexion);
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
		header("Location: ../../index.php");
	}
	function irALogin(){
		if(existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['idEncuesta'])) header("Location: ../../pagina/login.php?email=".$_POST['email']."&idEncuesta=?".$_POST['idEncuesta']);
		else if(existeYnoEstaVacio($_POST['idEncuesta'])) header("Location: ../../pagina/login.php?idEncuesta=".$_POST['idEncuesta']);
		else if(existeYnoEstaVacio($_POST['email'])) header("Location: ../../pagina/login.php?email=".$_POST['email']);
		else header("Location: ../../pagina/login.php");
	}
	function enviarValidacion($id){
		header("Location: enviarValidacion.php?id=".$id);
	}
	function irAVotarEncuesta($idEncuesta){
	  header("Location: ../../pagina/votarEncuesta.php?idEncuesta=$idEncuesta");
	}
?>

<?php
	require "../../inicializar.php";
	//Cancelar cambiar Password
	if(existeYnoEstaVacio($_GET['email']) && existeYnoEstaVacio($_GET['cancelar'])){
		$email = $_GET['email'];
		if($_GET['cancelar'] == true){
			$conexion = abrirConexion();
			if(desactivarCambiarContra($conexion, $email)){
				$_SESSION['mensaje'][] = [1, "Se ha desactivado la recuperación de la contraseña."];
				irAIndex();
			}else{
				$_SESSION['mensaje'][] = [0, "Se no se ha podido desactivar la recuperación de la contraseña."];
			irAIndex();
			}
			cerrarConexion($conexion);
		}else{
			$_SESSION['mensaje'][] = [0, "Parametro no valido."];
			irAIndex();
		}

	//Cambiar el password
	}else if(existeYnoEstaVacio($_POST['newPassword']) && existeYnoEstaVacio($_POST['newPasswordConfirm'])){
		$newPassword = $_POST['newPassword'];
		$newPasswordConfirm = $_POST['newPasswordConfirm'];
		$passwordEncriptado = hash('sha256', hash('sha256', $newPassword));

		//Si el usuario esta logeado y se quiere cambiar su password
		if(existeYnoEstaVacio($_SESSION['usuario']) && existeYnoEstaVacio($_POST['oldPassword'])){
			if($newPassword === $newPasswordConfirm){
				$email = $_SESSION['usuario']['email'];
				$oldPasswordEncriptado = hash('sha256', hash('sha256', $_POST['oldPassword']));
				$conexion = abrirConexion();
				if(passworldIguales($conexion, $email, $oldPasswordEncriptado)){
					if(cambiarPassword($conexion, $email, $passwordEncriptado)){
						reencriptarTablas($conexion, $email, $_POST['oldPassword'], $newPassword);
						$_SESSION['mensaje'][] = [1, "La contraseña se ha cambiada correctamente."];
						$_SESSION['usuario']['password'] = hash('sha256', $newPassword);
						irACambiarPassword();
					}else{
						$_SESSION['mensaje'][] = [0, "Ha ocurrido un error al cambiar la contraseña."];
						irACambiarPassword();
					}
				}else{
					$_SESSION['mensaje'][] = [0, "Las contraseñas no coinciden."];
					irACambiarPassword();
				}
				cerrarConexion($conexion);
			}else{
				$_SESSION['mensaje'][] = [0, "Las contraseñas no son iguales."];
				irACambiarPassword();
			}

		//Si el usuario no se acuerda de su password y lo quiere cambiar
		}else if(!existeYnoEstaVacio($_SESSION['usuario']) && existeYnoEstaVacio($_POST['email'])){
			$email = $_POST['email'];
			if($newPassword === $newPasswordConfirm){
				$conexion = abrirConexion();
				if(estaActivadoCambiarContra($conexion, $email)){
					if(cambiarPassword($conexion, $email, $passwordEncriptado)){
						if(desactivarCambiarContra($conexion, $email)){
							$_SESSION['mensaje'][] = [1, "La contraseña se ha cambiada correctamente."];
							irALogin();
						}else{
							$_SESSION['mensaje'][] = [0, "No se ha podido desactivar la contraseña actual."];
							irANuevaPassword($email);
						}
					}else{
						$_SESSION['mensaje'][] = [0, "Ha ocurrido un error al cambiar la contraseña."];
						irANuevaPassword($email);
					}
				}else{
					$_SESSION['mensaje'][] = [0, "La cuenta no ha solicitado restablecer su contraseña."];
					irANuevaPassword($email);
				}
				cerrarConexion($conexion);
			}else{
				$_SESSION['mensaje'][] = [0, "Las contraseñas no son iguales."];
				irANuevaPassword($email);
			}
		}else{
			$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
			irAIndex();
		}
	}else{
		$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
		irAIndex();
	}

	function irAIndex(){
		header("Location: ../../../index.php");
	}
	function irALogin(){
		header("Location: ../../../pagina/login.php");
	}
	function irACambiarPassword(){
		header("Location: ../../../pagina/cambiarPassword.php");
	}
	function irANuevaPassword($email){
		header("Location: ../../../pagina/nuevaPassword.php?email=$email");
	}
	function passworldIguales(&$conexion, $email, $password){
		$query = $conexion->prepare("SELECT password FROM usuarios WHERE email = '$email' AND password = '$password';");
		$query->execute();
		$rows=$query->rowCount();
		return $rows == 1;
	}
	function cambiarPassword(&$conexion, $email, $password){
			//Reencriptar bbdd
			$query = $conexion->prepare("UPDATE usuarios SET password = '$password' WHERE email = '$email'");
			return $query->execute();
	}
	function reencriptarTablas(&$conexion, $email, $passwordAntiguo, $passwordNuevo){
		$idUsuario = getIdUsuario($conexion, $email);
		$passwordAntiguoEncriptado = hash('sha256', $passwordAntiguo);
		$passwordNuevoEncriptado = hash('sha256', $passwordNuevo);

		$query = $conexion->prepare("UPDATE votosEncuestasEncriptado vee, votosEncuestas ve SET vee.hashEncriptado = AES_ENCRYPT(ve.hash, '$passwordNuevoEncriptado') WHERE AES_DECRYPT(vee.hashEncriptado, '$passwordAntiguoEncriptado') = ve.hash AND vee.idUsuario = $idUsuario");
		$query->execute();
	}
?>

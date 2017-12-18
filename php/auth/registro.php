<?php
	require "../inicializar.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password']) && existeYnoEstaVacio($_POST['passwordConfirm'])){
		
		$email = trim($_POST['email']);
		if(correoValido($email)){
			$password = hash('sha256', hash('sha256', trim($_POST['password'])));
			$passwordConfirm = hash('sha256', hash('sha256', trim($_POST['passwordConfirm'])));

			if($password === $passwordConfirm){
				$estado = "";
				$conexion = abrirConexion();
				
				$existeUsuario = existeUsuario($conexion, $email);
				if($existeUsuario === false){ //Si no hay ningun usuario
					registrarUsuario($conexion, $email, $password);
				}else if($existeUsuario === true){ //Si hay un usuario registrado
					$query = $conexion->prepare("SELECT idUsuario, idPermiso, validado FROM usuarios WHERE email = '$email';");
					$query->execute();
					if($row = $query->fetch()){
						if($row['idPermiso'] == 1){ //Si era un invitado y se registra
							actualizarUsuarioInvitado($conexion, $row["idUsuario"], $password);
						}else{ //Si no es un invitado
							if($row['validado'] == 0){ //Si la cuenta no esta validada
								enviarValidacion($row["idUsuario"]);
							}else{ //Si la cuenta esta validada
								$_SESSION['mensaje'][] = [0, "El usuario ya existe."];
								irARegistro($email);
							}
						}
					}else{
						$_SESSION['mensaje'][] = [0, "Error desconocido, contacte con el administrador."];
					}
				}else{
					$_SESSION['mensaje'][] = [0, "Hay multiples usuarios con el mismo correo, contacte con el administrador."];
				}

				cerrarConexion($conexion);
			}else{
				$_SESSION['mensaje'][] = [0, "Las contraseñas no coinciden."];
				irARegistro($email);
			}
		}else{
			$_SESSION['mensaje'][] = [0, "Formato de email es incorrecto."];
			irARegistro($email);
		}
	}else{
		$_SESSION['mensaje'][] = [0, "Los parametros no pueden estar vacio."];
		irARegistro();
	}

	function registrarUsuario(&$conexion, $email, $password){
		$query = $conexion->prepare("INSERT INTO usuarios (idPermiso, email, password) VALUES (2, '$email', '$password')");
		$query->execute();
		$last_id = $conexion->lastInsertId();
		enviarValidacion($last_id);
	}

	function actualizarUsuarioInvitado(&$conexion, $idUsuario, $password){
		$query = $conexion->prepare("UPDATE usuarios SET password = '$password', idPermiso = 2, validado = 0 WHERE idUsuario = $idUsuario");
		$query->execute();
		enviarValidacion($idUsuario);
	}

	function enviarValidacion($id){
		if(existeYnoEstaVacio($_POST['idEncuesta'])) header("Location: enviarValidacion.php?id=$id&idEncuesta=".$_POST['idEncuesta']);
		else header("Location: enviarValidacion.php?id=$id");
	}

	function irARegistro($email = ""){
		if(existeYnoEstaVacio($email) && existeYnoEstaVacio($_POST['idEncuesta'])) header("Location: ../../pagina/registro.php?email=$email&idEncuesta=?".$_POST['idEncuesta']);
		else if(existeYnoEstaVacio($_POST['idEncuesta'])) header("Location: ../../pagina/registro.php?idEncuesta=".$_POST['idEncuesta']);
		else if(existeYnoEstaVacio($email)) header("Location: ../../pagina/registro.php?email=$email");
		else header("Location: ../../pagina/registro.php");
	}
?>
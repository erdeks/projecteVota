<?php
	session_start();

	define("USAURIO_NO_REGISTRADO", 1);
	define("USAURIO_REGISTRADO_VALIDADO", 2);
	define("USAURIO_REGISTRADO_NO_VALIDADO", 3);
	define("USAURIO_REGISTRADO_INVITADO", 4);

	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password']) && existeYnoEstaVacio($_POST['passwordConfirm'])){
		
		$email = $_POST['email'];
		if(is_valid_email($email)){
			$password = sha1(md5($_POST['password']));
			$passwordConfirm = sha1(md5($_POST['passwordConfirm']));

			if($password === $passwordConfirm){
				$estado = "";
				require "conexionBBDD.php";
				$conexion = abrirConexion();

				$query = $conexion->prepare("SELECT idUsuario, idPermiso, validado FROM usuarios WHERE email = '$email';");
				$query->execute();
				$rows=$query->rowCount();
				
				
				if($rows == 0){ //Si no hay ningun usuario
					$estado = USAURIO_NO_REGISTRADO;
				}else if($rows == 1){ //Si hay un usuario registrado
					if($row = $query->fetch()){
						if($row['idPermiso'] == 1){ //Si era un invitado y se registra
							$estado = USAURIO_REGISTRADO_INVITADO;
						}else{ //Si no es un invitado
							if($row['validado'] == 0){ //Si la cuenta no esta validada
								$estado = USAURIO_REGISTRADO_NO_VALIDADO;
							}else{ //Si la cuenta esta validada
								$estado = USAURIO_REGISTRADO_VALIDADO;
							}
						}
					}
				}

				switch ($estado) {
					case USAURIO_NO_REGISTRADO:
						registrarUsuario($conexion, $email, $password);
						break;
					case USAURIO_REGISTRADO_VALIDADO:
						header("Location: ../pagina/registro.php?error=1");
						break;
					case USAURIO_REGISTRADO_NO_VALIDADO:
						validarCuenta($row["idUsuario"]);
						break;
					case USAURIO_REGISTRADO_INVITADO:
						actualziarUsuarioInvitado($conexion, $row["idUsuario"], $password);
						break;
				}
				cerrarConexion($conexion);
			}else{
				//password no igual
				header("Location: ../pagina/registro.php?error=2");
			}
		}else{
			header("Location: ../pagina/registro.php?error=3");
		}
	}else{
		header("Location: ../pagina/registro.php?error=4");
	}

	function existeYnoEstaVacio($variable){
		return (isset($variable) && $variable != "");
	}

	function registrarUsuario(&$conexion, $email, $password){
		$query = $conexion->prepare("INSERT INTO usuarios (idPermiso, email, password) VALUES (2, '$email', '$password')");
		$query->execute();
		$last_id = $conexion->lastInsertId();
		validarCuenta($last_id, true);
	}

	function actualziarUsuarioInvitado(&$conexion, $idUsuario, $password){
		//Cambiar el idPermisos a 2 (usuario) y valiando a 1 (true)
		$query = $conexion->prepare("UPDATE usuarios SET password = '$password', idPermiso = 2, validado = 0 WHERE idUsuario = $idUsuario");
		$query->execute();
		validarCuenta($idUsuario, true);
	}

	function validarCuenta($id, $nuevoRegistro = false){
		if($nuevoRegistro)
			header("Location: ../php/enviarValidacion.php?id=$id&registro=true");
		else
			header("Location: ../php/enviarValidacion.php?id=$id");
	}

	function is_valid_email($str){
		return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
	}

?>
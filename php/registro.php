<?php
	require "inicializar.php";

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
					}else{
						$_SESSION['mensaje'][] = [0, "Error desconocido, contacte con el administrador."];
					}
				}

				switch ($estado) {
					case USAURIO_NO_REGISTRADO:
						registrarUsuario($conexion, $email, $password);
						break;
					case USAURIO_REGISTRADO_VALIDADO:
						$_SESSION['mensaje'][] = [0, "El usuario ya existe."];
						irARegistro();
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
				$_SESSION['mensaje'][] = [0, "Las contraseñas no coinciden."];
				irARegistro();
			}
		}else{
			$_SESSION['mensaje'][] = [0, "Formato de email es incorrecto."];
			irARegistro();
		}
	}else{
		$_SESSION['mensaje'][] = [0, "Los parametros no pueden estar vacio."];
		irARegistro();
	}

	function registrarUsuario(&$conexion, $email, $password){
		$query = $conexion->prepare("INSERT INTO usuarios (idPermiso, email, password) VALUES (2, '$email', '$password')");
		$query->execute();
		$last_id = $conexion->lastInsertId();
		validarCuenta($last_id);
	}

	function actualziarUsuarioInvitado(&$conexion, $idUsuario, $password){
		//Cambiar el idPermisos a 2 (usuario) y validado a 0 (false)
		$query = $conexion->prepare("UPDATE usuarios SET password = '$password', idPermiso = 2, validado = 0 WHERE idUsuario = $idUsuario");
		$query->execute();
		validarCuenta($idUsuario);
	}

	function validarCuenta($id){
			header("Location: ../php/enviarValidacion.php?id=$id");
	}

	function is_valid_email($str){
		return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
	}
	function irARegistro(){
		header("Location: ../pagina/registro.php");
	}
?>
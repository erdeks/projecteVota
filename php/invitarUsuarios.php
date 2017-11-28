<?php
	//URGENTE!!! MODIFICAR EL $link A UNO CORRECTO
	//URGENTE!!! MODIFICAR EL LINK DE LA FUNCION irAInvitarUsaurios() A UNO CORRECTO
	//NOTA: en caso de que los usuarios invitados se tengan que registrar eliminar el activo de la tabla accesoEncuestas y añadir una variable boleana para saber si esta registrado o no par amandarlo al apartado de registro o login y agregar un redirect para que cuando se logee lo redirija a la pagina en cuestion

	require "inicializar.php";
	if(existeYnoEstaVacio($_GET['idEncuesta']) && existeYnoEstaVacio($_SESSION['usuario']) && existeYnoEstaVacio($_GET['invitados'])){
		$idEncuesta = $_GET['idEncuesta'];
		$idUsuario = $_SESSION['usuario']['id'];
		$emailUsuario = $_SESSION['usuario']['email'];
		$emailsInvitados = multiexplode(array(",","|",";"), $_GET['invitados']);

		$conexion = abrirConexion();
		if(usuarioACreadoLaEncuesta($conexion, $idEncuesta, $idUsuario)){
			foreach($emailsInvitados as $emailInvitado){
				if(correoValido($emailInvitado)){
					if($emailUsuario == $emailInvitado){
						$_SESSION['mensaje'][] = [0, "No puedes enviarte una invitacion a ti mismo."];
					}else{
						$idUsuarioInvitado = null;
						$existeUsuario = existeUsuario($conexion, $emailInvitado);
						if($existeUsuario === false){
							$idUsuarioInvitado = registrarInvitado($conexion, $emailInvitado);
						}else if($existeUsuario === true){
							$idUsuarioInvitado = getIdUsuario($conexion, $emailInvitado);
						}else{
							$_SESSION['mensaje'][] = [0, "Hay multiples usuarios con el mismo correo, contacte con el administrador."];
						}

						if(!is_null($idUsuarioInvitado)){
							if(yaHaSidoInvitado($conexion, $idEncuesta, $idUsuarioInvitado)){
								$_SESSION['mensaje'][] = [0, "El usuario $emailInvitado ya esta invitado y no se ha vuelto a invitar."];
							}else{
								$idAccesoEncuesta = registrarInvitacion($conexion, $idEncuesta, $idUsuarioInvitado);
								if(!is_null($idAccesoEncuesta)){
									$link = getURLPage()."php/registroInvitarUsuario.php?email=$emailInvitado";
									if(enviarEmailInvitacion($emailInvitado, $emailUsuario, $link)){
										$_SESSION['mensaje'][] = [1, "El usuario $emailInvitado a sido invitado."];
									}else{
										$_SESSION['mensaje'][] = [0, "No se ha podido enviar el email de invitacion al usuario $emailInvitado."];
									}
								}else{
									$_SESSION['mensaje'][] = [0, "No se ha posido obtener la id de la encuesta para el usuario $emailInvitado."];
								}
							}
						}else{
							$_SESSION['mensaje'][] = [0, "No se ha posido obtener la id del usuario $emailInvitado."];
						}
					}
				}else{
					$_SESSION['mensaje'][] = [0, "Formato del email $emailInvitado no es valido."];
				}
			}
			irAInvitarUsaurios();
		}else{
			$_SESSION['mensaje'][] = [0, "No puedes invitar a personas a una encuesta que no has creado."];
			irAIndex();
		}
		
		cerrarConexion($conexion);
	}else{
		$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
		irAIndex();
	}

	function usuarioACreadoLaEncuesta(&$conexion, $idEncuesta, $idUsuario){
		$query = $conexion->prepare("SELECT idEncuesta FROM encuestas WHERE idEncuesta = $idEncuesta AND idUsuario = $idUsuario;");
		$query->execute();
		$rows=$query->rowCount();
		if($rows == 0) return false;
		else return true;
	}

	function yaHaSidoInvitado(&$conexion, $idEncuesta, $idUsuarioInvitado){
		$query = $conexion->prepare("SELECT idAcceso FROM accesoEncuestas WHERE idEncuesta = $idEncuesta AND idUsuario = $idUsuarioInvitado;");
		$query->execute();
		$rows=$query->rowCount();
		if($rows == 0) return false;
		else return true;
	}

	function registrarInvitado(&$conexion, $email){
		$query = $conexion->prepare("INSERT INTO usuarios (idPermiso, email) VALUES (1, '$email');");
		if($query->execute()) return $conexion->lastInsertId();
		else return null;
	}

	function registrarInvitacion(&$conexion, $idEncuesta, $idUsuarioInvitado){
		$query = $conexion->prepare("INSERT INTO accesoEncuestas (idUsuario, idEncuesta, activo) VALUES ($idUsuarioInvitado, $idEncuesta, 1);");
		if($query->execute()) return $conexion->lastInsertId();
		else return null;
	}

	function enviarEmailInvitacion($para, $emailUsuario, $link){
		// título
		$titulo = 'Projecte Vota - Invitacion a encuesta';

		// mensaje
		$mensaje = '
		<html>
		<head>
		<title>Projecte Vota - Invitacion a encuesta</title>
		</head>
		<body>
		<p>El usuario '.$emailUsuario.' le ha invitado para que votes en la encuesta que ha creado, haga click <a href="'.$link.'">aquí</a> para votar.</p>
		</body>
		</html>
		';
		return enviarEmail($para, $titulo, $mensaje);
	}

	function irAIndex(){
		header("Location: ../index.php");
	}
	function irAInvitarUsaurios(){
		header("Location: ../pagina/login.php");
	}
?>
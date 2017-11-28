<?php //Instalar postfix para poder enviar correos
	require "inicializar.php";

	if(existeYnoEstaVacio($_GET['id'])){
		$idUsuario = $_GET['id'];
		$conexion = abrirConexion();
		if(isIdCorrecta($conexion, $idUsuario)){
			if(setValidando($conexion, $idUsuario)){
				$email = getEmail($conexion, $idUsuario);
				$link = getURLPage()."php/activarCuenta.php?id=".$idUsuario;
				if(!is_null($email){
					if(enviarEmailValidacion($email, $link)){
						$_SESSION['mensaje'][] = [1, "Se ha enviado un correo de confirmación a $email, si no lo rebice espere un poco y/o revise el correo basura, si sigue sin recibirlo logeate para recibir otro correo de confimación."];
						irALogin();
					}else{
						$_SESSION['mensaje'][] = [0, "No se ha podido enviar el correo."];
						irALogin();
					}
				}else{
					$_SESSION['mensaje'][] = [0, "No se ha posido obtener el email del usuario solicitado, intente logearse de nuevo."];
					irALogin();
				}
			}else{
				$_SESSION['mensaje'][] = [0, "No se ha podido validar la cuenta."];
				irALogin();
			}
		}else{
			$_SESSION['mensaje'][] = [0, "La ID no es valida."];
			irAIndex();
		}
		
		cerrarConexion($conexion);
	}else{
		$_SESSION['mensaje'][] = [0, "Parametros invalidos."];
		irAIndex();
	}

	function isIdCorrecta(&$conexion, $idUsuario){
		$query = $conexion->prepare("SELECT validado FROM usuarios WHERE idUsuario = $idUsuario;");
		$query->execute();

		if($row = $query->fetch()) return ($row['validado'] == 0);
		else return false;
	}
	function setValidando(&$conexion, $idUsuario){
		$query = $conexion->prepare("UPDATE usuarios SET validando = 1 WHERE idUsuario = $idUsuario;");
		return $query->execute();
	}

	function enviarEmailValidacion($para, $link){
		// título
		$titulo = 'Projecte Vota - Validacion cuenta';

		// mensaje
		$mensaje = '
		<html>
		<head>
		<title>Projecte Vota - Validacion cuenta</title>
		</head>
		<body>
		<p>Se ha registrado en <b>Projecte Vota</b> para activar su cuenta haga clic <a href="'.$link.'">aqui</a></p>
		</body>
		</html>
		';
		return enviarEmail($para, $titulo, $mensaje);
	}

	function irALogin(){
		header("Location: ../pagina/login.php");
	}
	function irAIndex(){
		header("Location: ../index.php");
	}	
?>
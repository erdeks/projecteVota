<?php
require "../../inicializar.php";
if(existeYnoEstaVacio($_POST['email'])){
	$email=$_POST['email'];
	if(correoValido($email)){
		$conexion = abrirConexion();
		if(correoExiste($conexion, $email)){
			if(!estaActivadoCambiarContra($conexion, $email)){
				if(activarCambiarContra($conexion, $email)){
					$linkCambiarContra = getURLPage()."pagina/nuevaPassword.php?email=$email";
					$linkCancelar = getURLPage()."php/auth/password/cambiarPassword.php?email=$email&cancelar=true";
					if(enviarEmailRecuperacion($email, $linkCambiarContra, $linkCancelar)){
						$_SESSION['mensaje'][] = [1, "Se ha enviado un correo a $email para cambiar la contraseña."];
					}else{
						$_SESSION['mensaje'][] = [0, "No se ha posido enviar el correo."];
					}
				}else{
					$_SESSION['mensaje'][] = [0, "No se ha posdido activar el email %email para cambiar la contraseña."];
				}
			}else{
				$_SESSION['mensaje'][] = [0, "Ya se ha enviado el correo de verificación a $email."];
			}
		}else{
			$_SESSION['mensaje'][] = [0, "El email $email no existe."];
		}
		cerrarConexion($conexion);
	}else{
		$_SESSION['mensaje'][] = [0, "Formato del email $email no es valido."];
	}
	irARecuperarPassword();
}else{
	$_SESSION['mensaje'][] = [0, "El campo no pueden estar vacios."];
	irAIndex();
}
function enviarEmailRecuperacion($para, $linkCambiarContra, $linkCancelar){
	// título
	$titulo = 'Projecte Vota - Cambiar Password';

	// mensaje
	$mensaje = '
	<html>
	<head>
	<title>Projecte Vota - Cambiar Password</title>
	</head>
	<body>
	<p>Ha solicitado poder cambiar la contraseña, haga click <a href="'.$linkCambiarContra.'">aquí</a> para cambiarla, de lo contrario haga click <a href="'.$linkCancelar.'">aquí</a>.</p>
	</body>
	</html>
	';
	return enviarEmail($para, $titulo, $mensaje);
}
function irAIndex(){
	header("Location: ../../../index.php");
}
function irARecuperarPassword(){
	header("Location: ../../../pagina/recuperarPassword.php");
}
function activarCambiarContra(&$conexion, $email){
	$query = $conexion->prepare("UPDATE usuarios SET cambiarPassword = 1 WHERE email = '$email'");
	return $query->execute();
}
function correoExiste(&$conexion, $email){
	$query = $conexion->prepare("SELECT password FROM usuarios WHERE email = '$email';");
	$query->execute();
	$rows=$query->rowCount();
	return $rows == 1;
}
?>

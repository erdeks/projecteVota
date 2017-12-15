<?php
  require "inicializar.php";
  if(existeYnoEstaVacio($_POST['email'])){
    $email=$_POST['email'];
    $emailUsuario = $_SESSION['usuario']['email'];
    $idUsuario = $_SESSION["usuario"]['id'];
    if(correoValido($email)){
      if(activarCambiarPassword($conexion, $idUsuario)){
          $link = getURLPage()."pagina/cambiarPassword.php?email=$email";
          $link2 = getURLPage()."php/auth/password/validarRecuperarPassword.php?email=$email&cancelar=true";
          if(enviarEmailRecuperacion($email, $emailUsuario, $link)){
            $_SESSION['mensaje'][] = [1, "Se ha enviado un correo para cambiar la contraseña."];
          }else{
            $_SESSION['mensaje'][] = [0, "No se ha posido enviar el correo."];
            irARecuperarPassword();
          }
      }else{
        $_SESSION['mensaje'][] = [0, "Formato del email $email no es valido."];
        irARecuperarPassword();
      }
    }else{
      $_SESSION['mensaje'][] = [0, "Formato del email $email no es valido."];
      irARecuperarPassword();
    }
  }else{
    $_SESSION['mensaje'][] = [0, "El campo no pueden estar vacios."];
    irAIndex();
  }
  function enviarEmailRecuperacion($para, $emailUsuario, $link){
		// título
		$titulo = 'Projecte Vota - Recuperar Password';

		// mensaje
		$mensaje = '
		<html>
		<head>
		<title>Projecte Vota - Recuperar Password</title>
		</head>
		<body>
		<p>Ha solicitado poder cambiar la contraseña, haga click <a href="'.$link.'">aquí</a> para cambiarla, de lo contrario haga click <a href="'.$link2.'">aquí</a>.</p>
		</body>
		</html>
		';
		return enviarEmail($para, $titulo, $mensaje);
	}
  function activarCambiarPassword(&$conexion, $idUsuario){
    $query = $conexion->prepare("UPDATE usuarios SET cambiarPassword = 1 WHERE idUsuario = $idUsuario");
		$query->execute();
  }
  function irAIndex(){
    header("Location: ../../../index.php");
  }
  function irARecuperarPassword(){
    header("Location: ../../../pagina/recuperarPassword.php");
  }
?>

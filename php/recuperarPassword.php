<?php
  require "inicializar.php";
  if(existeYnoEstaVacio($_POST['email'])){
    $email=$_POST['email'];
    $recuperarPassword=0;
    $emailUsuario = $_SESSION['usuario']['email'];
    $idUsuario = $_SESSION["usuario"]['id'];
    if(correoValido($email)){
      $recuperarPassword=1;
      solicitarCambioPassword($conexion, $idUsuario, $recuperarPassword);
      if(getRecuperarPassword($conexion, $idUsuario)==1){
        $link = getURLPage()."../pagina/introducirNuevaPassword.php?email=$email";
        enviarEmailRecuperacion($email, $emailUsuario, $link)
      }else{
        $_SESSION['mensaje'][] = [0, "Error al intentar recuperar la contraseña."];
      }
    }else{
      $_SESSION['mensaje'][] = [0, "Formato del email $email no es valido."];
    }
  }else{
    $_SESSION['mensaje'][] = [0, "El campo no pueden estar vacios."];
    irAIndex();
  }
  function enviarEmailRecuperacion($para, $emailUsuario, $link){
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
  function getRecuperarPassword(&$conexion, $idUsuario){
    $query = $conexion->prepare("SELECT recuperarPassword FROM usuarios WHERE idUsuario=$idUsuario");
    $query->execute();
    if($rows=$query->fetch()) return $rows['recuperarPassword'];
    else return null;
  }
  function solicitarCambioPassword(&$conexion, $idUsuario, $recuperarPassword){
    $query = $conexion->prepare("UPDATE usuarios SET recuperarPassword = $recuperarPassword WHERE idUsuario = $idUsuario");
		$query->execute();
  }
?>

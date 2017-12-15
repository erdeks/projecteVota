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
        $link = getURLPage()."./validarPassword.php?email=$email&cancelar=false";
        $link2 = getURLPage()."./validarPassword.php?email=$email&cancelar=true";
        enviarEmailRecuperacion($email, $emailUsuario, $link);
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

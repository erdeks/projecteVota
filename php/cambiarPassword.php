<?php
  require "inicializar.php";
  if(existeYnoEstaVacio($_POST['oldPassword']) && existeYnoEstaVacio($_POST['newPassword']) && existeYnoEstaVacio($_POST['newPasswordConfirm'])){
    $oldPassword = sha1(md5($_POST['oldPassword']));
    $idUsuario = $_SESSION["usuario"]['id'];
    $newPassword = sha1(md5($_POST['newPassword']));
    $newPasswordConfirm = sha1(md5($_POST['newPasswordConfirm']));
    if ($newPassword==$newPasswordConfirm){
      $conexion = abrirConexion();
      if (getPassword($conexion, $idUsuario)==$oldPassword){
        cambiarPassword($conexion, $idUsuario, $newPassword);
      }else{
        $_SESSION['mensaje'][] = [0, "Contraseña incorrecta."];
        irACambiarPassword();
      }
      cerrarConexion($conexion);
    }else{
      $_SESSION['mensaje'][] = [0, "Las contraseñas no coinciden."];
      irACambiarPassword();
    }
  }else{
    $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
    irAIndex();
  }

  function getPassword(&$conexion, $idUsuario){
    $query = $conexion->prepare("SELECT password FROM usuarios WHERE idUsuario = $idUsuario;");
    $query->execute();
    if($rows=$query->fetch()) return $rows['password'];
    else return null;
  }
  function cambiarPassword(&$conexion, $idUsuario, $password){
		$query = $conexion->prepare("UPDATE usuarios SET password = '$password' WHERE idUsuario = $idUsuario");
		$query->execute();
		enviarValidacion($idUsuario);
	}
  function irACambiarPassword(){
    header("Location: ../pagina/cambiarPassword.php");
  }

?>

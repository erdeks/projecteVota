<?php
  require "inicializar.php";
  if(existeYnoEstaVacio($_GET['email']) && existeYnoEstaVacio($_GET['cancelar'])){
    $email = $_GET['email'];
    if($_GET['cancelar'] == true){
      $conexion = abrirConexion();
      $idUsuario = getIdUsuario($conexion, $_GET['email']);
      if(desactivarCambiarContra($conexion, $idUsuario)){
        $_SESSION['mensaje'][] = [1, "Se ha desactivado la recuperación de la contraseña."];
        irAIndex();
      }else{
        $_SESSION['mensaje'][] = [0, "Se no se ha podido desactivar la recuperación de la contraseña."];
        irANuevaPassword($email);
      }
      cerrarConexion($conexion);
    }else{
      $_SESSION['mensaje'][] = [0, "Parametro no valido."];
      irANuevaPassword($email);
    }
  }else if(existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['newPassword']) && existeYnoEstaVacio($_POST['newPasswordConfirm'])){
    $email = $_GET['email'];
    $newPassword = $_POST['newPassword'];
    $newPasswordConfirm = $_POST['newPasswordConfirm'];
    if($newPassword === $newPasswordConfirm){
      $idUsuario = getIdUsuario($conexion, $email);
      irACambiarPassword($idUsuario, hash('sha256',hash('sha256', $newPassword)));
    }else{
      $_SESSION['mensaje'][] = [0, "Las contraseña no coinciden."];
      irANuevaPassword($email);
    }

  }else{
    $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
    irAIndex();
  }

  function irAIndex(){
    header("Location: ../../../index.php");
  }

  function irANuevaPassword($email){
    header("Location: ../../../pagina/nuevaPassword.php?email=$email");
  }
  function irACambiarPassword($idUsuario, $password){
    header("Location: ./cambiarPassword?idUsuario=$email&password=$password");
  }
?>

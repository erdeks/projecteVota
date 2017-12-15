<?php
  require "inicializar.php";
  if(existeYnoEstaVacio($_POST['oldPassword']) && existeYnoEstaVacio($_POST['newPassword']) && existeYnoEstaVacio($_POST['newPasswordConfirm']) && existeYnoEstaVacio($_SESSION['usuario'])){
    $oldPassword = hash('sha256', hash('sha256', $_POST['oldPassword']));
    $idUsuario = $_SESSION["usuario"]['id'];
    $newPassword = hash('sha256', hash('sha256', $_POST['newPassword']));
    $newPasswordConfirm = hash('sha256', hash('sha256', $_POST['newPasswordConfirm']));
    if ($newPassword===$newPasswordConfirm){
      $conexion = abrirConexion();
      if (getPassword($conexion, $idUsuario)==$oldPassword){
        if(activarCambiarContra($conexion, $idUsuario)){
          header("Location: ./cambiarPassword.php");
        }else{
          $_SESSION['mensaje'][] = [0, "No se ha podido cambiar la contraseña."];
          irACambiarPassword();
        }

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
  function irACambiarPassword(){
    header("Location: ../../pagina/cambiarPassword.php");
  }

?>

<?php
  require "inicializar.php";
  if(existeYnoEstaVacio($_GET['email']) && existeYnoEstaVacio($_GET['cancelar'])){
    $conexion = abrirConexion();
    $idUsuario = getIdUsuario($conexion, $_GET['email']);
    if($_GET['cancelar'] == true){
      if(getValidador($conexion, $idUsuario)){

      }else{

      }
    }else{

    }

  }else{
    $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
    irAIndex();
  }
  function 
  function getValidador(&$conexion, $idUsuario){
    $query = $conexion->prepare("SELECT recuperarPassword FROM usuarios WHERE idUsuario = $idUsuario;");
    $query->execute();
    if($rows=$query->fetch()) return $rows['recuperarPassword'];
    else return null;
  }

  function irAIntroducirNuevaPassword(){
    header("Location: ./introducirNuevaPassword.php");
  }
?>

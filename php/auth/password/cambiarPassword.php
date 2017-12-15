<?php
require "inicializar.php";
if(existeYnoEstaVacio($_GET['idUsuario']) && existeYnoEstaVacio($_GET['password'])){
  $idUsuario = $_GET['idUsuario'];
  $password = $_GET['password'];
  $conexion = abrirConexion();
  if(sePuedeCambiarContra($conexion, $idUsuario)){
  	if(desactivarCambiarContra($conexion, $idUsuario)){
		if(cambiarPassword($conexion, $idUsuario, $password)){
			$_SESSION['mensaje'][] = [1, "La contraseña se ha cambiado correctamente."];
			irALogin();
		}else{
			$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
			irAIndex();
		}
  	}else{
		$_SESSION['mensaje'][] = [0, "No se ha podido desactivar la contraseña actual."];
		irAIndex();
  	}
  }else{
	$_SESSION['mensaje'][] = [0, "No ha solicitado cambiar la contraseña."];
	irAIndex();
  }
}else{
  $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
  irAIndex();
}


function cambiarPassword(&$conexion, $idUsuario, $password){
  $query = $conexion->prepare("UPDATE usuarios SET password = '$password' WHERE idUsuario = $idUsuario");
  return $query->execute();
}
function sePuedeCambiarContra(&$conexion, $idUsuario){
	$query = $conexion->prepare("SELECT recuperarPassword FROM usuarios WHERE idUsuario = $idUsuario;");
    $query->execute();
    if($rows=$query->fetch()) return $rows['recuperarPassword'] == 1;
    else return null;
}
function irAIndex(){
	header("Location: ../../../index.php");
}
function irALogin(){
	header("Location: ../../../pagina/login.php");
}
?>

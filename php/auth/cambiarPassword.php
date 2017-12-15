<?php
require "inicializar.php";
if(existeYnoEstaVacio($_GET['idUsuario']) && existeYnoEstaVacio($_GET['password'])){
  $idUsuario = $_GET['idUsuario'];
  $password = $_GET['password'];
  $conexion = abrirConexion();
  cambiarPassword($conexion, $idUsuario, $password);
}else{
  $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
  irAIndex();
}


function cambiarPassword(&$conexion, $idUsuario, $password){
  $query = $conexion->prepare("UPDATE usuarios SET password = '$password' WHERE idUsuario = $idUsuario");
  $query->execute();
  irACambiarPassword();

}
?>

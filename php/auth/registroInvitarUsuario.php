<?php
	require "inicializar.php";
	if(existeYnoEstaVacio($_GET['email']) && existeYnoEstaVacio($_GET['idEncuesta'])){
		if(existeYnoEstaVacio($_SESSION['usuario'])){
			irVotarEncuesta($_GET['idEncuesta']);
		}else{
			$conexion = abrirConexion();
			if(existeUsuarioRegistrado($conexion, $_GET['email'])){
				$_SESSION['mensaje'][] = [2, "Para poder votar es necesario logearse."];
				irALogin($_GET['email'], $_GET['idEncuesta']);
			}else{
				$_SESSION['mensaje'][] = [2, "Para poder votar es necesario registrase."];
				irARegistro($_GET['email'], $_GET['idEncuesta']);
			}
			cerrarConexion($conexion);
		}
	}else{
		$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
		irAIndex();
	}

	function irAIndex(){
		header("Location: ../index.php");
	}
	function irARegistro($email, $idEncuesta){
		header("Location: ../pagina/registro.php?email=$email&idEncuesta=$idEncuesta");
	}
	function irALogin($email, $idEncuesta){
		header("Location: ../pagina/login.php?email=$email&idEncuesta=$idEncuesta");
	}
	function irVotarEncuesta($idEncuesta){
	  header("Location: ../pagina/votarEncuesta.php?idEncuesta=$idEncuesta");
	}
?>
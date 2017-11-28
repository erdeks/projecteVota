<?php
	require "inicializar.php";
	if(existeYnoEstaVacio($_GET['email']){
		$_SESSION['mensaje'][] = [2, "Para poder votar es necesario registrase."];
		irARegistro($_GET['email']);
	}else{
		$_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
		irAIndex();
	}

	function irAIndex(){
		header("Location: ../index.php");
	}
	function irARegistro($email){
		header("Location: ../pagina/registro.php?email=$email");
	}
?>
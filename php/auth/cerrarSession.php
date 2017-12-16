<?php
	require "../inicializar.php";
	if(existeYnoEstaVacio($_SESSION['usuario'])) unset($_SESSION['usuario']);

	header("Location: ../../index.php");
?>
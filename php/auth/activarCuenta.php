<?php
	require "../inicializar.php";

	if(existeYnoEstaVacio($_GET['email'])){
		$email = $_GET['email'];
		$conexion = abrirConexion();
		if(isEmailCorrecto($conexion, $email)){
			activarCuenta($conexion, $email);
			$_SESSION['mensaje'][] = [1, "La cuenta a sido activada."];
			irALogin($email);
		}else{
			$_SESSION['mensaje'][] = [0, "El email no es valido."];
			irAIndex();
		}
	}else{
		$_SESSION['mensaje'][] = [0, "Parametros invalidos."];
		irAIndex();
	}
	function activarCuenta(&$conexion, $email){
		$query = $conexion->prepare("UPDATE usuarios SET validado = 1, validando = 0 WHERE email = '$email';");
		$query->execute();
	}

	function isEmailCorrecto(&$conexion, $email){
		$query = $conexion->prepare("SELECT validado, validando FROM usuarios WHERE email = '$email';");
		$query->execute();
		if($row = $query->fetch()){
			return ($row['validado'] == 0 && $row['validando'] == 1);
		}else{
			return false;
		}
	}
	
	function irALogin($email){
		if(existeYnoEstaVacio($_GET['idEncuesta'])) header("Location: ../../pagina/login.php?email=$email&idEncuesta=".$_GET['idEncuesta']);
		else header("Location: ../../pagina/login.php?email=$email");
	}
	function irAIndex(){
		header("Location: ../../index.php");
	}

?>
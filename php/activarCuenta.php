<?php
	require "inicializar.php";

	if(existeYnoEstaVacio($_GET['id'])){
		$id = $_GET['id'];
		require "conexionBBDD.php";
		$conexion = abrirConexion();
		if(isIdCorrecta($conexion, $id)){
			activarCuenta($conexion, $id);
			$_SESSION['mensaje'][] = [1, "La cuenta a sido activada."];
			irALogin();
		}else{
			$_SESSION['mensaje'][] = [0, "La ID no es valida."];
			irAIndex();
		}
	}else{
		$_SESSION['mensaje'][] = [0, "Parametros invalidos."];
		irAIndex();
	}
	function activarCuenta(&$conexion, $id){
		$query = $conexion->prepare("UPDATE usuarios SET validado = 1, validando = 0 WHERE idUsuario = $id;");
		$query->execute();
	}

	function isIdCorrecta(&$conexion, $id){
		$query = $conexion->prepare("SELECT validado, validando FROM usuarios WHERE idUsuario = $id;");
		$query->execute();
		if($row = $query->fetch()){
			return ($row['validado'] == 0 && $row['validando'] == 1);
		}else{
			return false;
		}
	}
	
	function irALogin(){
		header("Location: ../pagina/login.php");
	}
	function irAIndex(){
		header("Location: ../index.php");
	}

?>
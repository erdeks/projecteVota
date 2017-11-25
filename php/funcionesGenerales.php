<?php
	function existeYnoEstaVacio(&$variable){
		return (isset($variable) && (is_array($variable) ? !empty($variable) : $variable != ""));
	}
	function correoValido($str){
		return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
	}
	function enviarEmail($para, $titulo, $mensaje){

		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		$cabeceras .= 'From: Projecte Vota <admin@projectevota.com>' . "\r\n";

		// Enviarlo
		return mail($para, $titulo, $mensaje, $cabeceras);
	}

	function getMensajes(){
		foreach ($_SESSION["mensaje"] as $key => $value) {
			$mensaje = "<p>";
			foreach ($value as $key => $value) {
				$mensaje.= " -> ".$value;
			}
			$mensaje.="</p>";
			echo $mensaje;
		}
		$_SESSION["mensaje"] = [];
	}
	function getIdUsuario(&$conexion, $email){
		$query = $conexion->prepare("SELECT idUsuario FROM usuarios WHERE email = '$email';");
		$query->execute();
		if($row = $query->fetch()) return $row['idUsuario'];
		else return null;
	}

	function getEmail(&$conexion, $id){
		$query = $conexion->prepare("SELECT email FROM usuarios WHERE idUsuario = $id;");
		$query->execute();
		if($row = $query->fetch()){
			return $row['email'];
		}
		return null;
	}

	function existeUsuario(&$conexion, $email){
		$query = $conexion->prepare("SELECT idUsuario FROM usuarios WHERE email = '$email';");
		$query->execute();
		$rows=$query->rowCount();
		if($rows == 0) return false;
		else if($rows == 1) return true;
		else return null;
	}
	function multiexplode ($delimiters,$string) {
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return $launch;
	}
?>
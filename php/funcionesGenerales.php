<?php
	function getURLHost(){
		return $_SERVER['SERVER_NAME']."/";
	}
	function getURLcartepa(){
		return "projecteVota/";
	}
	function getURLPage(){
		if (strpos(getURLHost(), 'www.') !== false) return "https://".getURLHost().getURLcartepa();
		else return "https://www.".getURLHost().getURLcartepa();
	}
	function getURLAbsolute(){
		return "/".getURLcartepa();
	}
	function getCurrentPage(){
		return $_SERVER["REQUEST_URI"];
	}
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
			$mensaje = "<div ";
			if($value[0] == 2) $mensaje.= 'class="isa_info"><i class="fa fa-info-circle"></i>'.$value[1].'</div>';
			else if($value[0] == 1) $mensaje.= 'class="isa_success"><i class="fa fa-check"></i>'.$value[1].'</div>';
			else $mensaje.= 'class="isa_error"><i class="fa fa-times-circle"></i>'.$value[1].'</div>';
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
	function existeUsuarioRegistrado(&$conexion, $email){
		$query = $conexion->prepare("SELECT idUsuario FROM usuarios WHERE email = '$email' AND password IS NOT NULL AND idPermiso <> 1;");
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
	function generateRandomString($length = 50) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	function tieneAccesoALaEncuesta(&$conexion, $idEncuesta, $idUsuario){ //dos
	    $query = $conexion->prepare("SELECT idEncuesta FROM encuestas e LEFT JOIN accesoEncuestas a USING(idEncuesta) WHERE idEncuesta=$idEncuesta AND (e.idUsuario = $idUsuario OR a.idUsuario = $idUsuario);");
	    $query->execute();
	    $rows=$query->rowCount();
	    if($rows == 0) return false;
	    else return true;
	}
	function activarCambiarContra(&$conexion, $idUsuario){
	  	$query = $conexion->prepare("UPDATE usuarios SET cambiarPassword = 1 WHERE idUsuario = $idUsuario");
	  	return $query->execute();
	}
	function desactivarCambiarContra(&$conexion, $idUsuario){
		$query = $conexion->prepare("UPDATE usuarios SET recuperarPassword = 0 WHERE idUsuario = $idUsuario");
		return $query->execute();
	}
?>

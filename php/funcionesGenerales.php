<?php
	function existeYnoEstaVacio(&$variable){
		return (isset($variable) && $variable != "");
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
?>
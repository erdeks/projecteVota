<?php
	function abrirConexion(){
		define("HOST", "127.0.0.1");
		define("USER", "projecteVota");
		define("PASSWORD", "projecteVota2017");
		define("BBDD", "projecteVota");

		try{
			$pdo = new PDO ("mysql:host=".HOST.";dbname=".BBDD,
							USER,
							PASSWORD,
							array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			return $pdo;
		}catch (PDOException $e){
			echo "Failed to get DB handle: ". $e->getMessage() ."\n";
			return null;
			exit;
		}
	}

	function cerrarConexion(&$conexion){
		$conexion = null;
	}
?>

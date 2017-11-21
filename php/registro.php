<?php
	session_start();

	if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['email']) && existeYnoEstaVacio($_POST['password']) && existeYnoEstaVacio($_POST['passwordConfirm'])){
		
		$email = $_POST['email'];
		$password = sha1(md5($_POST['password']));
		$passwordConfirm = sha1(md5($_POST['passwordConfirm']));

		if($password === $passwordConfirm){
			require "conexionBBDD.php";
			$conexion = abrirConexion();
			/*$query = $conexion->prepare("INSERT INTO usuarios (idPermisos, email, password) VALUES 2, $email, $password");
			$query->execute();
			if($row = $query->fetch()){
				session_start();
				$_SESSION['usuario'] = new array(
					"id" => $['idUsuario'], 
					"email" => $email, 
					"contraseña" => $password);
				header("../index.php");
			}*/
			$query = $conexion->prepare("SELECT idUsuario, idPermiso, validado FROM usuarios WHERE email = '$email';");
			$query->execute();
			$rows = getRows($query);
			if($rows == 0){ //Si no hay ningun usuario
				$query = $conexion->prepare("INSERT INTO usuarios (idPermiso, email, password) VALUES (2, '$email', '$password')");
				$query->execute();
				$last_id = $conn->lastInsertId();
				$_SESSION['usuario'] = [
					"id" => $last_id, 
					"email" => $email, 
					"contraseña" => $password,
					"validado" => 0];
			}else if($rows == 1){ //Si hay un usuario registrado
				if($row = $query->fetch()){
					if($row['idPermiso'] == 1){ //Si era un invitado y se registra
						//Cambiar el idPermisos a 2 (usuario) y valiando a 1 (true)

					}else{ //Si no es un invitado
						if($row['validado'] == 0){ //Si la cuenta no esta validada
						
						}else{ //Si la cuenta esta validada

						}
					}
				}
				$_SESSION['error'] += "Error. Ya existe una cuenta.";
			}else{
				$_SESSION['error'] += "Error. Hay mas de un usuario, contacte con el soporte.";
			}
			/*$rowCount = $query->fetchColumn(0);
			echo $rowCount;
			echo "<br>";
			if($rowCount == 0){
				echo "as";
			}else if($rowCount == 1){
				echo "12";
			}*/
			cerrarConexion($conexion);
		}
	}
	//header("Location: ../index.php");

	function existeYnoEstaVacio($variable){
		return (isset($variable) && $variable != "");
	}

	function getRows($query){
		$array = [];
		while($row = $query->fetch()){
			$array[] = $row;
		}
		return count($array);
	}

?>
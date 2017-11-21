<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>MySQL PDO</title>
</head>
<body>
	<?php
		if(isset($_SESSION['usuario'])) echo "logeado";
	?>
	<h3>Login</h3>
	<form action="php/login.php" method="POST">
		<input type="text" name="email" placeholder="Email"><br>
		<input type="password" name="password" placeholder="Contraseña"><br>
		<input type="submit" name="login" value="Entrar">
	</form>

	<h3>Registro</h3>
	<form action="php/registro.php" method="POST">
		<input type="text" name="email" placeholder="Email"><br>
		<input type="password" name="password" placeholder="Contraseña"><br>
		<input type="password" name="passwordConfirm" placeholder="Confirmar contraseña"><br>
		<input type="submit" name="registro" value="Registrarse">
	</form>

</body>
</html>
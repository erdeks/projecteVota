<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if(!isset($_SESSION['usuario'])){ ?>
	<h3>Registro</h3>
	<?php
		if(isset($_GET['error']))
			switch ($_GET['error']) {
				case '1':
					echo "<p>El usuario ya existe.</p>";
					break;
				case '2':
					echo "<p>Las contraseñas no coinciden.</p>";
					break;
				case '3':
					echo "<p>Formato de email es incorrecto.</p>";
					break;
				case '4':
					echo "<p>Los parametros no pueden estar vacio.</p>";
					break;
			}?>
	<form action="../php/registro.php" method="POST">
		<input type="text" name="email" placeholder="Email" required><br>
		<input type="password" name="password" placeholder="Contraseña" required><br>
		<input type="password" name="passwordConfirm" placeholder="Confirmar contraseña" required><br>
		<input type="submit" name="registro" value="Registrarse">
	</form>
	<?php }else{ ?>
		<p>Ya estas logeado</p>
	<?php } ?>
</body>
</html>
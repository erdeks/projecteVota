<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body><?php getMensajes() ?>
	<?php if(!isset($_SESSION['usuario'])){ ?>
	<h3>Registro</h3>
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
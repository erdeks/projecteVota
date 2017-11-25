<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body><?php getMensajes(); ?>
<?php if(!isset($_SESSION['usuario'])){ ?>
	<h3>Login</h3>
	<form action="../php/login.php" method="POST">
		<input type="text" name="email" placeholder="Email" required><br>
		<input type="password" name="password" placeholder="Contraseña" required><br>
		<input type="submit" name="login" value="Entrar" required>
	</form>
	<?php }else{ ?>
		<p>Usaurio: <?php echo $_SESSION["usuario"]["email"]?></p>
	<?php } ?>
</body>
</html>
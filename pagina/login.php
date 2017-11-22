<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
<?php if(!isset($_SESSION['usuario'])){ ?>
	<h3>Login</h3>
	<?php
		if(isset($_GET['error']))
			switch ($_GET['error']) {
				case '1':
					echo "<p>El usuario o contraseña estan mal.</p>";
					break;
				case '2':
					echo "<p>Los campos no pueden estar vacios.</p>";
					break;
			}?>
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
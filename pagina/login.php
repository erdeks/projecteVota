<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Projecte Vota - Login</title>
	<?php require "../partes/headGeneral.php"; ?>
</head>
<body>
	<?php require "../partes/cabecera.php";?>
	<?php require "../partes/menu.php"; ?>
	<div id="divCentral">
		<div>
			<div id="contenido">
				<?php getMensajes(); ?>
				<h2 class="cardTitle">Login</h2>
				<div class="cardContent">
					<?php if(!isset($_SESSION['usuario'])){ ?>
					<form action="../php/login.php" method="POST">
						<input type="text" name="email" placeholder="Email" required><br>
						<input type="password" name="password" placeholder="Contraseña" required><br>
						<input type="submit" name="login" value="Entrar" required>
					</form>
				<?php }else{ ?>
					<p>Ya te encuentras logeado</p>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php require "../partes/pieDePagina.php"; ?>
</body>
</html>
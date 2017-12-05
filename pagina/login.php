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
				<div class="cardContent"><?php
					if(!existeYnoEstaVacio($_SESSION['usuario'])){
						$email = "";
						if(existeYNoEstaVacio($_GET['email'])) $email = $_GET['email']; ?>
						<form action="../php/login.php" method="POST">
							<input type="text" name="email" placeholder="Email" value="<?php echo $email ?>" required><br>
							<input type="password" name="password" placeholder="Contraseña" required><br>
							<a href="recuperarPassword.php">Has olvidado tu contraseña?</a><br>
							<input type="submit" name="login" value="Entrar" required>
						</form>
					<?php }else{
						header("Location: ../index.php");
					} ?>
				</div>
			</div>
		</div>
	</div>
	<?php require "../partes/pieDePagina.php"; ?>
</body>
</html>

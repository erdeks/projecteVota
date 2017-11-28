<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Projecte Vota - Registro</title>
	<?php require "../partes/headGeneral.php"; ?>
</head>
<body>
	<?php require "../partes/cabecera.php";?>
	<?php require "../partes/menu.php"; ?>
	<div id="divCentral">
		<div>
			<div id="contenido">
				<?php getMensajes(); ?>
				<h2 class="cardTitle">Registro</h2>
				<div class="cardContent">
					<?php if(!isset($_SESSION['usuario'])){ ?>
					<form action="../php/registro.php" method="POST">
						<input type="text" name="email" placeholder="Email" required><br>
						<input type="password" name="password" placeholder="Contraseña" required><br>
						<input type="password" name="passwordConfirm" placeholder="Confirmar contraseña" required><br>
						<input type="submit" name="registro" value="Registrarse">
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
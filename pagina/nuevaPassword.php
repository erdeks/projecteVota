<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Projecte Vota - Cambiar Contraseña</title>
	<?php require "../partes/headGeneral.php"; ?>
</head>
<body>
	<?php require "../partes/cabecera.php";?>
	<?php require "../partes/menu.php"; ?>
	<div id="divCentral">
		<div>
			<div id="contenido">
				<?php getMensajes();?>
				<h2 class="cardTitle">Cambiar Contraseña</h2>
				<div class="cardContent">
		            <form action="../php/auth/password/validarRecuperarPassword.php" method="post">
		              <input type="password" name="newPassword" placeholder="Nueva Contraseña" required><br>
		              <input type="password" name="newPasswordConfirm" placeholder="Confirma Nueva Contraseña" required><br>
		              <input type="text" name="email" value="<?php echo $_GET['email']; ?>" style="display: none" required>
		              <input type="submit" value="Enviar">
			        </form>
				</div>
			</div>
		</div>
	</div>
	<?php require "../partes/pieDePagina.php"; ?>
	<?php function getGets(){

		} ?>
</body>
</html>

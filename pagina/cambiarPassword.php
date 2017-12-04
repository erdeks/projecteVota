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
				<?php getMensajes(); ?>
				<h2 class="cardTitle">Cambiar Contraseña</h2>
				<div class="cardContent">
					<?php if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
            <form action="../php/cambiarPassword.php" method="post">
              <input type="password" name="oldPassword" placeholder="Contraseña Antigua" required><br>
              <input type="password" name="newPassword" placeholder="Nueva Contraseña" required><br>
              <input type="password" name="newPasswordConfirm" placeholder="Confirma Nueva Contraseña" required><br>
              <input type="submit" value="Entrar" required>
            </form>
				<?php }else{
          $_SESSION['mensaje'][] = [0, "Tienes que iniciar sesion."];
          header("Location: login.php");
				 } ?>
				</div>
			</div>
		</div>
	</div>
	<?php require "../partes/pieDePagina.php"; ?>
</body>
</html>

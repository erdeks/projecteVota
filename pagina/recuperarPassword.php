<?php 
	require "../php/inicializar.php";
	if(existeYnoEstaVacio($_SESSION['usuario'])){
		$_SESSION['mensaje'][] = [0, "No puedes acceder a esta pagina."];
		header("Location: ../index.php");
		die();
	}
?>
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
		          <form action="../php/auth/password/enviarEmailRecuperacionPassword.php" method="post">
		            <label for="email">Introduce el correo para recuperar contraseña: </label><br>
		            <input type="text" name="email" id="email">
		            <input type="submit" value="Enviar" required>
		          </form>
				</div>
			</div>
		</div>
	</div>
	<?php require "../partes/pieDePagina.php"; ?>
</body>
</html>

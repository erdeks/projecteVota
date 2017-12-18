<?php require "php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Projecte Vota - Inicio</title>
	<?php require "partes/headGeneral.php"; ?>
</head>
<body>
	<?php require "partes/cabecera.php";?>
	<?php require "partes/menu.php"; ?>
	<div id="divCentral">
		<div>
			<div id="contenido">
				<?php getMensajes(); ?>
				<h2 class="cardTitle">Projecte Vota</h2>
				<div class="cardContent">
					<p>Bienvenidos a la pagina web del projecto vota aqui podras participar
					en varias encuestas distintas y ayudar a la gente que requiere asistencia
					para efectuar estadististicas.</p>
				</div>
			</div>
		</div>
	</div>
	<?php require "partes/pieDePagina.php"; ?>
</body>
</html>

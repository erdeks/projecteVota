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
				<?php getMensajes(); echo hash("sha256", "1234");?>
				<h2 class="cardTitle">Projecte Vota</h2>
				<div class="cardContent">
					<p>Proximamente ...</p>
				</div>
			</div>
		</div>
	</div>
	<?php require "partes/pieDePagina.php"; ?>
</body>
</html>
<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Projecte Vota - Crear Encuestas</title>
	<?php require "../partes/headGeneral.php"; ?>
	<script type="text/javascript" src="../js/validacionEncuesta.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/error.css" />
</head>
<body>
	<?php require "../partes/cabecera.php";?>
	<?php require "../partes/menu.php"; ?>
	<div id="divCentral">
		<div>
			<div id="contenido">
				<?php getMensajes(); ?>
				<h2 class="cardTitle">Crear Encuestas</h2>
				<div class="cardContent">
					<?php if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
						<button id="generarForm" type="button">Generar el formulario</button>
					<?php }else{ ?>
						<p>Necesitas logearte para crear una encuesta.</p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php require "../partes/pieDePagina.php"; ?>
</body>
</html>
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
			<?php getMensajes();
			if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
				<h2 class="cardTitle">Projecte Vota</h2>
				<div class="cardContent">
				<?php
					$conexion = abrirConexion();
					$idUsuario = $_SESSION['usuario']['id'];
					$query = $conexion->prepare("SELECT idEncuesta, e.nombre FROM accesoEncuestas a JOIN encuestas e USING(idEncuesta) WHERE a.idUsuario=$idUsuario;");
					$query->execute();

					echo "<ul>";
					while($encuestas = $query -> fetch()){
						$link = getURLAbsolute()."pagina/votarEncuesta.php?idEncuesta=".$encuestas["idEncuesta"];
						echo "<li><a href='$link'>".$encuestas["nombre"]."</li>";


				}
				echo "</ul>";
				?> </div>
			<?php } ?>
			</div>
		</div>
			<?php }else{ ?>
				<h2 class="cardTitle">Projecte Vota</h2>
				<div class="cardContent">
					<p>Proximamente ...</p>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	<?php require "partes/pieDePagina.php"; ?>
</body>
</html>

<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
  <title>Projecte Vota - Votar Encuestas</title>
  <?php require "../partes/headGeneral.php"; ?>
  <script type="text/javascript" src="../js/animacionPreguntas.js"></script>
</head>
<body>
  <?php require "../partes/cabecera.php";?>
  <?php require "../partes/menu.php"; ?>
  <div id="divCentral">
    <div>
      <div id="contenido">
        <?php
        if(existeYnoEstaVacio($_SESSION['usuario'])){
          if(existeYnoEstaVacio($_GET["idEncuesta"])){
            getMensajes();
            $conexion = abrirConexion();
            $idEncuesta = $_GET["idEncuesta"];
            $idUsuario = $_SESSION['usuario']['id'];

            if(tieneAccesoALaEncuesta($conexion, $idEncuesta, $idUsuario)){
              if(haCreadoEstaEncuesta($conexion, $idEncuesta, $idUsuario)){
              	verMiEncuesta($conexion, $idEncuesta);
              }else{
                $_SESSION['mensaje'][] = [0, "No puedes acceder a esa encuesta."];
                header("Location: ./verMisEncuestas.php");
              }
            }else{ ?>
              <h2 class="cardTitle">Error</h2>
              <div class="cardContent">
                <p>No tiene acceso para acceder a esta encuesta.</p>
              </div><?php
            }
            cerrarConexion($conexion);
          }else{
            $_SESSION['mensaje'][] = [0, "No se han obtenido todos los parametros"];
            header("Location: ../index.php");
          }
        }else{
          $_SESSION['mensaje'][] = [0, "Necesitas logearte para poder votar."];
          header("Location: ./login.php");
        } ?>
      </div>
    </div>
  </div>
  <?php require "../partes/pieDePagina.php"; ?>
</body>
</html>


<?php
  function haCreadoEstaEncuesta(&$conexion, $idEncuesta, $idUsuario){
    $query = $conexion->prepare("SELECT idEncuesta FROM encuestas WHERE idEncuesta=$idEncuesta AND idUsuario = $idUsuario;");
    $query->execute();
    $rows=$query->rowCount();
    if($rows == 0) return false;
    else return true;
  }
  function verMiEncuesta(&$conexion, $idEncuesta){ ?>
	<h2 class="cardTitle">Información sobre la encuesta</h2>
	<div class="cardContent"><?php
		$query = $conexion->prepare("SELECT nombre, descripcion FROM encuestas WHERE idEncuesta=$idEncuesta;");
		$query->execute();
		if($encuestas = $query -> fetch()){
			$nombre = $encuestas['nombre'];
			$descripcion = $encuestas['descripcion'];
			echo "<h1>$nombre</h1>";
			$query = $conexion->prepare("SELECT count(idOpcion) AS 'maxVotos' FROM votosEncuestas JOIN opcionesEncuestas USING (idOpcion) WHERE idEncuesta = $idEncuesta;");
			$query->execute();
			if ($row=$query->fetch()){
				$maxVotos = $row['maxVotos'];
				$query = $conexion->prepare("SELECT o.idOpcion, o.nombre, COUNT(v.idOpcion) AS 'cantVotos' FROM opcionesEncuestas o LEFT JOIN votosEncuestas v USING(idOpcion) WHERE o.idEncuesta = $idEncuesta GROUP BY idOpcion");
				$query->execute(); ?>
				<table>
					<tr>
						<th colspan='3'>Numero total de votos: <?php echo $maxVotos ?></th>
					</tr>
					<tr>
						<th>Respuesta</th>
						<th>Cantidad de votos</th>
						<th>Porcentaje de votos</th>
					</tr>
					<?php while($votos = $query->fetch()){ ?>
						<tr><?php
						$media = 0;
					if($maxVotos > 0) $media = $votos['cantVotos']*100/$maxVotos;
						echo "<td>".$votos['nombre']."</td>";
						echo "<td>".$votos['cantVotos'].($votos['cantVotos']==1 ? " voto " : " votos ")."</td>";
						echo "<td>".$media."%</td>";
						echo "</tr>";
					} ?>
				</table><?php
			}else{
				$_SESSION['mensaje'][] = [0, "No se ha posido obtener la id de la encuesta."];
				header("Location: ./votarEncuesta.php");
			}
		}else{
			$_SESSION['mensaje'][] = [0, "No se ha posido obtener la id de la encuesta."];
			header("Location: ./votarEncuesta.php");
		} ?>
	</div>
	<h2 class="cardTitle">Invitar Usuarios</h2>
	<div class="cardContent">
		<form action="../php/invitarUsuarios.php" method="post">
			<div><label>Introduce el email de los usuarios separados por ;</label></div>
			<textarea name="invitados" cols="50" rows="6"></textarea>
			<input type="text" name="idEncuesta" value="<?php echo $idEncuesta; ?>" hidden="hidden">
			<div><input type="submit" value="Invitar"></div>
		</form>
	</div>
	<h2 class="cardTitle">Usuarios Invitados</h2>
	<div class="cardContent">
		<ul class="noIconos"><?php
			$query = $conexion->prepare("SELECT email FROM accesoEncuestas a JOIN usuarios u USING (idUsuario) WHERE idEncuesta=$idEncuesta");
			$query->execute();
			while($usuarios = $query->fetch()){
				echo "<li>".$usuarios['email']."</li>";
			} ?>
		</ul>
	</div><?php
  }

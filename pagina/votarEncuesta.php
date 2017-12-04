<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
  <title>Projecte Vota - Crear Encuestas</title>
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
              	votarEncuesta($conexion, $idEncuesta, $idUsuario);
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
  function tieneAccesoALaEncuesta(&$conexion, $idEncuesta, $idUsuario){
    $query = $conexion->prepare("SELECT idEncuesta FROM encuestas e LEFT JOIN accesoEncuestas a USING(idEncuesta) WHERE idEncuesta=$idEncuesta AND (e.idUsuario = $idUsuario OR a.idUsuario = $idUsuario);");
    $query->execute();
    $rows=$query->rowCount();
    if($rows == 0) return false;
    else return true;
  }
  function encuestaActiva(&$conexion, $idEncuesta){ //Proximamente
    return true;
  }
  function verMiEncuesta(&$conexion, $idEncuesta){ ?>
	<h2 class="cardTitle">Mis Encuestas</h2>
	<div class="cardContent"><?php
		$query = $conexion->prepare("SELECT nombre, descripcion FROM encuestas WHERE idEncuesta=$idEncuesta;");
		$query->execute();
		if($encuestas = $query -> fetch()){
			$nombre = $encuestas['nombre'];
			$descripcion = $encuestas['descripcion'];
			echo "<h1>$nombre</h1>";
			$query = $conexion->prepare("SELECT count(idVoto) AS 'maxVotos' FROM votosEncuestas v JOIN opcionesEncuestas o USING(idOpcion) WHERE idEncuesta = $idEncuesta;");
			$query->execute();
			if ($row=$query->fetch()){
				$maxVotos = $row['maxVotos'];
				$query = $conexion->prepare("SELECT idOpcion, count(idVoto) AS 'cantVotos', nombre FROM opcionesEncuestas o LEFT JOIN votosEncuestas v USING(idOpcion) WHERE idEncuesta = $idEncuesta GROUP BY idOpcion;");
				$query->execute(); ?>
				<table>
					<tr>
						<th colspan='3'>Numero total de votos: $maxVotos</th>";
					</tr>
					<tr>
						<th>Respuesta</th>
						<th>Cantidad de votos</th>
						<th>Porcentage de votos</th>
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
			<div><input type="submit" value="Enviar"></div>
		</form>
	</div>
	<h2 class="cardTitle">Usuarios Invitados</h2>
	<div class="cardContent">
		<ul><?php
			$query = $conexion->prepare("SELECT email FROM accesoEncuestas a JOIN usuarios u USING (idUsuario) WHERE idEncuesta=$idEncuesta");
			$query->execute();
			while($usuarios = $query->fetch()){
				echo "<li>".$usuarios['email']."</li>";
			} ?>
		</ul>
	</div><?php
  }

  function votarEncuesta(&$conexion, $idEncuesta, $idUsuario){
	if(encuestaActiva($conexion, $idEncuesta)){
		$query = $conexion->prepare("SELECT nombre, descripcion, multirespuesta FROM encuestas WHERE idEncuesta=$idEncuesta;");
		$query->execute();
		if($encuestas = $query -> fetch()){ ?>
			<h2 class="cardTitle">Votar Encuesta</h2>
			<div class="cardContent"><?php
				$nombre = $encuestas['nombre'];
				$descripcion = $encuestas['descripcion'];
				$tipoInput = $encuestas['multirespuesta'] == 1 ? "checkbox" : "radio";
				echo "<h1>$nombre</h1>";
				if (existeYnoEstaVacio($descripcion)) echo "<h3>$descripcion</h3>";

				$query = $conexion->prepare("SELECT o.idOpcion, o.nombre, if((SELECT COUNT(v.idVoto) FROM votosEncuestas v WHERE idUsuario = $idUsuario AND v.idOpcion =  o.idOpcion) > 0, 1, 0) AS 'aVotado' FROM opcionesEncuestas o where o.idEncuesta = $idEncuesta;");
				$query->execute(); ?> 
				<form action="../php/votarEncuesta.php" method="post"> <?php
					while($respuestas = $query -> fetch()){
						$aVotado = "";
						if($respuestas['aVotado'] == 1) $aVotado = "checked"; ?>
						<input type="<?php echo $tipoInput ?>" name="respuestas[]" value="<?php echo $respuestas['idOpcion']; ?>" <?php echo $aVotado ?>><?php
						echo $respuestas['nombre']; ?></input><br><?php
					} ?>
					<input type="submit" value="Enviar">
				</form>
			</div><?php
		}else{
			$_SESSION['mensaje'][] = [0, "No se ha posido obtener la id de la encuesta."];
			header("Location: ./votarEncuesta.php");
		}
	}else{ ?>
		<h2 class="cardTitle">Votar encuesta</h2>
		<div class="cardContent">
			<p>Lo sentimos, pero el plazo para la votacion ha expirado.</p>
		</div><?php
	}
  }

?>

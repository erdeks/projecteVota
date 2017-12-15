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
          if($_SESSION['usuario']['idPermiso']==2){
            if(existeYnoEstaVacio($_GET["idEncuesta"])){
              getMensajes();
              $conexion = abrirConexion();
              $idEncuesta = $_GET["idEncuesta"];
              $idUsuario = $_SESSION['usuario']['id'];

              if(tieneAccesoALaEncuesta($conexion, $idEncuesta, $idUsuario)){
                if(fechaInicioActiva($conexion, $idEncuesta)){
                  if(fechaFinActiva($conexion, $idEncuesta)){
                    votarEncuesta($conexion, $idEncuesta, $idUsuario);
                  }else{ ?>
                    <h2 class="cardTitle">Votar encuesta</h2>
                    <div class="cardContent">
                      <p>Lo sentimos, pero el plazo para la votacion ha expirado.</p>
                    </div><?php
                  }
                }else{ ?>
                  <h2 class="cardTitle">Votar encuesta</h2>
                  <div class="cardContent">
                    <p>Lo sentimos, pero el plazo para la votacion aun no ha empezado.</p>
                  </div><?php
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
            $_SESSION['mensaje'][] = [0, "No tienes permisos."];
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
  function fechaInicioActiva(&$conexion, $idEncuesta){ //Proximamente
    $query = $conexion->prepare("SELECT if((now() >= inicio), 1, 0) AS 'inicio' FROM encuestas WHERE idEncuesta=$idEncuesta;");
    $query->execute();
    if($row = $query->fetch()){
      return $row['inicio'] == 1;
    }else return false;
  }
  function fechaFinActiva(&$conexion, $idEncuesta){ //Proximamente
    $query = $conexion->prepare("SELECT if((now() <= fin), 1, 0) AS 'fin' FROM encuestas WHERE idEncuesta=$idEncuesta;");
    $query->execute();
    if($row = $query->fetch()){
      return $row['fin'] == 1;
    }else return false;
  }
  function votarEncuesta(&$conexion, $idEncuesta, $idUsuario){

		$password = $_SESSION['usuario']['password'];
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

				$query = $conexion->prepare("SELECT o.idOpcion, o.nombre, if((SELECT COUNT(ve.idVoto) FROM votosEncuestasEncriptado ve, votosEncuestas v WHERE ve.idUsuario = $idUsuario AND AES_DECRYPT(ve.hashEncriptado, '$password') = v.hash AND v.idOpcion = o.idOpcion) > 0, 1, 0) AS 'aVotado' FROM opcionesEncuestas o where o.idEncuesta = $idEncuesta;");
				$query->execute(); ?>
				<form class="animacionDesplegar" action="../php/votarEncuesta.php" method="post"> <?php
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

  }

?>

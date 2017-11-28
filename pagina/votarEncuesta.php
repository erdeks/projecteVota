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
        <?php getMensajes();
        if(existeYnoEstaVacio($_SESSION['usuario'])){
          if(existeYnoEstaVacio($_GET["idEncuesta"])){
            $conexion = abrirConexion();
            $idEncuesta = $_GET["idEncuesta"];
            $idUsuario = $_SESSION['usuario']['id'];

            if(tieneAccesoALaEncuesta($conexion, $idEncuesta, $idUsuario)){
              if(haCreadoEstaEncuesta($conexion, $idEncuesta, $idUsuario)){ ?>
                <h2 class="cardTitle">Mi Encuesta</h2>
                <div class="cardContent">
                  <p>Proximamente ...</p>
                </div><?php
              }else{
                if(encuestaActiva($conexion, $idEncuesta)){
                  $query = $conexion->prepare("SELECT nombre, descripcion, multirespuesta FROM encuestas WHERE idEncuesta=$idEncuesta;");
                  $query->execute();
                  if($encuestas = $query -> fetch()){ ?>
                    <h2 class="cardTitle">Votar Encuesta</h2>
                    <div class="cardContent"> <?php
                      $nombre = $encuestas['nombre'];
                      $descripcion = $encuestas['descripcion'];
                      $multirespuesta = $encuestas['multirespuesta'] == 1;
                      echo "<h1>$nombre</h1>";
                      if (existeYnoEstaVacio($descripcion)) echo "<h3>$descripcion</h3>";

                      $query = $conexion->prepare("SELECT o.idOpcion, o.nombre, if(v.idUsuario IS NOT NULL AND v.idUsuario = $idUsuario, 1, 0) AS 'aVotado' FROM opcionesEncuestas o LEFT JOIN votosEncuestas v USING(idOpcion) WHERE o.idEncuesta=$idEncuesta ORDER BY o.idOpcion;");
                      $query->execute();
                      ?>
                      <form action="../php/votarEncuesta.php" method="post">
                        <?php
                          while($respuestas = $query -> fetch()){
                            $aVotado = "";
                            if($respuestas['aVotado'] == 1) $aVotado = "checked";
                            if($multirespuesta){ ?>
                              <input type="checkbox" name="respuestas" value="<?php echo $respuestas['idOpcion']; ?>" <?php echo $aVotado ?>><?php echo $respuestas['nombre']; ?></input><br>
                            <?php }else{ ?>
                              <input type="radio" name="respuestas" value="<?php echo $respuestas['idOpcion']; ?>" <?php echo $aVotado ?>><?php echo $respuestas['nombre']; ?></input><br>
                            <?php
                            }
                          }
                        ?>
                        <input type="submit" value="Enviar">
                      </form>
                    </div>
                  <?php
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
            }else{ ?>
              <h2 class="cardTitle">Error</h2>
              <div class="cardContent">
                <p>No tiene acceso para acceder a esta encuesta.</p>
              </div><?php
            }
            cerrarConexion($conexion);
          }else{ ?>
            <h2 class="cardTitle">Error</h2>
            <div class="cardContent">
              <p>Faltan parametros.</p>
            </div><?php
          }
        }else{ ?>
          <h2 class="cardTitle">Error</h2>
          <div class="cardContent">
            <p>Necesitas logearte para poder votar.</p>
          </div><?php
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
?>
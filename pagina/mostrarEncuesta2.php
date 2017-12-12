<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
  <title>Projecte Vota - Ver Encuestas</title>
  <?php require "../partes/headGeneral.php"; ?>
</head>
<body>
  <?php require "../partes/cabecera.php";?>
  <?php require "../partes/menu.php"; ?>
  <div id="divCentral">
    <div>
      <div id="contenido">
        <?php if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
          <?php getMensajes();
            $siVotado = [];
            $noVotado = [];
            $conexion = abrirConexion();
            $idUsuario = $_SESSION['usuario']['id'];
            $query = $conexion->prepare("SELECT idEncuesta, e.nombre FROM accesoEncuestas a JOIN encuestas e USING(idEncuesta) WHERE a.idUsuario=$idUsuario;");
            $query->execute();
            while($encuestas = $query -> fetch()){
              if(haVotado($conexion, $idUsuario, $encuestas['idEncuesta'])){
                $siVotado[] = [
      						"idEncuesta" => $encuestas['idEncuesta'],
      						"nombre" => $encuestas['nombre']];
              }else{
                $noVotado[] = [
      						"idEncuesta" => $encuestas['idEncuesta'],
      						"nombre" => $encuestas['nombre']];
              }
            }
          ?>
          <?php
            if (existeYnoEstaVacio($noVotado)){
          ?>
          <h2 class="cardTitle">Encuestas no votadas</h2>
          <div class="cardContent">
          <ul>
            <?php
              foreach ($noVotado as $value) {
                $link = getURLAbsolute()."pagina/votarEncuesta.php?idEncuesta=".$value["idEncuesta"];
                echo "<li><a href='$link'>".$value["nombre"]."</a></li>";
              }
            ?>
          </ul>
          </div>
          <?php
            }
            if (existeYnoEstaVacio($siVotado)){
          ?>
          <h2 class="cardTitle">Encuestas votadas</h2>
          <div class="cardContent">
            <ul>
              <?php
                foreach ($siVotado as $value) {
                  $link = getURLAbsolute()."pagina/votarEncuesta.php?idEncuesta=".$value["idEncuesta"];
                  echo "<li><a href='$link'>".$value["nombre"]."</a></li>";
                }
              ?>
            </ul>
          </div>
        <?php
          }
          }else{
          $_SESSION['mensaje'][] = [0, "Necesitas logearte para ver las encuestas."];
          header("Location: ./login.php");
         } ?>

        </div>
      </div>
    </div>
  </div>
  <?php require "../partes/pieDePagina.php"; ?>
</body>
</html>
<?php
  function haVotado(&$conexion, $idUsuario, $idEncuesta){
    $query = $conexion->prepare("SELECT COUNT(v.idVoto) AS 'cantVotos' FROM votosEncuestas v JOIN opcionesEncuestas o USING (idOpcion) WHERE idUsuario = $idUsuario AND o.idEncuesta =  $idEncuesta");
    $query->execute();
    if($row = $query->fetch()){
      if($row['cantVotos'] > 0) return true;
      else false;
    }else return false;
  }
?>

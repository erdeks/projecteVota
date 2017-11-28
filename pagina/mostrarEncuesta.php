<?php require "../php/inicializar.php";?>
<!DOCTYPE html>
<html>
<head>
  <title>Projecte Vota - Crear Encuestas</title>
  <?php require "../partes/headGeneral.php"; ?>
</head>
<body>
  <?php require "../partes/cabecera.php";?>
  <?php require "../partes/menu.php"; ?>
  <div id="divCentral">
    <div>
      <div id="contenido">
        <?php if(existeYnoEstaVacio($_SESSION['usuario'])){ ?>
          <?php getMensajes(); ?>
          <h2 class="cardTitle">Mis encuestas</h2>
          <div class="cardContent">
            <?php
              $conexion = abrirConexion();
              $idUsuario = $_SESSION['usuario']['id'];
              $query = $conexion->prepare("SELECT idEncuesta, nombre FROM encuestas WHERE idUsuario=$idUsuario;");
              $query->execute();

              echo "<ul>";
              while($encuestas = $query -> fetch()){
                $link = getURLAbsolute()."pagina/votarEncuesta.php?idEncuesta=".$encuestas["idEncuesta"];
                echo "<li><a href='$link'>".$encuestas["nombre"]."</a></li>";
              }
              echo "</ul>";
            ?>
          </div>
          <h2 class="cardTitle">Encuestas en la que estoy invitado.</h2>
          <div class="cardContent">
            <?php
              $query = $conexion->prepare("SELECT idEncuesta, e.nombre FROM accesoEncuestas a JOIN encuestas e USING(idEncuesta) WHERE a.idUsuario=$idUsuario;");
              $query->execute();

              echo "<ul>";
              while($encuestas = $query -> fetch()){
                $link = getURLAbsolute()."pagina/votarEncuesta.php?idEncuesta=".$encuestas["idEncuesta"];
                echo "<li><a href='$link'>".$encuestas["nombre"]."</li>";
              }
              echo "</ul>";
            ?>
          </div>
        <?php }else{
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
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
        <?php if(existeYnoEstaVacio($_SESSION['usuario'])){
            if($_SESSION['usuario']['idPermiso']==3){ 
         getMensajes(); ?>
          <h2 class="cardTitle">Mis Encuestas</h2>
          <div class="cardContent">
            <?php
              $conexion = abrirConexion();
              $idUsuario = $_SESSION['usuario']['id'];
              $query = $conexion->prepare("SELECT idEncuesta, nombre FROM encuestas WHERE idUsuario=$idUsuario;");
              $query->execute();

              echo "<ul class='noIconos'>";
              while($encuestas = $query -> fetch()){
                $link = getURLAbsolute()."pagina/verInfoEncuesta.php?idEncuesta=".$encuestas["idEncuesta"];
                echo "<li><a href='$link'>".$encuestas["nombre"]."</a></li>";
              }
              echo "</ul>";
            ?>
          </div>
        <?php
        }else{
          $_SESSION['mensaje'][] = [0, "No tienes permisos."];
          header("Location: ../index.php");
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

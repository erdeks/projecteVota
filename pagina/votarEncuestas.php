<?php require "../php/inicializar.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  <script type="text/javascript" src="../js/animacionPreguntas.js"></script>
</head>
<body>
  <?php

  $conexion = abrirConexion();
  $id = $_SESSION['usuario']['id'];
  $idEncuesta = $_GET["idEncuesta"];
  $query = $conexion->prepare("SELECT nombre, descripcion, multirespuesta FROM encuestas WHERE idEncuesta='".$idEncuesta."'");
  $query->execute();
  if($encuestas = $query -> fetch()){
    $nombre = $encuestas['nombre'];
    $descripcion = $encuestas['descripcion'];
    $multirespuesta = $encuestas['multirespuesta'] == 1;
    echo "<h1>$nombre</h1>";
    if (existeYnoEstaVacio($descripcion)){
      echo "<h3>$descripcion</h3>";
    }
    $query = $conexion->prepare("SELECT idOpcion, nombre FROM opcionesEncuestas WHERE idEncuesta='".$idEncuesta."'");
    $query->execute();
    ?>
    <form action="../php/votarEncuestas.php" method="post">
    <?php
    while($respuestas = $query -> fetch()){
      if($multirespuesta){
      //multi
      ?>
      <input type="checkbox" name="respuestas" value="<?php echo $respuestas['idOpcion']; ?>"><?php echo $respuestas['nombre']; ?></input><br>
      <?php
      }else{
      //no multi
      ?>
      <input type="radio" name="respuestas" value="<?php echo $respuestas['idOpcion']; ?>"><?php echo $respuestas['nombre']; ?></input><br>
      <?php
      }
    }
    ?>
    <input type="submit" value="Enviar">
  </form>
    <?php
  }else{
    $_SESSION['mensaje'][] = [0, "No se ha posido obtener la id de la encuesta."];
  }
   ?>
</body>
</html>

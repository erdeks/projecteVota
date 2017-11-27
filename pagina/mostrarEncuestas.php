<?php
  require "../php/inicializar.php";
  $conexion = abrirConexion();
  $id = $_SESSION['usuario']['id'];
  $query = $conexion->prepare("SELECT idEncuesta, nombre, descripcion FROM encuestas WHERE idUsuario='".$id."'");
  $query->execute();

  echo "<ul>";
  while($encuestas = $query -> fetch()){
    $link = "https://".$_SERVER['SERVER_NAME']."/projecteVota/pagina/votarEncuestas.php?idEncuesta=".$encuestas["idEncuesta"];
    echo "<li><a href='$link'>".$encuestas["nombre"]."</li>";

  }
  echo "</ul>";
?>

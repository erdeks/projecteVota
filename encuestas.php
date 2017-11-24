<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <?php
    require "php/conexionBBDD.php";
    $pdo = abrirConexion();
    $sql = "SELECT nombre FROM encuestas";
    $query = $pdo -> prepare($sql);
    $query -> execute();

    $sql = "SELECT nombre FROM opcionesEncuestas";
    $query2 =$pdo ->prepare($sql);
    $query2 -> execute();
    cerrarConexion($pdo);

  ?>
  <form action="encuestas.php" method="post">
    <input type="text" name="encuesta" placeholder="Introduce el nombre de la encuesta" required><br>
    
    <input type="submit" value="Enviar">
  </form>
</body>
</html>

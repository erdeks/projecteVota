<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <?php
  try {
        $hostname = "localhost";
        $dbname = "projecteVota";
        $username = "root";
        $pw = "root";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
    }catch (PDOException $e){
          echo "Failed to get DB handle: ".$e->getMessage()."\n";
          exit;
    }

    $sql = "SELECT nombre FROM encuestas";
    $query = $pdo -> prepare($sql);
    $query -> execute();

    $sql = "SELECT nombre FROM opcionesEncuestas";
    $query2 =$pdo ->prepare($sql);
    $query2 -> execute();

  ?>
  <form action="encuestas.php" method="post">
    <select name="pregunta">
      <option value="Elige una Encuesta" selected="selected">Elige una Encuesta</option>
      <?php while( $encuesta = $query->fetch() ){
        echo "<option value='".$encuesta['nombre']."'>".$registre['nombre']."</option>";
      }?>
    </select><br><br>
    <select name="respuesta1">
      <option value="Elige una Opcion" selected="selected">Elige una Opcion</option>
      <?php while( $respuesta = $query->fetch() ){
        echo "<option value='".$respuesta['nombre']."'>".$respuesta['nombre']."</option>";
      }?>
    </select><br><br>
    <select name="respuesta2">
      <option value="Elige una Opcion" selected="selected">Elige una Opcion</option>
      <?php while( $respuesta = $query->fetch() ){
        echo "<option value='".$respuesta['nombre']."'>".$respuesta['nombre']."</option>";
      }?>
    </select><br><br>
    <select name="respuesta3">
      <option value="Elige una Opcion" selected="selected">Elige una Opcion</option>
      <?php while( $respuesta = $query->fetch() ){
        echo "<option value='".$respuesta['nombre']."'>".$respuesta['nombre']."</option>";
      }?>
    </select><br><br>
    <select name="respuesta4">
      <option value="Elige una Opcion" selected="selected">Elige una Opcion</option>
      <?php while( $respuesta = $query->fetch() ){
        echo "<option value='".$respuesta['nombre']."'>".$respuesta['nombre']."</option>";
      }?>
    </select><br><br>
    <input type="submit" value="Enviar">
  </form>
</body>
</html>

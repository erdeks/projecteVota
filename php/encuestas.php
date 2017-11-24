<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['pregunta']) &&
  existeYnoEstaVacio($_POST['diaInicio']) && existeYnoEstaVacio($_POST['mesInicio']) &&
  existeYnoEstaVacio($_POST['anyInicio']) && existeYnoEstaVacio($_POST['diaFin']) &&
  existeYnoEstaVacio($_POST['mesFin']) && existeYnoEstaVacio($_POST['anyFin']) &&
  existeYnoEstaVacio($_POST['res1']) && existeYnoEstaVacio($_POST['res2'])){
    require "conexionBBDD.php";
    $conexion = abrirConexion();

    $id = 1;
    $pregunta = $_POST['pregunta'];
    $diaInicio = $_POST['diaInicio'];
    $mesInicio = $_POST['mesInicio'];
    $anyInicio = $_POST['anyInicio'];
    $diaFin = $_POST['diaFin'];
    $mesFin = $_POST['mesFin'];
    $anyFin = $_POST['anyFin'];
    $query = $conexion->prepare ("INSERT INTO encuestas (idUsuario, nombre, inicio, fin) VALUES ($id, '$pregunta', '$anyInicio-$mesInicio-$diaInicio', '$anyFin-$mesFin-$diaFin')");
    $query->execute();
    $last_id = $conexion->lastInsertId();
    $num = 1;
    //echo "INSERT INTO 'encuestas' ('idUsuario', 'nombre', 'inicio', 'fin') VALUES ($id, '$pregunta', '$anyInicio-$mesInicio-$diaInicio', '$anyFin-$mesFin-$diaFin')";
    $respuestas = array();
    while (isset($_POST['res'.$num])){
      $respuestas[]= $_POST['res'.$num];
      $num++;
    }

    foreach ($respuestas as $key => $value) {
      $query = $conexion->prepare ("INSERT INTO opcionesEncuestas (idEncuesta, nombre) VALUES ($last_id, '$value')");
      $query->execute();
    }
    cerrarConexion($conexion);
    header('Location: ../pagina/encuestas.php?success=true');
  }
  function existeYnoEstaVacio($variable){
		return (isset($variable) && $variable != "");
	}
?>

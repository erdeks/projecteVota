<?php
  require "inicializar.php";
  if($_SERVER['REQUEST_METHOD'] == 'POST' && existeYnoEstaVacio($_POST['pregunta']) &&
  existeYnoEstaVacio($_POST['diaInicio']) && existeYnoEstaVacio($_POST['mesInicio']) &&
  existeYnoEstaVacio($_POST['anyInicio']) && existeYnoEstaVacio($_POST['horaInicio']) &&
  existeYnoEstaVacio($_POST['diaFin']) && existeYnoEstaVacio($_POST['mesFin']) &&
  existeYnoEstaVacio($_POST['anyFin']) && existeYnoEstaVacio($_POST['horaFin']) &&
  existeYnoEstaVacio($_POST['res1']) && existeYnoEstaVacio($_POST['res2']) &&
  existeYnoEstaVacio($_POST['multirespuesta']) &&existeYnoEstaVacio($_SESSION['usuario'])){
    $conexion = abrirConexion();

    $idUsuario = $_SESSION['usuario']['id'];
    $pregunta = $_POST['pregunta'];
    $multirespuesta = strcmp($_POST['multirespuesta'], "si") === 0 ? 1 : 0;
    $diaInicio = $_POST['diaInicio'];
    $mesInicio = $_POST['mesInicio'];
    $anyInicio = $_POST['anyInicio'];
    $horaInicio = $_POST['horaInicio'];
    $diaFin = $_POST['diaFin'];
    $mesFin = $_POST['mesFin'];
    $anyFin = $_POST['anyFin'];
    $horaFin = $_POST['horaFin'];
    $headerDescripcion = "";
    $bodyDescripcion = "";
    if(existeYnoEstaVacio($_POST['descripcion'])){
      $headerDescripcion = ", descripcion";
      $bodyDescripcion = ", '".$_POST['descripcion']."'";
    }

    $query = $conexion->prepare ("INSERT INTO encuestas (idUsuario, nombre, multirespuesta, inicio, fin$headerDescripcion) VALUES ($idUsuario, '$pregunta', $multirespuesta, '$anyInicio-$mesInicio-$diaInicio $horaInicio:00:00', '$anyFin-$mesFin-$diaFin $horaFin:00:00'$bodyDescripcion);");

    $error = false;
    if($query->execute()){
      $idEncuesta = $conexion->lastInsertId();
      if(!is_null($idEncuesta) && $idEncuesta > 0){
        $num = 1;

        $respuestas = array();
        while (isset($_POST['res'.$num])){
          $respuestas[]= $_POST['res'.$num];
          $num++;
        }

        foreach ($respuestas as $key => $value) {
          $query = $conexion->prepare ("INSERT INTO opcionesEncuestas (idEncuesta, nombre) VALUES ($idEncuesta, '$value')");
          if(!$query->execute()){
            $_SESSION['mensaje'][] = [0, "No se ha podido crear la pregunta: $value."];
            $error = true;
          }
        }
      }else{
        $_SESSION['mensaje'][] = [0, "No se ha podido obtener el id de la encuesta: $pregunta."];
        $error = true;
      }
    }else{
      $_SESSION['mensaje'][] = [0, "No se ha podido crear la encuesta: $pregunta."];
      $error = true;
    }

    cerrarConexion($conexion);
    if($error){
      header('Location: ../pagina/crearEncuesta.php');
    }else{
      $_SESSION['mensaje'][] = [1, "Se ha creado la encuesta correctamente."];
      header("Location: ../pagina/verInfoEncuesta.php?idEncuesta=$idEncuesta");
    }

  }else{
    $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
    irAIndex();
  }
  function irAIndex(){
    header("Location: ../index.php");
  }
?>

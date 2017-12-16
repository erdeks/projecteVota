<?php
require "inicializar.php";

if(existeYnoEstaVacio($_SESSION['usuario'])){
  if(existeYnoEstaVacio($_POST['respuestas']) && is_array($_POST['respuestas'])){
    //comprobar si a votado si lo ha hecho actulizarlo y sino INSERT tener en cuenta multioption
    $conexion = abrirConexion();
    $idUsuario = $_SESSION['usuario']['id'];
    $password = $_SESSION['usuario']['password'];
    $respuestas = $_POST['respuestas'];

    $idEncuesta = getIdEncuestaPorIdOpcion($conexion, $respuestas[0]);
    if(!is_null($idEncuesta)){
      $estadoEliminarVotos = true;
      if(haVotado($conexion, $idUsuario, $idEncuesta, $_SESSION['usuario']['password'])){
        $estadoEliminarVotos = eliminarVotos($conexion, $idEncuesta, $idUsuario, $password);
      }
      if($estadoEliminarVotos){
        $error = false;
        foreach ($respuestas as $key => $idOpcion) {
          if(is_null(insertarVoto($conexion, $idOpcion, $idUsuario, $password))){
          	eliminarVotos($conexion, $idEncuesta, $idUsuario, $password);
            $error = true;
            break;
          }
        }
        if($error){
          $_SESSION['mensaje'][] = [0, "No se ha podido guardar el voto."];
        }else{
          $_SESSION['mensaje'][] = [1, "Voto realizado."];
        }
      }else{
        $_SESSION['mensaje'][] = [0, "No se ha podido eliminar el voto existente."];
      }
    }else{
      $_SESSION['mensaje'][] = [0, "No se ha podido obtener el id de la encuesta."];
    }
    cerrarConexion($conexion);
    irVotarEncuesta($idEncuesta);
  }else{
    $_SESSION['mensaje'][] = [0, "Tienes que seleccionar como minimo una opcion."];
    irVotarEncuesta(getIdEncuestaDeUrlAnteior());
  }
}else{
  $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
  irAIndex();
}

function insertarVoto(&$conexion, $idOpcion, $idUsuario, $password){
  $hash='';
  do{
    $hash = generateRandomString();
  }while(comprobarHash($conexion, $hash));

  $query = $conexion->prepare("INSERT INTO votosEncuestas (hash, idOpcion) VALUES ('$hash', $idOpcion);");
  if($query->execute()){
    $query = $conexion->prepare("INSERT INTO votosEncuestasEncriptado (idUsuario, hashEncriptado) VALUES ($idUsuario, AES_ENCRYPT('$hash', '$password'));");
    if($query->execute()) return $conexion->lastInsertId();
    else return null;
  } else return null;
}

function eliminarVotos(&$conexion, $idEncuesta, $idUsuario, $password){
  $query = $conexion->prepare("DELETE v.*, ve.* FROM votosEncuestas v, votosEncuestasEncriptado ve, opcionesEncuestas o WHERE v.hash = AES_DECRYPT(ve.hashEncriptado, '$password') AND v.idOpcion = o.idOpcion AND o.idEncuesta = $idEncuesta AND ve.idUsuario = $idUsuario;");
  if($query->execute()) return true;
  else return false;
}
function getIdEncuestaPorIdOpcion(&$conexion, $idOpcion){
  $query = $conexion->prepare("SELECT idEncuesta FROM opcionesEncuestas WHERE idOpcion = $idOpcion;");
  $query->execute();
  if($rows=$query->fetch()) return $rows['idEncuesta'];
  else return null;
}

function irAIndex(){
  header("Location: ../index.php");
}
function irVotarEncuesta($idEncuesta){
  header("Location: ../pagina/votarEncuesta.php?idEncuesta=$idEncuesta");
}
function getIdEncuestaDeUrlAnteior(){
  $buscar = "idEncuesta=";
  $finGet = "&";

  $gets = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
  $inicio = strpos($gets, $buscar) + strlen($buscar);
  $fin = strpos($gets, $finGet);

  if($fin !== false) return substr($gets, $inicio, $fin - $inicio);
  else return substr($gets, $inicio);
}
function comprobarHash(&$conexion, $hash){
  $query = $conexion->prepare("SELECT hash FROM votosEncuestas WHERE hash = $hash;");
  $query->execute();
  $rows=$query->rowCount();
  if($rows == 0) return false;
  else return true;
}
?>

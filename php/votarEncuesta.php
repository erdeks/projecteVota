<?php
require "inicializar.php";

if(existeYnoEstaVacio($_SESSION['usuario'])){
  if(existeYnoEstaVacio($_POST['respuestas']) && is_array($_POST['respuestas'])){
    //comprobar si a votado si lo ha hecho actulizarlo y sino INSERT tener en cuenta multioption
    $conexion = abrirConexion();
    $id = $_SESSION['usuario']['id'];
    $idOpcion = $_POST['respuestas'];

    $idEncuesta = getIdEncuestaPorIdOpcion($conexion, $idOpcion[0]);
    if(!is_null($idEncuesta)){
      $estadoEliminarVotos = true;
      if(usuarioAVotado($conexion, $idEncuesta, $id)){
        $estadoEliminarVotos = eliminarVotos($conexion,$idEncuesta,$id);
      }
      if($estadoEliminarVotos){
        $error = false;
        foreach ($idOpcion as $key => $value) {
          if(is_null(insertarVoto($conexion, $value, $id) && !$error)){
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
    irVotarEncuesta(getIdEncuestaDeurlAnteior());
  }
}else{
  $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
  irAIndex();
}

function insertarVoto(&$conexion, $idOpcion, $idUsuario){
  $query = $conexion->prepare("INSERT INTO votosEncuestas (idOpcion, idUsuario) VALUES ($idOpcion, $idUsuario);");
  if($query->execute()) return $conexion->lastInsertId();
  else return null;
}

function eliminarVotos(&$conexion, $idEncuesta, $idUsuario){
  $query = $conexion->prepare("DELETE v.* FROM votosEncuestas v JOIN opcionesEncuestas o USING(idOpcion) WHERE o.idEncuesta = $idEncuesta AND v.idUsuario=$idUsuario;");
  if($query->execute()) return true;
  else return false;
}

function usuarioAVotado(&$conexion, $idEncuesta, $idUsuario){
  $query = $conexion->prepare("SELECT idEncuesta FROM opcionesEncuestas JOIN votosEncuestas USING (idOpcion) WHERE idEncuesta = $idEncuesta AND idUsuario = $idUsuario;");
  $query->execute();
  $rows=$query->rowCount();
  if($rows == 0) return false;
  else return true;
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
function getIdEncuestaDeurlAnteior(){
  $buscar = "idEncuesta=";
  $finGet = "&";

  $gets = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
  $inicio = strpos($gets, $buscar) + strlen($buscar);
  $fin = strpos($gets, $finGet);

  if($fin !== false) return substr($gets, $inicio, $fin - $inicio);
  else return substr($gets, $inicio);
}
?>

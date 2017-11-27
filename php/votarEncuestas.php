<?php
require "inicializar.php";
if(existeYnoEstaVacio($_POST['respuestas']) && existeYnoEstaVacio($_SESSION['usuario'])){
  //comprobar si a votado si lo ha hecho actulizarlo y sino INSERT tener en cuenta multioption
  $conexion = abrirConexion();
  $id = $_SESSION['usuario']['id'];
  $idOpcion = $_POST['respuestas'];
  $idPrimeraOpcion;

  if(is_array($idOpcion)) $idPrimeraOpcion=$idOpcion[0];
  else $idPrimeraOpcion=$idOpcion;

  $idEncuesta = getIdEncuestaPorIdOpcion($conexion, $idPrimeraOpcion);
  if(!is_null($idEncuesta)){
    $estadoEliminarVotos = true;
    if(usuarioAVotado($conexion, $idEncuesta, $id)){
      $estadoEliminarVotos = eliminarVotos($conexion,$idEncuesta,$id);
    }
    if($estadoEliminarVotos){
      if(is_array($idOpcion)){
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
        if(is_null(insertarVoto($conexion, $idOpcion, $id))){
          $_SESSION['mensaje'][] = [0, "No se ha podido guardar el voto."];
        }else{
          $_SESSION['mensaje'][] = [1, "Voto realizado."];
        }
      }

    }else{
      $_SESSION['mensaje'][] = [0, "No se ha podido eliminar el voto existente."];
    }
  }else{
    $_SESSION['mensaje'][] = [0, "No se ha podido obtener el id de la encuesta."];
  }
}else{
  $_SESSION['mensaje'][] = [0, "Los campos no pueden estar vacios."];
}
getMensajes();
function insertarVoto(&$conexion, $idOpcion, $idUsuario){
  $query = $conexion->prepare("INSERT INTO votosEncuestas (idOpcion, idUsuario) VALUES ($idOpcion, $idUsuario);");
  if($query->execute()) return $conexion->lastInsertId();
  else return null;
}

function eliminarVotos(&$conexion, $idEncuesta, $idUsuario){
  $query = $conexion->prepare("DELETE v.* FROM votosEncuestas v JOIN opcionesEncuestas o WHERE o.idEncuesta = $idEncuesta AND v.idUsuario=$idUsuario;");
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

?>

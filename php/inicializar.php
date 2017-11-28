<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    die();
}
session_start();
if(!isset($_SESSION['mensaje'])){
	$_SESSION['mensaje'] = [];
}

require "conexionBBDD.php";
require "funcionesGenerales.php";
?>

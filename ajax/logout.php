<?php 

include '../config.php';

session_start();

$_SESSION["idUsuario"] = NULL;

header('Location: ../index.php');
 
?>
<?php 

include '../config.php';

session_start();

$u = $_GET['u'];

$_SESSION["idUsuario"] = $u;

echo "1";
 
?>

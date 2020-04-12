<?php 

include '../config.php';

session_start();

$u = $_GET['u'];

$sql = "SELECT id FROM persona WHERE idUsuario=".$u;

$u = mysqli_query($conexion,$sql)->fetch_row()[0];

$_SESSION["idUsuario"] = $u;

echo "1";

?>

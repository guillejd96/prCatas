<?php 

	include '../config.php';

	session_start();

	$u = $_GET['u'];

	$sql = "SELECT id FROM persona WHERE idUsuario=".$u;

	$id = mysqli_query($conexion,$sql)->fetch_row()[0];

	$_SESSION["idUsuario"] = $id;

	echo "1";

?>

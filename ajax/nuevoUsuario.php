<?php 

	include '../config.php';

	$usuario = $_GET['u'];
	$nombre = $_GET['n'];
	$password = $_GET['p'];

	$sql = "INSERT INTO persona(usuario,nombre,password) VALUES ('".$usuario."','".$nombre."','".$password."');";

	if(mysqli_query($conexion,$sql)){
		echo "1";
	} else {
		echo "0";
	}
 ?>
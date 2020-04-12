<?php 

	include '../config.php';

	$usuario = $_GET['u'];
	$nombre = $_GET['n'];
	$password = $_GET['p'];

	$sqlUsuario = "INSERT INTO usuario(usuario,password) VALUES ('".$usuario."','".$password."');";
	if(mysqli_query($conexion,$sqlUsuario)){
		$sqlIDUsuario = "SELECT id FROM usuario WHERE usuario = '".$usuario."' AND password = '".$password."';";
		$id = mysqli_query($conexion,$sqlIDUsuario)->fetch_row()[0];
		$sql = "INSERT INTO persona(nombre,idUsuario) VALUES ('".$nombre."',".$id.");";
		if(mysqli_query($conexion,$sql)){
			echo "1";
		} else {
			echo "0";
		}
	}else {
		echo "-1";
	}
 ?>
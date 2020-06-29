<?php 

	include '../config.php';

	$usuario = $_POST['usuario'];
	$nombre = $_POST['nombre'];
	$password = $_POST['contrasenya'];

	$hashP = $hashP = hash("sha256", $password);

	$stmt = mysqli_prepare($conexion,"INSERT INTO usuario(usuario,password) VALUES (? , ?);");

	mysqli_stmt_bind_param($stmt,"ss",$usuario,$hashP);

	mysqli_stmt_execute($stmt);

	if(mysqli_stmt_affected_rows($stmt)>0){
		$sqlIDUsuario = "SELECT id FROM usuario WHERE password = '".$hashP."';";
		$id = mysqli_query($conexion,$sqlIDUsuario)->fetch_row()[0];

		$stmt = mysqli_prepare($conexion,"INSERT INTO persona(nombre,idUsuario) VALUES (?,?);");

		mysqli_stmt_bind_param($stmt,"si",$nombre,$id);

		mysqli_stmt_execute($stmt);

		if(mysqli_stmt_affected_rows($stmt)>0){
			echo "1";
		}
		else {
			echo "0";
		}
	}
	else{
		echo "-1";
	}
 ?>
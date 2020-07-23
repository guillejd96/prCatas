<?php 

	include '../config.php';

	session_start();

	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$id = $_POST["id"];

	$stmt = mysqli_prepare($conexion,"DELETE FROM opinion WHERE idCerveza = ?");

	mysqli_stmt_bind_param($stmt,"i",$id);

	mysqli_stmt_execute($stmt);

	if(mysqli_stmt_affected_rows($stmt)>0){
		$stmt2 = mysqli_prepare($conexion,"DELETE FROM cerveza WHERE id = ?");

		mysqli_stmt_bind_param($stmt2,"i",$id);

		mysqli_stmt_execute($stmt2);

		if(mysqli_stmt_affected_rows($stmt2)>0){
			echo "1";
		} else {
			echo "0";
		}
	} else{
		echo "0";
	}
?>
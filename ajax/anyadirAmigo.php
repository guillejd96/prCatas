<?php 

	include '../config.php';

	session_start();

	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$id = $_POST['id'];

	$stmt = mysqli_prepare($conexion,"INSERT INTO amigos(idUsuario1,idUsuario2) VALUES (?,?)");

	mysqli_stmt_bind_param($stmt,"ii",$idUsuario,$id);

	mysqli_stmt_execute($stmt);

	if(mysqli_stmt_affected_rows($stmt)>0){
		echo "1";
	} else {
		echo "0";
	}

 ?>
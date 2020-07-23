<?php 

	include '../config.php';

	session_start();

	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$id = $_POST['id'];

	$stmt = mysqli_prepare($conexion,"DELETE FROM amigos WHERE idUsuario1 = ? AND idUsuario2 = ?");

	mysqli_stmt_bind_param($stmt,"ii",$id,$idUsuario);

	mysqli_stmt_execute($stmt);

	if(mysqli_stmt_affected_rows($stmt)>0){
		echo "1";
	}else {
		echo "-1";
	}

 ?>
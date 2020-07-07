<?php 

	include '../config.php';

	session_start();

	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$stmt = mysqli_prepare($conexion,"SELECT idUsuario2 FROM amigos WHERE idUsuario1 = ?");

	mysqli_stmt_bind_param($stmt,"i",$idUsuario);

	mysqli_stmt_execute($stmt);

	$res = mysqli_stmt_get_result($stmt);

	if(mysqli_num_rows($res)>0){
		$return = "";
		while($row = mysqli_fetch_array($res)){
			$id = $row[0];
			$return = $return.$id.";";
		}
		echo $return;
	} else{
		echo "null";
	}
?>

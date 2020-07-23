<?php 

	include '../config.php';

	session_start();

	$user = $_POST["user"];
	$pass = $_POST["pass"];

	$hashP = hash("sha256",$pass);

	$stmt = mysqli_prepare($conexion,"SELECT id FROM usuario WHERE usuario = ? AND password = ?");

	mysqli_stmt_bind_param($stmt,"ss",$user,$hashP);

	mysqli_stmt_execute($stmt);

	$res = mysqli_stmt_get_result($stmt);

	if(mysqli_num_rows($res)>0){
		$idUsuario = $res->fetch_row()[0];
		$_SESSION["idUsuario"] = $idUsuario;
		echo "1";
	}
	else{
		echo "0";
	}
?>

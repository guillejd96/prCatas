<?php 

	include '../config.php';

	$u = $_POST['u'];

	$stmt = mysqli_prepare($conexion,"SELECT id FROM usuario WHERE usuario= ?;");

	mysqli_bind_param($stmt,"i",$u);

	mysqli_stmt_execute($stmt);

	$res = mysqli_stmt_get_result($stmt);

	if(mysqli_num_rows($res)>0){
		echo "1";
	}
	else{
		echo "0";
	}
?>

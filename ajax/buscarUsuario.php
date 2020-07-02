<?php 

	include '../config.php';

	session_start();

	$usuario = $_POST['usuario'];

	$stmt = mysqli_prepare($conexion,"SELECT * FROM usuario WHERE usuario LIKE ?");

	$sql = $usuario."%";

	mysqli_stmt_bind_param($stmt,"s",$sql);

	mysqli_stmt_execute($stmt);

	$res = mysqli_stmt_get_result($stmt);

	if(mysqli_num_rows($res)>0){
		$return = "";
		while($row = mysqli_fetch_array($res)){
			$id = $row[0];
			$user = $row[1];
			$nombre = mysqli_query($conexion,"SELECT nombre FROM persona WHERE idUsuario=".$id)->fetch_row()[0];
			$return = $return.$id.":".$user.":".$nombre.",";
		}
		echo $return;
	} else{
		echo "null";
	}
?>

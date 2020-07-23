<?php 

include '../config.php';

$nombre = $_GET['n'];
$id = $_GET['c'];

$select = "SELECT id FROM cerveza WHERE nombre='".$nombre."' AND idCata=".$id.";";
$res = mysqli_query($conexion,$select);
if($res->num_rows==0){
	$sql = "INSERT INTO cerveza (nombre,idCata) VALUES ('".$nombre."',".$id.");";
	if(mysqli_query($conexion,$sql)){
		$sql = "SELECT id FROM cerveza WHERE nombre='".$nombre."' AND idCata=".$id.";";
		$id = mysqli_query($conexion,$sql)->fetch_row()[0];
		echo $id;
	}else {
		echo "0";
	}
} else {
	$id = $res->fetch_row()[0];
	echo $id;
}

 ?>
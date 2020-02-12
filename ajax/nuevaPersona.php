<?php 

include '../config.php';

$nombre = $_GET['nombre'];
$id = $_GET['cata'];

$sql = "INSERT INTO persona (nombre,idCata) VALUES ('".$nombre."',".$id.");";
if(mysqli_query($conexion,$sql)){
	$sql = "SELECT id FROM persona WHERE nombre='".$nombre."' AND idCata=".$id.";";
	$id = mysqli_query($conexion,$sql)->fetch_row()[0];
	echo $id;
}else {
	echo "0";
}

 ?>
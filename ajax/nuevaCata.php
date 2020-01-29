<?php 

include '../config.php';

$nombre = $_GET['nombre'];
$fecha = $_GET['fecha'];

$sql = "INSERT INTO cata (nombre,fecha) VALUES ('".$nombre."','".$fecha."'));";
if(mysqli_query($conexion,$sql)){
	echo "1";
}else {
	echo "0";
}

 ?>
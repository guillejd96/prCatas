<?php 

include '../config.php';

$nombre = $_GET['cata'];
$fecha = date("Y-m-d",strtotime($_GET['fecha']));

$sql = "INSERT INTO cata (nombre,fecha) VALUES ('".$nombre."',CAST('".$fecha."' AS DATE));";
if(mysqli_query($conexion,$sql)){
	$sql = "SELECT id FROM cata WHERE nombre='".$nombre."' AND fecha=CAST('".$fecha."' AS DATE);";
	$id = mysqli_query($conexion,$sql)->fetch_row()[0];
	echo $id;
}else {
	echo "0";
}

 ?>
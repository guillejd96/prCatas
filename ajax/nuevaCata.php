<?php 

include '../config.php';

$nombre = $_GET['c'];
$idPersona = $_GET['p'];
$fecha = date("Y-m-d",strtotime($_GET['f']));

$sql = "INSERT INTO cata (nombre,fecha) VALUES ('".$nombre."',CAST('".$fecha."' AS DATE));";
if(mysqli_query($conexion,$sql)){
	$sql = "SELECT id FROM cata WHERE nombre='".$nombre."' AND fecha=CAST('".$fecha."' AS DATE);";
	$id = mysqli_query($conexion,$sql)->fetch_row()[0];

	$sqlPersonaCata = "INSERT INTO persona_cata(idPersona,idCata) VALUES (".$idPersona.",".$id.")";
	if(mysqli_query($conexion,$sqlPersonaCata)){
		echo $id;
	}else {
		echo "-1";
	}
}else {
	echo "0";
}

 ?>
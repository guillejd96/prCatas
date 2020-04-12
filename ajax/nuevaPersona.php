<?php 

include '../config.php';

$nombre = $_GET['nombre'];
$id = $_GET['cata'];

$sql = "INSERT INTO persona (nombre) VALUES ('".$nombre."');";
if(mysqli_query($conexion,$sql)){
	$sql = "SELECT id FROM persona WHERE nombre='".$nombre."' ORDER BY id DESC;";
	$idPersona = mysqli_query($conexion,$sql)->fetch_row()[0];

	$sqlPersonaCata = "INSERT INTO persona_cata(idPersona,idCata) VALUES (".$idPersona.",".$id.")";
	if(mysqli_query($conexion,$sqlPersonaCata)){
		echo $idPersona;
	}else {
		echo "0";
	}
}else {
	echo "0";
}

 ?>
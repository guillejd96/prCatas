<?php 

	include '../config.php';

	$idUsuario = $_GET['n'];
	$idCata = $_GET['c'];

	$idPersona = mysqli_query($conexion,"SELECT id FROM persona WHERE idUsuario=".$idUsuario)->fetch_row()[0];

	$sql = "INSERT INTO persona_cata(idPersona,idCata) VALUES (".$idPersona.",".$idCata.")";
	if(mysqli_query($conexion,$sql)){
		echo "1";
	} else {
		echo "0";
}
 ?>

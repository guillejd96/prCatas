<?php 

	include '../config.php';

	$idCata = $_GET['id'];

	$sqlCervezas = "SELECT id FROM cerveza WHERE idCata=".$idCata;
	$resCervezas = mysqli_query($conexion,$sqlCervezas);

	while($c = mysqli_fetch_array($resCervezas)){
		$idCerveza = $c[0];

		$sqlBorrarOpiniones = "DELETE FROM opinion WHERE idCerveza=".$idCerveza;
		mysqli_query($conexion,$sqlBorrarOpiniones);

		$sqlBorrarCerveza = "DELETE FROM cerveza WHERE id=".$idCerveza;
		mysqli_query($conexion,$sqlBorrarCerveza);
	}

	$sqlPersonaCata = "SELECT idPersona FROM persona_cata WHERE idCata=".$idCata;
	$resPersonaCata = mysqli_query($conexion,$sqlPersonaCata);

	while ($p = mysqli_fetch_array($resPersonaCata)) {
		$idPersona = $p[0];

		$sqlBorrarPersonaCata = "DELETE FROM persona_cata WHERE idPersona=".$idPersona." AND idCata=".$idCata.";";
		mysqli_query($conexion,$sqlBorrarPersonaCata);

		$sqlBorrarPersona = "DELETE FROM persona WHERE id=".$idPersona." AND ISNULL(idUsuario);";
		mysqli_query($conexion,$sqlBorrarPersona);
	}

	$sqlBorrarCata = "DELETE FROM cata WHERE id=".$idCata;
	mysqli_query($conexion,$sqlBorrarCata);

	echo "1";
 ?>
<?php 

	include '../config.php';

	session_start();

	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$idCata = $_POST['id'];

	$resCervezas = mysqli_query($conexion,"SELECT id FROM cerveza WHERE idCata=".$idCata);

	$error=false;

	while($row = mysqli_fetch_array($resCervezas)){
		$idCerveza = $row[0];

		$res = mysqli_query($conexion,"SELECT AVG(aroma),AVG(apariencia),AVG(sabor),AVG(cuerpo),AVG(botellin) FROM opinion WHERE idCerveza=".$idCerveza)->fetch_row();

		$mediaAroma = $res[0];
		$mediaApariencia = $res[1];
		$mediaSabor = $res[2];
		$mediaCuerpo = $res[3];
		$mediaBotellin = $res[4];

		$sql = "INSERT INTO medias(aroma,apariencia,sabor,cuerpo,botellin,idCerveza) VALUES(".$mediaAroma.",".$mediaApariencia.",".$mediaSabor.",".$mediaCuerpo.",".$mediaBotellin.",".$idCerveza.")";
		if(!mysqli_query($conexion,$sql)){
			$error=true;
		}
	}

	if($error){
		echo "0";
	}else {
		echo "1";
	}

 ?>
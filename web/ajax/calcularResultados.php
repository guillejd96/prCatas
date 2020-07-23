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

		$resMedias = mysqli_query($conexion,"SELECT * FROM medias WHERE idCerveza=".$idCerveza);

		if(mysqli_num_rows($resMedias)>0){
			mysqli_query($conexion,"DELETE FROM medias WHERE idCerveza=".$idCerveza);
		}	

		$res = mysqli_query($conexion,"SELECT AVG(aroma),AVG(apariencia),AVG(sabor),AVG(cuerpo),AVG(botellin) FROM opinion WHERE idCerveza=".$idCerveza)->fetch_row();

		$mediaAroma = $res[0];
		$mediaApariencia = $res[1];
		$mediaSabor = $res[2];
		$mediaCuerpo = $res[3];
		$mediaBotellin = $res[4];

		$media = round(($mediaAroma+$mediaApariencia+$mediaSabor+$mediaCuerpo+$mediaBotellin)/5,2);

		$sql = "INSERT INTO medias(aroma,apariencia,sabor,cuerpo,botellin,media,idCerveza,idCata) VALUES(".$mediaAroma.",".$mediaApariencia.",".$mediaSabor.",".$mediaCuerpo.",".$mediaBotellin.",".$media.",".$idCerveza.",".$idCata.")";
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
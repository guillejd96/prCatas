<?php 

	include '../config.php';
	session_start();

	$idCata = $_POST['id'];

	$resPersonas = mysqli_query($conexion,"SELECT idPersona FROM persona_cata WHERE idCata=".$idCata);

	$result="";

	$nCervezas = mysqli_query($conexion,"SELECT COUNT(*) FROM cerveza WHERE idCata=".$idCata)->fetch_row()[0];

	if($nCervezas>0){
		while($p = mysqli_fetch_array($resPersonas)){
			$idPersona = $p[0];

			$nombrePersona = mysqli_query($conexion,"SELECT nombre FROM persona WHERE id=".$idPersona)->fetch_row()[0];

			$resCervezas = mysqli_query($conexion,"SELECT id FROM cerveza WHERE idCata=".$idCata);

			$difTotal=0;

			while($c = mysqli_fetch_array($resCervezas)){
				$idCerveza = $c[0];

				$mediaCuerpo = mysqli_query($conexion,"SELECT AVG(cuerpo) FROM opinion WHERE idCerveza=".$idCerveza)->fetch_row()[0];

				$resCuerpo = mysqli_query($conexion,"SELECT cuerpo FROM opinion WHERE idPersona=".$idPersona." AND idCerveza=".$idCerveza);

				if(mysqli_num_rows($resCuerpo)>0){
					$cuerpo = $resCuerpo->fetch_row()[0];
					$dif = $mediaCuerpo-$cuerpo;
					if($dif<0) $dif=$dif*(-1);
					$difTotal=$difTotal+$dif;
				}
			}
			$result=$result.$nombrePersona.",".round($difTotal,2).";";
		}
		$result=substr($result,0,-1);
	}
	echo $result;
 ?>
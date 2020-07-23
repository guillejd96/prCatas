<?php 

	include '../config.php';

	$persona = $_POST['idP'];
	$cerveza = $_POST['idC'];
	$aroma = $_POST['ar'];
	$apariencia = $_POST['ap'];
	$sabor = $_POST['s'];
	$cuerpo = $_POST['c'];
	$botellin = $_POST['b'];

	$res = mysqli_query($conexion,"SELECT * FROM opinion WHERE idPersona=".$persona." AND idCerveza=".$cerveza);
	if(mysqli_num_rows($res)>0){
		$sql = "UPDATE opinion SET apariencia=".$apariencia.", aroma=".$aroma.", sabor=".$sabor.", cuerpo=".$cuerpo.", botellin=".$botellin." WHERE idPersona=".$persona." AND idCerveza=".$cerveza;
		if(mysqli_query($conexion,$sql)){
			echo "1";
		}else {
			echo "0";
		}
	}else {
		$sql = "INSERT INTO opinion(idCerveza, idPersona, apariencia, aroma, sabor, cuerpo, botellin) VALUES (".$cerveza.",".$persona.",".$apariencia.",".$aroma.",".$sabor.",".$cuerpo.",".$botellin.");";
		if(mysqli_query($conexion,$sql)){
			echo "1";
		}else {
			echo "0";
		}
	}

?>
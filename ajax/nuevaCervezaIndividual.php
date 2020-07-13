<?php 

include '../config.php';
session_start();
if(!isset($_SESSION["idUsuario"])){
	header('Location: index.php');
}

$idUsuario = $_SESSION["idUsuario"];

$resPersona = mysqli_query($conexion,"SELECT * FROM persona WHERE idUsuario=".$idUsuario)->fetch_row();
$idPersona = $resPersona[0];

$nombre = $_POST['n'];
$aroma = $_POST['ar'];
$apariencia = $_POST['ap'];
$sabor = $_POST['s'];
$cuerpo = $_POST['c'];
$botellin = $_POST['b'];

$stmt = mysqli_prepare($conexion,"INSERT INTO cerveza(nombre) VALUES (?)");
mysqli_stmt_bind_param($stmt,"s",$nombre);
mysqli_stmt_execute($stmt);

if(mysqli_stmt_affected_rows($stmt)>0){
	$idCerveza = mysqli_query($conexion,"SELECT id FROM cerveza ORDER BY id DESC")->fetch_row()[0];
	$stmt2 = mysqli_prepare($conexion,"INSERT INTO opinion(apariencia,aroma,sabor,cuerpo,botellin,idPersona,idCerveza) VALUES (?,?,?,?,?,?,?)");
	mysqli_stmt_bind_param($stmt2,"iiiiiii",$apariencia,$aroma,$sabor,$cuerpo,$botellin,$idPersona,$idCerveza);
	mysqli_stmt_execute($stmt2);
	if(mysqli_stmt_affected_rows($stmt2)>0){
		echo "1";
	}else {
		echo mysqli_stmt_error($stmt2);
	}
} else {
	echo mysqli_stmt_error($stmt);
}

 ?>
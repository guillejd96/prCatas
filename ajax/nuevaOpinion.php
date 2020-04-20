<?php 

include '../config.php';

$persona = $_GET['p'];
$cerveza = $_GET['c'];
$aroma = $_GET['ar'];
$apariencia = $_GET['ap'];
$sabor = $_GET['s'];
$cuerpo = $_GET['cu'];
$botellin = $_GET['b'];

$sql = "INSERT INTO opinion(idCerveza, idPersona, apariencia, aroma, sabor, cuerpo, botellin) VALUES (".$cerveza.",".$persona.",".$apariencia.",".$aroma.",".$sabor.",".$cuerpo.",".$botellin.");";
if(mysqli_query($conexion,$sql)){
	echo "1";
}else {
	echo "0";
}
 ?>
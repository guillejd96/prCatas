<?php 
	include "config.php";
	$idCata = $_GET["id"];

	$sql = "SELECT nombre FROM cata WHERE id=".$idCata;
	$nombreCata = mysqli_query($conexion,$sql)->fetch_row()[0];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $nombreCata ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/init.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
	<h1><?php echo $nombreCata ?></h1>
</body>
</html>
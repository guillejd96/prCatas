<?php 
	include "config.php";
	$idCata = $_GET["id"];

	$sql = "SELECT * FROM cerveza WHERE id=".$idCata;
	$cerveza = mysqli_query($conexion,$sql)->fetch_row();
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title><?php echo $cerveza[1]; ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/init.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 </head>
 <body>
 	<h1>Información de <?php echo $cerveza[1]; ?></h1>
 </body>
 </html>
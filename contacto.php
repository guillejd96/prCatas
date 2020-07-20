<?php 

	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Contacto</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
				<h2 align="left" style="margin-left: 2%">Contacto: </h2><br><br>
		<table class="simple">
			<tr>
				<td><img src="images/COLOR_FONDOBLANCO_INFORMATICA.png" alt="Logo ETSI" height="200" width="600" border="1"></td>
				<td>
					<p>Trabajo de Fin de Grado para la Escuela Técnica Superior de Ingeniería Informática 2019/2020</p>
					<p>Grado en Ingeniería del Software</p>
					<p>Guillermo Jimena Domínguez</p>
					<p>guillejd96@gmail.com</p>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
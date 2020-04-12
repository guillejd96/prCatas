<?php 
	include "config.php";

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE idUsuario=".$idUsuario;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$idPersona = $resPersona[0];

	$sqlPersonaCata = "SELECT idCata FROM persona_cata WHERE idPersona = ".$idPersona;
	$resIDCatas = mysqli_query($conexion,$sqlPersonaCata);
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Catas</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 </head>
 <body>
 	<h1>Catas guardadas</h1><br>
 	<h3>Aquí se muestran un listado de las catas que has registrado</h3>
 	<?php if($resIDCatas->num_rows>0){
 		echo "<table>";
 		echo "<tr>";
 		echo "<th><p>ID</p></th>";
 		echo "<th><p>Nombre</p></th>";
 		echo "<th><p>Fecha</p></th>";
 		echo "<th><p>Personas</p></th>";
 		echo "<th><p>Cervezas</p></th>";
 		echo "</tr>";
		while ($idCata = mysqli_fetch_array($resIDCatas)) {
			$sqlCata = "SELECT * FROM cata WHERE id=".$idCata[0];
			$cata = mysqli_query($conexion,$sqlCata)->fetch_row();
			$resCervezas = mysqli_query($conexion,"SELECT COUNT(*) FROM cerveza WHERE idCata = ".$idCata[0]);
			$nCervezas = $resCervezas->fetch_row()[0];
			$resPersonas = mysqli_query($conexion,"SELECT COUNT(*) FROM persona WHERE idCata = ".$idCata[0]);
			$nPersonas = $resPersonas->fetch_row()[0];
			echo "<tr>";
			echo "<td><p><a href='info_cata.php?id=".$idCata."'>".$idCata."</a></p>";
			echo "<td><p>".$cata[1]."</p></td>";
			echo "<td><p>".$cata[2]."</p></td>";
			echo "<td><p>".$nCervezas."</p></td>";
			echo "<td><p>".$nPersonas."</p></td>";
			echo "</tr>";
		}
		echo "</table>";
 	} else { ?>
 		<table>
 			<tr>
 				<td><p>No has registrado ninguna cata</p></td>
 			</tr>
 			<tr>
 				<td><p>Para registrar tu primera cata pulsa <a href="nueva_cata.php">aquí</a></p></td>
 			</tr>
 		</table>
		
		
 	<?php } ?>
 	<br>
 	<button class="btn btn-link" onclick="location.href='user.php'">Volver</button>
 </body>
 </html>
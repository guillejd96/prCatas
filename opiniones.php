<?php 

	include 'config.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE idUsuario=".$idUsuario;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$idPersona = $resPersona[0];

	$idCata = $_GET['id'];

	$sqlCata = "SELECT * FROM cata WHERE id =".$idCata;
	$resCata = mysqli_query($conexion,$sqlCata)->fetch_row();

	$sqlPersonas = "SELECT idPersona FROM persona_cata WHERE idCata =".$idCata;
	$resPersonas = mysqli_query($conexion,$sqlPersonas);

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 	<title>Rellenar opiniones</title>
 </head>
 <body>
 	<h1>Rellenar opiniones de <?php echo $resCata[1]?></h1>
	
 	<?php 

 		while($persona_cata = mysqli_fetch_array($resPersonas)){
 			$sqlPersonas = "SELECT * FROM persona WHERE id=".$persona_cata[0];
 			$persona = mysqli_query($conexion,$sqlPersonas)->fetch_row();

 			$sqlCervezas = "SELECT * FROM cerveza WHERE idCata =".$idCata;
			$resCervezas = mysqli_query($conexion,$sqlCervezas);

 			echo "<table>";
 			echo "<tr>";
 			echo "<th><p>".$persona[1]."</p></th>";
 			echo "<th><p>Apariencia</p></th>";
 			echo "<th><p>Aroma</p></th>";
 			echo "<th><p>Sabor</p></th>";
 			echo "<th><p>Cuerpo</p></th>";
 			echo "<th><p>Botellín</p></th>";
 			echo "</tr>";
 			while($cerveza = mysqli_fetch_array($resCervezas)){
 				echo "<tr>";
 				echo "<td><p>".$cerveza[1]."</p></td>";
 				echo "<td><input type='number' id='apariencia' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='aroma' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='sabor' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='cuerpo' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='botellin' size='1' min='0' max='10'></td>";
 				echo "</tr>";
 			}
 			echo "</table>";
 		}


 	 ?>
	<table class="no_background">
		<tr>
			<td><button id="guardar" class="btn btn-dark">Guardar</button></td>
			<td><button class="btn btn-link">Volver</button></td>
		</tr>
	</table>
 	<br>
 </body>
 </html>
<?php 
	include "config.php";
	$idCata = $_GET["id"];

	$sql = "SELECT nombre FROM cata WHERE id=".$idCata;
	$nombreCata = mysqli_query($conexion,$sql)->fetch_row()[0];

	$sql = "SELECT id,nombre FROM persona WHERE idCata =".$idCata;
	$resPersonas = mysqli_query($conexion,$sql);

	$sql = "SELECT id,nombre FROM cerveza WHERE idCata =".$idCata;
	$resCerveza = mysqli_query($conexion,$sql);
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
	<h1><?php echo $nombreCata ?></h1><br><br>
	<table>
		<tr>
			<td>
				<table style='background-color: #FFA900;' border="1">
					<tr>
						<th>
							<p>Personas</p>
						</th>
					</tr>
					<?php 
						while($row = mysqli_fetch_array($resPersonas)){
							echo "<tr><td scope='row' width='7rem'><a href='persona.php?id=".$row[0]."'><p>".$row[1]."</p></td></tr>";
						}
				 	?>
				</table>
			</td>
			<td></td>
			<td>
				<table style='background-color: #FFA900;' border="1">
					<tr>
						<th>
							<p>Cervezas</p>
						</th>
					</tr>
					<?php 
						while($row = mysqli_fetch_array($resCerveza)){
							echo "<tr><td scope='row' height='30px;'><a href='cerveza.php?id=".$row[0]."'><p>".$row[1]."</p></td></tr>";
						}
				 	?>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<button class="btn btn-dark" onclick="location.href='resultados.php'">Ver resultados</button>
	<br><br>
	<button class="btn btn-dark" onclick="location.href='cata.php'">Volver</button></td>
</body>
</html>
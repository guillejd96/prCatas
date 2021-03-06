<?php 
	include "config.php";
	include 'menus.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idCata = $_GET["id"];

	$sql = "SELECT nombre FROM cata WHERE id=".$idCata;
	$nombreCata = mysqli_query($conexion,$sql)->fetch_row()[0];

	$sql = "SELECT idPersona FROM persona_cata WHERE idCata =".$idCata;
	$resIDPersonas = mysqli_query($conexion,$sql);

	$sql = "SELECT id,nombre FROM cerveza WHERE idCata =".$idCata;
	$resCerveza = mysqli_query($conexion,$sql);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $nombreCata ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
	<h1><?php echo $nombreCata ?></h1><br><br>
	<table>
		<tr>
			<td>
				<table class="no_border">
					<tr>
						<th>
							<p>Personas</p>
						</th>
					</tr>
					<?php 
						while($row = mysqli_fetch_array($resIDPersonas)){
							$sqlPersonas = "SELECT id,nombre FROM persona WHERE id=".$row[0];
							$persona = mysqli_query($conexion,$sqlPersonas)->fetch_row();
							echo "<tr><td scope='row' width='7rem'><a href='persona.php?id=".$persona[0]."&c=".$idCata."'><p>".$persona[1]."</p></td></tr>";
						}
				 	?>
				</table>
			</td>
			<td></td>
			<td>
				<table class="no_border">
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
		<tr><td colspan="4"><br>
			<button class="btn btn-primary" onclick="location.href='resultados.php?id=<?php echo $idCata; ?>'">Resultados</button>
		</td></tr>
	</table>
	</div>
</body>
</html>
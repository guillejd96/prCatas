<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$idPersona = mysqli_query($conexion,"SELECT id FROM persona WHERE idUsuario=".$idUsuario)->fetch_row()[0];

	$idCata = $_GET['id'];

	$res = mysqli_query($conexion,"SELECT * FROM persona_cata WHERE idPersona=".$idPersona." AND idCata=".$idCata);
	if(mysqli_num_rows($res)==0){
		header('Location: index.php');
	}

	$nombreCata = mysqli_query($conexion, "SELECT nombre FROM cata WHERE id=".$idCata)->fetch_row()[0];

	$resMedia = mysqli_query($conexion,"SELECT idCerveza,media FROM medias WHERE idCata=".$idCata." ORDER BY media DESC");

	$resAroma = mysqli_query($conexion,"SELECT idCerveza,aroma FROM medias WHERE idCata=".$idCata." ORDER BY aroma DESC");

	$resApariencia = mysqli_query($conexion,"SELECT idCerveza,apariencia FROM medias WHERE idCata=".$idCata." ORDER BY apariencia DESC");

	$resSabor = mysqli_query($conexion,"SELECT idCerveza,sabor FROM medias WHERE idCata=".$idCata." ORDER BY sabor DESC");

	$resCuerpo = mysqli_query($conexion,"SELECT idCerveza,cuerpo FROM medias WHERE idCata=".$idCata." ORDER BY cuerpo DESC");

	$resBotellin = mysqli_query($conexion,"SELECT idCerveza,botellin FROM medias WHERE idCata=".$idCata." ORDER BY botellin DESC");
	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resultados</title>
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
		<h2 align="left" style="margin-left: 2%">Los resultados de <?php echo $nombreCata; ?> son los siguientes:</h2><br>
		<table width="900">
			<tr>
				<th colspan="3"><p>Mejores cervezas de media</p></th>
			</tr>
			<?php 
				$i=1;
				while($row = mysqli_fetch_array($resMedia)){
					$idCerveza = $row[0];
					$media = $row[1];

					$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

					echo "<tr><td><p>#".$i."</p></td><td><p>".$nombre."</p></td><td><p>".round($media,2)."</p></td><tr>";
					$i++;
				}
			 ?>
		</table>
		<table class="simple">
			<tr>
				<td>
					<table>
						<tr>
							<th colspan="3"><p>Mejores cervezas por aroma</p></th>
						</tr>
						<?php 
							$i=1;
							while($row = mysqli_fetch_array($resAroma)){
								$idCerveza = $row[0];
								$aroma = $row[1];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<tr><td><p>#".$i."</p></td><td><p>".$nombre."</p></td><td><p>".round($aroma,2)."</p></td><tr>";
								$i++;
							}
						 ?>
					</table>
					<br>
				</td>
				<td>
					<table>
						<tr>
							<th colspan="3"><p>Mejores cervezas por apariencia</p></th>
						</tr>
						<?php 
							$i=1;
							while($row = mysqli_fetch_array($resApariencia)){
								$idCerveza = $row[0];
								$apariencia = $row[1];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<tr><td><p>#".$i."</p></td><td><p>".$nombre."</p></td><td><p>".round($apariencia,2)."</p></td><tr>";
								$i++;
							}
						 ?>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<th colspan="3"><p>Mejores cervezas por sabor</p></th>
						</tr>
						<?php 
							$i=1;
							while($row = mysqli_fetch_array($resSabor)){
								$idCerveza = $row[0];
								$sabor = $row[1];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<tr><td><p>#".$i."</p></td><td><p>".$nombre."</p></td><td><p>".round($sabor,2)."</p></td><tr>";
								$i++;
							}
						 ?>
					</table>
					<br>
				</td>
				<td>
					<table>
						<tr>
							<th colspan="3"><p>Mejores cervezas por cuerpo</p></th>
						</tr>
						<?php 
							$i=1;
							while($row = mysqli_fetch_array($resCuerpo)){
								$idCerveza = $row[0];
								$cuerpo = $row[1];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<tr><td><p>#".$i."</p></td><td><p>".$nombre."</p></td><td><p>".round($cuerpo,2)."</p></td><tr>";
								$i++;
							}
						 ?>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<th colspan="3"><p>Mejores cervezas por botellin</p></th>
						</tr>
						<?php 
							$i=1;
							while($row = mysqli_fetch_array($resBotellin)){
								$idCerveza = $row[0];
								$botellin = $row[1];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<tr><td><p>#".$i."</p></td><td><p>".$nombre."</p></td><td><p>".round($botellin,2)."</p></td><tr>";
								$i++;
							}
						 ?>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
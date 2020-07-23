<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$sql = "SELECT idCerveza,((aroma+apariencia+sabor+cuerpo+botellin)/5) as nota FROM opinion GROUP BY idCerveza ORDER BY nota DESC";
	$res = mysqli_query($conexion,$sql);
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Top 10</title>
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
		<h2 align="left" style="margin-left: 2%">Top 10 mejores cervezas: </h2>
		<table>
			<tr>
				<th>
					<p>Cerveza</p>
				</th>
				<th>
					<p>Nota media</p>
				</th>
				<th>
					<p>Nº opiniones</p>
				</th>
			</tr>
				<?php 

				while ($row = mysqli_fetch_array($res)) {
					$idCerveza = $row[0];
					$notaMedia = $row[1];
					$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];
					$nOpiniones = mysqli_query($conexion,"SELECT COUNT(*) FROM opinion WHERE idCerveza=".$idCerveza)->fetch_row()[0];
					echo "<tr>";
					echo "<td><p>".$nombre."</p></td>";
					echo "<td><p>".round($notaMedia,2)."</p></td>";
					echo "<td><p>".$nOpiniones."</p></td>";
					echo "</tr>";
				}

				?>
			</tr>
		</table>
	</div>
 </body>
 </html>
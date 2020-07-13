<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$idPersona = mysqli_query($conexion,"SELECT id FROM persona WHERE idUsuario=".$idUsuario)->fetch_row()[0];

	$sql = "SELECT * FROM opinion WHERE idPersona=".$idPersona;
	$resOpiniones = mysqli_query($conexion,$sql);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Mis cervezas</title>
	<script>
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h2>Mis cervezas</h2>
		<table class="display" id="content">
			<?php if(mysqli_num_rows($resOpiniones)>0){
				echo "<tr>
			 			<th>
			 				<p>Cerveza</p>
			 			</th>
			 			<th title='Ordenar'>
			 				<p>Aroma</p>
			 			</th>
			 			<th title='Ordenar'>
			 				<p>Apariencia</p>
			 			</th>
			 			<th title='Ordenar'>
			 				<p>Sabor</p>
			 			</th>
			 			<th title='Ordenar'>
			 				<p>Cuerpo</p>
			 			</th>
			 			<th title='Ordenar'>
			 				<p>Botellín</p>
			 			</th>
			 			<th title='Ordenar'>
			 				<p>Media</p>
			 			</th>
			 		</tr>";
			 		if($resOpiniones->num_rows>0){
	 					while($row = mysqli_fetch_assoc($resOpiniones)){
	 						$sqlCerveza = "SELECT nombre FROM cerveza WHERE id=".$row['idCerveza'].";";
		 					$cerveza = mysqli_query($conexion,$sqlCerveza)->fetch_row()[0];
		 					echo "<tr>";
		 					echo "<td><p>".$cerveza."</p></td>";
		 					echo "<td><p>".$row['aroma']."</p></td>";
		 					echo "<td><p>".$row['apariencia']."</p></td>";
		 					echo "<td><p>".$row['sabor']."</p></td>";
		 					echo "<td><p>".$row['cuerpo']."</p></td>";
		 					echo "<td><p>".$row['botellin']."</p></td>";
		 					$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']+$row['botellin']) / 5;
		 					echo "<td><p>".$media."</p></td>";
		 					echo "</tr>";
	 					}
	 				} else {
	 				echo "<tr><td colspan='6'><p>No hay resultados disponibles</p></td></tr>";
	 				}

			} else {
				echo "<tr><td>";
				echo "<p>No has registrado ninguna cerveza</p>";
				echo "</td></tr>";
				echo "<tr><td>";
				echo "<p>Para registrar tu primera cata pulsa <a href='nueva_cata.php'>aquí</a></p>";
				echo "<p>Para registrar tu primera cerveza pulsa <a href='nueva_cerveza.php'>aquí</a></p>";
				echo "</td></tr>";
			} 
			?>
		</table><br>
	</div>
</body>
</html>

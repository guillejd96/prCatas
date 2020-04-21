<?php 
	include 'config.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idPersona = $_SESSION["idUsuario"];

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
	<title>Mis cervezas</title>
</head>
<body>
	<h1>Mis Cervezas</h1>
	<h3>Aquí se muestran un listado de todas las valoraciones que has hecho</h3>
	
	<table>
		<?php if(mysqli_num_rows($resOpiniones)>0){
			echo "<tr>
		 			<th>
		 				<p>Cerveza</p>
		 			</th>
		 			<th>
		 				<p>Aroma</p>
		 			</th>
		 			<th>
		 				<p>Apariencia</p>
		 			</th>
		 			<th>
		 				<p>Sabor</p>
		 			</th>
		 			<th>
		 				<p>Cuerpo</p>
		 			</th>
		 			<th>
		 				<p>Botellín</p>
		 			</th>
		 			<th>
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
	 					if($row['botellin']!=NULL){
	 						echo "<td><p>".$row['botellin']."</p></td>";
	 						$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']+$row['botellin']) / 5;
	 						echo "<td><p>".$media."</p></td>";
	 					} else {
	 						echo "<td><p>--</p></td>";
	 						$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']) / 4;
	 						echo "<td><p>".$media."</p></td>";
	 					}
	 					echo "<tr>";
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
			echo "</td></tr>";
		} 
		?>
	</table><br>
	<button class="btn btn-link" onclick="location.href='user.php'">Volver</button>
</body>
</html>

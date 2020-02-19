<?php 
	include "config.php";
	$id = $_GET["id"];

	$sql = "SELECT nombre,idCata FROM persona WHERE id=".$id;
	$persona = mysqli_query($conexion,$sql)->fetch_row();


	$sql = "SELECT * FROM opinion WHERE idPersona=".$id;
	$resOpiniones = mysqli_query($conexion,$sql);
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title><?php echo $persona[1]; ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/init.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 </head>
 <body>
 	<h1>Información de <?php echo $persona[0]; ?></h1>
 	<br>
 	<table style='background-color: #FFA900;' border="1">
 		<tr>
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
 		</tr>
 		<?php 
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
 		 ?>
 	</table>
 	<br>
 	<button class="btn btn-dark" onclick="location.href='info_cata.php?id=<?php echo $persona[1]; ?>'">Volver</button></td>
 </body>
 </html>
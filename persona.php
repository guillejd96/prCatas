<?php 
	include "config.php";
	include 'menus.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$id = $_GET["id"];

	$idCata = $_GET["c"];

	$sql = "SELECT nombre FROM persona WHERE id=".$id;
	$nombrePersona = mysqli_query($conexion,$sql)->fetch_row()[0];


	$sql = "SELECT * FROM opinion WHERE idPersona=".$id;
	$resOpiniones = mysqli_query($conexion,$sql);
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title><?php echo $nombrePersona; ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 </head>
 <body>
 	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
	 	<h1>Información de <?php echo $nombrePersona; ?></h1>
	 	<br>
	 	<table>
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

	 				$sqlCervezas = "SELECT id FROM cerveza WHERE idCata=".$idCata;
	 				$resCervezas = mysqli_query($conexion,$sqlCervezas);
	 				$idCervezas = array();
	 				while($row = mysqli_fetch_array($resCervezas)){
	 					array_push($idCervezas, $row[0]);
	 				}

	 				while($row = mysqli_fetch_assoc($resOpiniones)){
	 					if(in_array($row['idCerveza'], $idCervezas)){
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
	 				}
	 			} else {
	 				echo "<tr><td colspan='7'><p>No hay resultados disponibles</p></td></tr>";
	 			}
	 		 ?>
	 	</table>
	 	<br>
	 	<button class="btn btn-link" onclick="location.href='info_cata.php?id=<?php echo $idCata; ?>'">Volver</button>
	</div>
 </body>
 </html>
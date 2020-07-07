<?php 
	include "config.php";
	include 'menus.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$id = $_GET["id"];

	$sql = "SELECT nombre,idCata FROM cerveza WHERE id=".$id;
	$resCerveza = mysqli_query($conexion,$sql)->fetch_row();
	$cerveza = $resCerveza[0];
	$idCata = $resCerveza[1];

	$sql ="SELECT * FROM opinion WHERE idCerveza=".$id.";";
	$resOpinion = mysqli_query($conexion,$sql);
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title><?php echo $cerveza ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 </head>
 <body>
 	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
	 	<h1>Información de <?php echo $cerveza; ?></h1><br>	
	 	<table>
	 		<tr>
	 			<th>
	 				<p>Persona</p>
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
	 		$nOpinion = $resOpinion->num_rows;
	 		if($nOpinion==0){
	 			echo "<tr><td colspan='7'><p>No hay resultados disponibles</p></td></tr>";
	 		}else {
	 			$sumAroma=0;
	 			$sumApariencia=0;
	 			$sumSabor=0;
	 			$sumCuerpo=0;
	 			$sumBotellin=0;
	 			$sumMedia=0;
	 			while ($row = mysqli_fetch_assoc($resOpinion)) {
	 				$idPersona = $row['idPersona'];
	 				$sql = "SELECT nombre FROM persona WHERE id=".$idPersona.";";
	 				$nombrePersona = mysqli_query($conexion,$sql)->fetch_row()[0];
	 				$sumAroma+=$row['aroma'];
	 				$sumApariencia+=$row['apariencia'];
	 				$sumSabor+=$row['sabor'];
	 				$sumCuerpo+=$row['cuerpo'];
	 				echo "<tr>";
	 				echo "<td><p>".$nombrePersona."</p></td>";
	 				echo "<td><p>".$row['aroma']."</p></td>";
	 				echo "<td><p>".$row['apariencia']."</p></td>";
	 				echo "<td><p>".$row['sabor']."</p></td>";
	 				echo "<td><p>".$row['cuerpo']."</p></td>";
	 				if($row['botellin']!=NULL){
	 					echo "<td><p>".$row['botellin']."</p></td>";
	 					$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']+$row['botellin']) / 5;
	 					echo "<td><p>".round($media,2)."</p></td>";
	 					$sumBotellin+=$row['botellin'];
	 					echo "</tr>";
	 				} else {
	 					echo "<td><p>--</p></td>";
	 					$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']) / 4;
	 					echo "<td><p>".round($media,2)."</p></td>";
	 					$sumMedia+= $media;
	 				}
	 			}
	 			echo "</tr>";
	 			echo "<tr>";
	 			echo "<th><p>Media</p></th>";
	 			$mediaAroma = $sumAroma/$nOpinion;
	 			$mediaApariencia = $sumApariencia/$nOpinion;
	 			$mediaSabor = $sumSabor/$nOpinion;
	 			$mediaCuerpo = $sumCuerpo/$nOpinion;
	 			$mediaBotellin = $sumBotellin/$nOpinion;
	 			$mediaMedia = $sumMedia/$nOpinion;
	 			echo "<td><p>".round($mediaAroma,2)."</p></td>";
	 			echo "<td><p>".round($mediaApariencia,2)."</p></td>";
	 			echo "<td><p>".round($mediaSabor,2)."</p></td>";
	 			echo "<td><p>".round($mediaCuerpo,2)."</p></td>";
	 			if($row['botellin']!=NULL){
	 				echo "<td><p>".round($mediaBotellin,2)."</p></td>";
	 			} else {
	 				echo "<td><p>--</p></td>";
	 			}
	 			echo "<td><p>".round($mediaMedia,2)."</p></td>";
	 			echo "</tr>";
	 		}
	 		 ?>
	 	</table>
	 	<br>	
	 	<button class="btn btn-link" onclick="location.href='info_cata.php?id=<?php echo $idCata; ?>'">Volver</button>
	</div>
 </body>
 </html>
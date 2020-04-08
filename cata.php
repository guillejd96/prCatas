<?php 
	include "config.php";

	$resCatas = mysqli_query($conexion,"SELECT * FROM cata");
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Catas</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 </head>
 <body>
 	<h1>Catas guardadas</h1><br>
 	<?php if($resCatas->num_rows>0){
 		echo "<table>";
 		echo "<tr>";
 		echo "<th><p>ID</p></th>";
 		echo "<th><p>Nombre</p></th>";
 		echo "<th><p>Fecha</p></th>";
 		echo "<th><p>Personas</p></th>";
 		echo "<th><p>Cervezas</p></th>";
 		echo "</tr>";
		while ($cata = mysqli_fetch_assoc($resCatas)) {
			$idCata = $cata['id'];
			$resCervezas = mysqli_query($conexion,"SELECT COUNT(*) FROM cerveza WHERE idCata = $idCata");
			$nCervezas = $resCervezas->fetch_row()[0];
			$resPersonas = mysqli_query($conexion,"SELECT COUNT(*) FROM persona WHERE idCata = $idCata");
			$nPersonas = $resPersonas->fetch_row()[0];
			echo "<tr>";
			echo "<td><p><a href='info_cata.php?id=".$idCata."'>".$idCata."</a></p>";
			echo "<td><p>".$cata['nombre']."</p></td>";
			echo "<td><p>".$cata['fecha']."</p></td>";
			echo "<td><p>".$nCervezas."</p></td>";
			echo "<td><p>".$nPersonas."</p></td>";
			echo "</tr>";
		}
		echo "</table>";
 	} else { ?>
		<p>No hay catas en la base de datos</p>
 	<?php } ?>
 	<br>
 	<button class="btn btn-dark" onclick="location.href='user.php'">Volver</button>
 </body>
 </html>
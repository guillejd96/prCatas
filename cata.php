<?php 
	include "config.php";

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE idUsuario=".$idUsuario;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$idPersona = $resPersona[0];

	$sqlPersonaCata = "SELECT idCata FROM persona_cata WHERE idPersona = ".$idPersona;
	$resIDCatas = mysqli_query($conexion,$sqlPersonaCata);
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Catas</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		function borrar(id){
			b = confirm("¿Quiere borrar la cata con ID "+id+"?");
			if(b){
				$.get('ajax/borrarCata.php?id='+id, function(data) {
					if(data=="1"){
						setTimeout(function () {
	       						window.location.reload();	
	    				},1000);
					}
				});
			}
		}
	</script>
 </head>
 <body>
 	<h1>Catas guardadas</h1><br>
 	<h3>Aquí se muestran un listado de las catas que has registrado</h3>
 	<?php if($resIDCatas->num_rows>0){
 		echo "<table>";
 		echo "<tr>";
 		echo "<th><p>ID</p></th>";
 		echo "<th><p>Nombre</p></th>";
 		echo "<th><p>Fecha</p></th>";
 		echo "<th><p>Personas</p></th>";
 		echo "<th><p>Cervezas</p></th>";
 		echo "<th><p></p></th>";
 		echo "</tr>";
		while ($idCata = mysqli_fetch_array($resIDCatas)) {
			$sqlCata = "SELECT * FROM cata WHERE id=".$idCata[0];
			$cata = mysqli_query($conexion,$sqlCata)->fetch_row();
			$resCervezas = mysqli_query($conexion,"SELECT COUNT(*) FROM cerveza WHERE idCata = ".$idCata[0]);
			$nCervezas = $resCervezas->fetch_row()[0];
			$resPersonas = mysqli_query($conexion,"SELECT COUNT(*) FROM persona_cata WHERE idCata = ".$idCata[0]);
			$nPersonas = $resPersonas->fetch_row()[0];
			echo "<tr>";
			echo "<td><p><a href='info_cata.php?id=".$idCata[0]."'>".$idCata[0]."</a></p>";
			echo "<td><p>".$cata[1]."</p></td>";
			echo "<td><p>".$cata[2]."</p></td>";
			echo "<td><p>".$nCervezas."</p></td>";
			echo "<td><p>".$nPersonas."</p></td>";
			echo "<td><p><button class='btn btn-link' onclick='javascript:borrar($idCata[0])'><i class='far fa-trash-alt' style='font-size: 25px'></i></button> <button class='btn btn-link'><i class='far fa-edit' style='font-size: 25px'></i></button></p></td>";
			echo "</tr>";
		}
		echo "</table>";
 	} else { ?>
 		<table>
 			<tr>
 				<td><p>No has registrado ninguna cata</p></td>
 			</tr>
 			<tr>
 				<td><p>Para registrar tu primera cata pulsa <a href="nueva_cata.php">aquí</a></p></td>
 			</tr>
 		</table>
		
 	<?php } ?>
 	<br>
 	<button class="btn btn-link" onclick="location.href='user.php'">Volver</button>
 </body>
 </html>
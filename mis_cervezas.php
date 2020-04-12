<?php 
	include 'config.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlCervezas = "SELECT * FROM opinion WHERE idPersona=".$idUsuario;
	$resCervezas = mysqli_query($conexion,$sqlCervezas);
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
		<?php if(mysqli_num_rows($resCervezas)>0){

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

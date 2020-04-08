
<?php 
	include "config.php";
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlUsuario = "SELECT * FROM persona WHERE id=".$idUsuario;
	$resUsuario = mysqli_query($conexion,$sqlUsuario)->fetch_row();
	$usuario = $resUsuario[1];
	$nombre = $resUsuario[2];

	$sqlNCatas = "SELECT COUNT(*) FROM persona_cata WHERE idPersona =".$idUsuario;
	$nCatas = mysqli_query($conexion,$sqlNCatas)->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		function salir(){
			$.get('ajax/logout.php', function(data) {
				window.location.replace("index.php");
			});
		}
	</script>
</head>
<body>
	<h1>Servidor de catas</h1><br>
	<h2>Bienvenido <?php echo $usuario ?></h2><br>
	<h2>Nombre: <?php echo $nombre ?></h2><br>
	<h2>Catas: <?php echo $nCatas ?></h2><br>
	<button type="button" class="btn btn-dark" onclick="location.href = 'nueva_cata.php'">Nueva cata</button> <br><br>
	<button type="button" class="btn btn-dark" onclick="location.href = 'cata.php'">Ver catas</button><br><br>
	<button type="button" class="btn btn-dark" onclick="javascript:salir()">Salir</button><br>
</body>
</html> 
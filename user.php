
<?php 
	include "config.php";

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idPersona = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE id=".$idPersona;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$nombre = $resPersona[1];
	$idUsuario = $resPersona[2];

	$sqlUsuario = "SELECT usuario FROM usuario WHERE id=".$idUsuario;
	$usuario = mysqli_query($conexion,$sqlUsuario)->fetch_row()[0];	

	$sqlNCatas = "SELECT COUNT(*) FROM persona_cata WHERE idPersona =".$idPersona;
	$nCatas = mysqli_query($conexion,$sqlNCatas)->fetch_row()[0];

	$sqlNCervezas = "SELECT COUNT(*) FROM opinion WHERE idPersona =".$idPersona;
	$nCervezas = mysqli_query($conexion,$sqlNCervezas)->fetch_row()[0];
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
	<table width="50%">
		<tr>
			<td colspan="2"><h2>Bienvenido <?php echo $usuario ?></h2></td>
		</tr>
		<tr>
			<td>
				<table class="no_border">
					<tr>
						<td><h2 align="left">Nombre: </h2></td>
						<td><h2><?php echo $nombre ?></h2></td>
					</tr>
					<tr>
						<td><h2 align="left">Catas: </h2></td>
						<td><h2><?php echo $nCatas ?></h2></td>
					</tr>
					<tr>
						<td><h2 align="left">Cervezas: </h2></td>
						<td><h2><?php echo $nCervezas ?></h2></td>
					</tr>
				</table><br><br>
			</td>
			<td>
				<table class="no_border">
					<tr>
						<td><button type="button" class="btn btn-dark" onclick="location.href = 'nueva_cata.php'">Nueva cata</button><br><br></td>
					</tr>
					<tr>
						<td><button type="button" class="btn btn-dark" onclick="location.href = 'cata.php'">Ver catas</button><br><br></td>
					</tr>
					<tr>
						<td><button type="button" class="btn btn-dark" onclick="location.href = 'mis_cervezas.php'">Ver cervezas</button><br></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><button type="button" class="btn btn-dark" onclick="javascript:salir()">Salir</button><br></td>
		</tr>
	</table>
</body>
</html> 
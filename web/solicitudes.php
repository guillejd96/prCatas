<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$resSolicitudes = mysqli_query($conexion,"SELECT idUsuario1 FROM amigos WHERE aceptada=0 AND idUsuario2=".$idUsuario);

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Solicitudes de amistad</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		function accept(id) {
			$.post('ajax/aceptar.php', {id: id}, function(data, textStatus, xhr) {
				if(data=="1"){
					window.location.reload();
				}else {
					$("#res").text("No se ha podido aceptar la petición");
				}
			});
		}

		function refuse(id){
			$.post('ajax/rechazar.php', {id: id}, function(data, textStatus, xhr) {
				if(data=="1"){
					window.location.reload();
				}else {
					$("#res").text("No se ha podido rechazar la petición");
				}
			});
		}
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<?php 
			if(mysqli_num_rows($resSolicitudes)>0) {
				echo "<table><tr><th><p>Solicitud</p></th><th><p></p></th><th><p></p></th></tr>";
				while($row = mysqli_fetch_array($resSolicitudes)){
					$idPeticion = $row[0];
					$usuario = mysqli_query($conexion,"SELECT usuario FROM usuario WHERE id=".$idPeticion)->fetch_row()[0];
					$nombre = mysqli_query($conexion,"SELECT nombre FROM persona WHERE idUsuario=".$idPeticion)->fetch_row()[0];
					echo "<tr>";
					echo "<td><p>".$nombre." (".$usuario.") quiere ser tu amigo!</p></td>";
					echo "<td><button class='btn btn-success' onclick='javascript:accept(".$idPeticion.")'><p>Aceptar</p></button></td>";
					echo "<td><button class='btn btn-danger' onclick='javascript:refuse(".$idPeticion.")'><p>Rechazar</p></button></td>";
					echo "</tr>";
				}
			} else {
				echo "<p>No tienes solicitudes pendientes</p>";
			}
		?>
		</table>
		<p id="res"></p>
	</div>
</body>
</html>
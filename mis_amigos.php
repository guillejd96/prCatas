<?php 

	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$resAmigos = mysqli_query($conexion,"SELECT idUsuario2,aceptada FROM amigos WHERE idUsuario1=".$idUsuario);

	$resSolicitudes = mysqli_query($conexion,"SELECT idUsuario1 FROM amigos WHERE aceptada=0 AND idUsuario2=".$idUsuario);

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Mis amigos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h1>Mis amigos</h1>
		<table>
			<tr>
				<td>
					<?php 
						if(mysqli_num_rows($resSolicitudes)>0){
							echo "<a href='solicitudes.php'><p>Hay solicitudes pendientes</p></a>";
						} else{
							echo "<p>No hay solicitudes pendientes</p>";
						}
					?>
				</td>
				<td><a href="anyadir_amigo.php"><p><i class="fas fa-user-plus"></i> Añadir amigo</p></a></td>
			</tr>
		</table>
		<br>
		<?php 
			if(mysqli_num_rows($resAmigos)>0){
				echo "<table><tr><th><p>Usuario</p></th><th><p>Nombre</p></th><th></th></tr>";
				while($amigo = mysqli_fetch_array($resAmigos)){
					$idAmigo = $amigo[0];
					$pendiente = $amigo[1];
					$usuario = mysqli_query($conexion,"SELECT usuario FROM usuario WHERE id=".$idAmigo)->fetch_row()[0];
					$nombre = mysqli_query($conexion,"SELECT nombre FROM persona WHERE idUsuario=".$idAmigo)->fetch_row()[0];
					if($pendiente!=0){
						echo "<tr>";
						echo "<td><p>".$usuario."</p></td>";
						echo "<td><p>".$nombre."</p></td>";
						echo "</tr>";
					}
				}
				echo "</table>";
			}
			else {
				echo "<p>No has agregado ningún amigo</p>";
			}
		?>
	</div>
</body>
</html>

<?php 
	include "config.php";
	include 'menus.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE idUsuario=".$idUsuario;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$idPersona = $resPersona[0];
	$nombre = $resPersona[1];

	$sqlUsuario = "SELECT usuario FROM usuario WHERE id=".$idUsuario;
	$usuario = mysqli_query($conexion,$sqlUsuario)->fetch_row()[0];	

	$sqlNCatas = "SELECT COUNT(*) FROM persona_cata WHERE idPersona =".$idPersona;
	$nCatas = mysqli_query($conexion,$sqlNCatas)->fetch_row()[0];

	$sqlNCervezas = "SELECT COUNT(*) FROM opinion WHERE idPersona =".$idPersona;
	$nCervezas = mysqli_query($conexion,$sqlNCervezas)->fetch_row()[0];

	$sqlNAmigos = "SELECT COUNT(*) FROM amigos WHERE aceptada=1 AND idUsuario1 = ".$idUsuario;
	$nAmigos = mysqli_query($conexion,$sqlNAmigos)->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
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
		<?php 
			$sqlSolicitudes = "SELECT idUsuario1 FROM amigos WHERE aceptada=0 AND idUsuario2 = ".$idUsuario;
			$resSolicitudes = mysqli_query($conexion,$sqlSolicitudes);
			if(mysqli_num_rows($resSolicitudes)>0){
				echo "<a href='solicitudes.php'><p><i class='fas fa-exclamation'></i> Hay solicitudes de amistad pendientes</p></a>";
			}
		 ?>
		<table width="1000">
			<tr>
				<td><p>Usuario: </p></td>
				<td><p><?php echo $usuario ?></p></td>
			</tr>
			<tr>
				<td><p>Nombre: </p></td>
				<td><p><?php echo $nombre ?></p></td>
			</tr>
			<tr>
				<td><p>Catas: </p></td>
				<td><p><?php echo $nCatas ?></p></td>
			</tr>
			<tr>
				<td><p>Cervezas: </p></td>
				<td><p><?php echo $nCervezas ?></p></td>
			</tr>
			<tr>
				<td><p>Amigos: </p></td>
				<td><p><?php echo $nAmigos ?></p></td>
			</tr>
		</table>
	</div>
</body>
</html> 
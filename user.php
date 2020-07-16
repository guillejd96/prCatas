
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

	$sqlSelectBestMedia = "SELECT idCerveza,MAX((aroma + apariencia + sabor + cuerpo + botellin)/ 5.0) FROM opinion WHERE idPersona = ".$idPersona;
	$resBestMedia = mysqli_query($conexion,$sqlSelectBestMedia)->fetch_row();
	$idBestCerveza = $resBestMedia[0];
	$bestMedia = $resBestMedia[1];
	$nombreBestCerveza = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idBestCerveza)->fetch_row()[0];

	$sqlSelectBestAroma = "SELECT idCerveza,MAX(aroma) FROM opinion WHERE idPersona = ".$idPersona;
	$resBestAroma = mysqli_query($conexion,$sqlSelectBestAroma)->fetch_row();
	$idBestAroma = $resBestAroma[0];
	$bestAroma = $resBestAroma[1];
	$nombreBestAroma = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idBestAroma)->fetch_row()[0];

	$sqlSelectBestApariencia = "SELECT idCerveza,MAX(apariencia) FROM opinion WHERE idPersona = ".$idPersona;
	$resBestApariencia = mysqli_query($conexion,$sqlSelectBestApariencia)->fetch_row();
	$idBestApariencia = $resBestApariencia[0];
	$bestApariencia = $resBestApariencia[1];
	$nombreBestApariencia = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idBestApariencia)->fetch_row()[0];

	$sqlSelectBestSabor = "SELECT idCerveza,MAX(sabor) FROM opinion WHERE idPersona = ".$idPersona;
	$resBestSabor = mysqli_query($conexion,$sqlSelectBestSabor)->fetch_row();
	$idBestSabor = $resBestSabor[0];
	$bestSabor = $resBestSabor[1];
	$nombreBestSabor = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idBestSabor)->fetch_row()[0];

	$sqlSelectBestCuerpo = "SELECT idCerveza,MAX(cuerpo) FROM opinion WHERE idPersona = ".$idPersona;
	$resBestCuerpo = mysqli_query($conexion,$sqlSelectBestCuerpo)->fetch_row();
	$idBestCuerpo = $resBestCuerpo[0];
	$bestCuerpo = $resBestCuerpo[1];
	$nombreBestCuerpo = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idBestCuerpo)->fetch_row()[0];

	$sqlSelectBestBotellin = "SELECT idCerveza,MAX(botellin) FROM opinion WHERE idPersona = ".$idPersona;
	$resBestBotellin = mysqli_query($conexion,$sqlSelectBestBotellin)->fetch_row();
	$idBestBotellin = $resBestBotellin[0];
	$bestBotellin = $resBestBotellin[1];
	$nombreBestBotellin = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idBestBotellin)->fetch_row()[0];
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
		<table width="1000" class="simple">
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
			<?php 
				if($nCervezas>0){
					echo '<tr><td><p>Mejor cerveza de media:</p></td><td><p>'.$nombreBestCerveza.'  ('.round($bestMedia,2).')</p></td></tr>';
					echo '<tr><td><p>Mejor cerveza por aroma:</p></td><td><p>'.$nombreBestAroma.'  ('.$bestAroma.')</p></td></tr>';
					echo '<tr><td><p>Mejor cerveza por apariencia:</p></td><td><p>'.$nombreBestApariencia.'  ('.$bestApariencia.')</p></td></tr>';
					echo '<tr><td><p>Mejor cerveza por sabor:</p></td><td><p>'.$nombreBestSabor.'  ('.$bestSabor.')</p></td></tr>';
					echo '<tr><td><p>Mejor cerveza por cuerpo:</p></td><td><p>'.$nombreBestCuerpo.'  ('.$bestCuerpo.')</p></td></tr>';
					echo '<tr><td><p>Mejor cerveza por botellín:</p></td><td><p>'.$nombreBestBotellin.'  ('.$bestBotellin.')</p></td></tr>';
				}
			 ?>
		</table>
	</div>
</body>
</html> 
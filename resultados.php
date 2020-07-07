<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$idPersona = mysqli_query($conexion,"SELECT id FROM persona WHERE idUsuario=".$idUsuario)->fetch_row()[0];

	$idCata = $_GET['id'];

	$res = mysqli_query($conexion,"SELECT * FROM persona_cata WHERE idPersona=".$idPersona." AND idCata=".$idCata);
	if(mysqli_num_rows($res)==0){
		header('Location: index.php');
	}

	$nombreCata = mysqli_query($conexion, "SELECT nombre FROM cata WHERE id=".$idCata)->fetch_row()[0];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resultados</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		function mejorCervezaAroma(){
			
		}

		function mejorCervezaMedia(){

		}
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h2 align="left" style="margin-left: 2%">Los resultados de <?php echo $nombreCata; ?> son los siguientes:</h2>
	</div>
</body>
</html>
<?php 

	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Instrucciones</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		function goToApariencia(){
			$('html,body').animate({scrollTop: 400},500);
		}

		function goToAroma(){
			$('html,body').animate({scrollTop: 650},500);
		}

		function goToSabor(){
			$('html,body').animate({scrollTop: 900},500);
		}

		function goToCuerpo(){
			$('html,body').animate({scrollTop: 900},500);
		}

		function goToBotellin(){
			$('html,body').animate({scrollTop: 1000},500);
		}
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h2 align="left" style="margin-left: 2%">Instrucciones para catar una cerveza: </h2>
		<p>Para catar una cerveza, debes apreciar 4 variables fundamentales</p>
		<table class="simple">
			<tr>
				<td>
					<a href="#" onclick="javascript:goToApariencia()"><p>Apariencia</p></a>
				</td>
				<td>
					<a href="#"  onclick="javascript:goToAroma()"><p>Aroma</p></a>
				</td>
				<td>
					<a href="#" onclick="javascript:goToSabor()"><p>Sabor</p></a>
				</td>
				<td>
					<a href="#" onclick="javascript:goToCuerpo()"><p>Cuerpo</p></a>
				</td>
			</tr>
		</table>
		<p>Otra variable que añadimos en DeCatas es el <a href="#" id="cuerpo" onclick="javascript:goToCuerpo()">botellín</a>.</p><hr>
		<h3 id="apariencia"><b>Apariencia</b></h3>
		<p>Para analizar la apariencia de una cerveza puedes analizar: </p>
		<ul>
			<li><b>Color</b>: Amarillo, caramelo, cobre, negro...</li>
			<li><b>Tonalidad</b>: Turbia, velada, translúcida</li>
			<li><b>Espuma</b>: ¿Es densa? ¿Perdura?</li>
			<li><b>Gasificación</b>: El gas de la cerveza es vivo o apenas de nota</li>
		</ul><hr>
		<h3 id="aroma"><b>Aroma</b></h3>
		<p>El aroma depende tanto del tipo, la cantidad y la proporción de malta y lúpulo que se use en la elaboración, así como de otros elementos que se añaden tras la fermentación para dar otro tipo de cualidades organolépticas. Así deberás estar atento a:</p>
		<ul>
			<li><b>Notas de la malta</b>: Caramelo, cereal, regaliz, café,...</li>
			<li><b>Notas del lúpulo</b>: Herbal, floral, cítricas,...</li>
		</ul><hr>
		<h3 id="sabor"><b>Sabor</b></h3>
		<p>Para el sabor te recomendamos que disfrutes de un primer sorbo que acaricie todo el paladar. Ahí ya notarás las primeras cualidades de la cerveza, en el siguiente las confirmarás o descubrirás nuevas. Al igual que en la fase olfativa, al degustar la cerveza, los sabores que vas a notar dependen tanto del lúpulo como de la malta, o las frutas, especias,... que se añadan a la cerveza.</p>
		<ul>
			<li><b>Sabores de la malta</b>: Terrosos, chocolate,...</li>
			<li><b>Sabores del lúpulo</b>: Frutas, flores, resinosos,...</li>
		</ul><hr>
		<h3 id="cuerpo"><b>Cuerpo</b></h3>
		<p>Deberás anotar las sensaciones que en el paladar ha dejado la cerveza. No todas las cervezas, por muy parecidas que sean en muchas de sus características, dejan la misma apreciación. Hay cervezas más gasificadas, otras son ácidas, otras amargas, otras son densas,... Por eso deberás apreciar:</p>
		<ul>
			<li><b>Textura</b>: Ligera, densa,...</li>
			<li><b>Vivacidad</b>: Mucha o poca gasificación.</li>
			<li><b>Predominancia</b>: Ácida, amarga, dulce,...</li>
		</ul><hr>
		<h3 id="botellin"><b>Botellin</b></h3>
		<p>Por último, para valorar el botellín puedes fijarte en su forma, en el diseño de las etiquetas, sus colores y formas, etc</p>
	</div>
</body>
</html>
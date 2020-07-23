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
	<title>FaQ</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
	<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h2 align="left" style="margin-left: 2%">Preguntas frecuentes: </h2><br>
		<p><strong>¿Cómo registro una cata nueva?</strong></p>
		<p>Para regitrar una cata hay que ir a Nueva Cata, en el menú de la izquierda. A continuación se pide darle un nombre a la cata, elegir la fecha cuando se hizo y escribir el número de personas y cervezas que hubo. Al pulsar Continuar aparecerán los campos de texto para escribir el nombre de las demás personas. En esta pantalla también se puede añadir amigos a la cata; para ello hay que pulsar en el símbolo <i class="fas fa-plus"></i> y seleccionar el amigo que se quiere añadir. Al pulsar de nuevo Continuar, aparecerán los campos de texto para escribir los nombres de las cervezas de la cata. Tras escribir los nombres y pulsar en Continuar aparecerá una pantalla en forma de tabla para rellenar con todas las valoraciones para los atributos de todas las cervezas y personas.</p><hr>
		<p><strong>¿Cómo registro las valoraciones de una cerveza?</strong></p>
		<p>Para valorar una cerveza individualmente hay que ir a Nueva Cerveza, en el menú de la izquierda. De esta forma se pueden añadir valoraciones sin necesidad de crear una cata específica.</p><hr>
		<p><strong>¿Qué es la media de una cerveza?</strong></p>
		<p>La media de una cerveza es calculada a partir de sus diferentes valoraciones de sus atributos. Cada atributo cuenta igual para la media así que se usa una media aritmética:</p>
		<p class="ec">$$\text{MediaCerveza = (Aroma + Apariencia + Sabor + Cuerpo + Botellin) / 5}$$</p><hr>
		<p><strong>¿Cómo se calculan los resultados de una cata?</strong></p>
		<p>Para el cálculo de la mejor cerveza de media se calcula la nota media de cada cerveza por cada persona de la cata. Si se calcula la nota media de estas medias anteriores se obtiene la nota media general de la cerveza. La tabla "Mejores cervezas de media" muestra estas medias ordenadas de mayor a menor.</p>
		<p class="ec">$$MejorCervezaDeMedia = max(\frac{&sum; mediaCerveza_{i}}{nPersonas})\text{  &forall;i&isin;[1,nCervezas]}$$</p>
		<p>Para el cálculo de la mejor cerveza según el atributo se calcula la media de valoración de todas las personas para ese atributo. La tabla "Mejores cervezas por aroma/apariencia/etc." muestra estas medias ordenadas de mayor a menor.</p>
		<p class="ec">$$MejorCervezaPorAtributo = max(\frac{&sum; atributo_{i}}{nPersonas})\text{  &forall;i&isin;[1,nCervezas]}$$</p><hr>
	</div>
</body>
</html>
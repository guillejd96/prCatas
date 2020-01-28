<?php include "config.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva cata</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/init.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#continuar").click(getPersonasCervezas);
		});

		function getPersonasCervezas(){
			var cadPersonas = $("#personas").val();
			var cadCervezas = $("#cervezas").val();
			var personas = cadPersonas.split(",");
			var cervezas = cadCervezas.split(",");
			for(var i=0;i<personas.length;i++){
				$("body").append("<table border='1' style='background-color: #FFA900;'><tr><th><p>"+personas[i]+"</p></th><th><p>Aroma</p></th><th align='center'><p>Apariencia</p></th><th><p>Sabor</p></th><th><p>Cuerpo</p></th><th><p>Botellín</p></th></tr>");
				for (var j = 0; j<cervezas.length; j++) {
					$("table").last().append("<tr><td><p>"+cervezas[j]+"</p></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td></tr>");	
				}
				$("body").append('</table><br><br><button>Guardar</button><br><br>');

			}
		}
	</script>
</head>
<body>
	
	<h1>Nueva cata</h1><br>
	<table>
		<tr>
			<td><p>Nombre:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="nombre"></td>
		</tr>
		<tr>
			<td><p>Fecha:&nbsp;&nbsp;</p></td>
			<td><input type="date" id="fecha"></td>
		</tr>
		<tr>
			<td><p>Personas:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="personas"></td>
		</tr>
		<tr>
			<td><p>Cervezas:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="cervezas"></td>
		</tr>
		<tr><td colspan="2"><br></td></tr>
		<tr>
			<td><button class="btn btn-secondary" id="continuar">Continuar</button></td>
			<td><button class="btn btn-link" onclick="location.href='index.php'">Volver</button></td>
		</tr>
	</table>
	<br><br>

</body>
</html>
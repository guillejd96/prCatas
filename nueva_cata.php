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
			$(".opiniones").next().remove();
			$(".opiniones").next().remove();
			$(".opiniones").remove();
			$("#guardar").next().remove();
			$("#guardar").next().remove();
			$("#guardar").remove();
			var cadPersonas = $("#personas").val();
			var cadCervezas = $("#cervezas").val();
			var personas = cadPersonas.split(",");
			var cervezas = cadCervezas.split(",");
			if(cadPersonas.length>0 && cadCervezas.length>0){
				for(var i=0;i<personas.length;i++){
					$("body").append("<table border='1' style='background-color: #FFA900;' class='opiniones'><tr><th><p>"+personas[i]+"</p></th><th><p>Aroma</p></th><th align='center'><p>Apariencia</p></th><th><p>Sabor</p></th><th><p>Cuerpo</p></th><th><p>Botellín</p></th></tr>");
					for (var j = 0; j<cervezas.length; j++) {
						$("table").last().append("<tr><td><p>"+cervezas[j]+"</p></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td></tr>");	
					}
					$("body").append('</table><br><br>');
				}
				$("body").append("<button class='btn btn-secondary' id='guardar' onclick='save()'>Guardar</button><p id='estado'></p><br><br>");
			}
		}

		function save(){
			var nombreCata = $("#nombre").val();
			var fechaCata = $("#fecha").val();
			alert(fechaCata);
			$.get('ajax/nuevaCata.php?cata='+nombreCata+'&fecha='+fechaCata, function(data) {
				if(data==1){
					$("#estado").text('Tabla de la cata creada');
					// Falta guardar personas y cervezas antes de las opiniones
					$(".opiniones").each(function(index, table) {
						var nombrePersona = $(table).children().children().find('th:first').children().html();
						var tbody = $(table).children();
						$(tbody).find('tr').each(function(index, tr) {
							var nombreCerveza = $(tr).find('td:first').children().html();
							if(typeof nombreCerveza === "undefined"){}
							else {
								var aroma = $(tr).find('td:first').next().children().val();
								var apariencia = $(tr).find('td:first').next().next().children().val();
								var sabor = $(tr).find('td:first').next().next().next().children().val();
								var cuerpo = $(tr).find('td:first').next().next().next().next().children().val();
								var botellin = $(tr).find('td:first').next().next().next().next().next().children().val();
							}
						});
					});
				} else {

				}

			});
			
		}
	</script>
</head>
<body>
	
	<h1>Nueva cata</h1><br>
		<table>
		<tr>
			<td><p>Nombre de la cata:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="nombre"></td>
		</tr>
		<tr>
			<td><p>Fecha de la cata:&nbsp;&nbsp;</p></td>
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

	<!--
	
	<form id="nueva_cata">

	<div class="form-group">
    <label for="exampleFormControlTextarea1">Nombre de la cata</label>
    <textarea class="form-control"rows="1" title="Un nombre para registrar la nueva cata" class="entrada" style="width: 45%; margin-left: 27.5%;"></textarea>
 </div>
 <div class="form-group">
    <label for="exampleFormControlSelect1">Número de borrachos</label>
    <select class="form-control"  class="entrada" style="width: 45%; margin-left: 27.5%;">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
      <option>13</option>
      <option>14</option>
      <option>15</option>
      <option>16</option>
    </select>
</div>
 	<div class="form-group">
    <label for="exampleFormControlTextarea1">Nombre de las cervezas</label>
    <textarea class="form-control" rows="10" title="Separar cada cerveza mediante una coma (una, otra, otra)" class="entrada" style="width: 45%; margin-left: 27.5%;"></textarea>
</div>
<div>
	<label for="exampleFormControlTextarea1">Elige la fecha de la cata</label> <br>
	<input type="date" id="cervezas" style="width: 25%;">
</div>
</form>

-->
</body>
</html>
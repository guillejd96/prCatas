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
		var personas,cervezas;


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
			personas = cadPersonas.split(",");
			cervezas = cadCervezas.split(",");
			if(cadPersonas.length>0 && cadCervezas.length>0){
				for(var i=0;i<personas.length;i++){
					$("body").append("<table border='1' style='background-color: #FFA900;' class='opiniones'><tr><th><p>"+personas[i]+"</p></th><th><p>Aroma</p></th><th align='center'><p>Apariencia</p></th><th><p>Sabor</p></th><th><p>Cuerpo</p></th><th><p>Botellín</p></th></tr>");
					for (var j = 0; j<cervezas.length; j++) {
						$("table").last().append("<tr><td><p>"+cervezas[j]+"</p></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td><td><input type='number' min='0' max='10'></td></tr>");	
					}
					$("body").append('</table><br><br>');
				}
				$("body").append("<button class='btn btn-secondary' id='guardar' onclick='save()'>Guardar</button>");
			}
		}

		function save(){
			var nombreCata = $("#nombre").val();
			var fechaCata = $("#fecha").val();
			$.get('ajax/nuevaCata.php?cata='+nombreCata+'&fecha='+fechaCata, function(data) {
				if(data!='0'){ // Funciona nuevaCata.php
					var id = data;
					$('body').append("<br><p>"+nombreCata+" ha sido creada</p><br>");
					$(".opiniones").each(function(index, table) {
						var nombrePersona = $(table).children().children().find('th:first').children().html();
						alert(nombrePersona);
						$.get('ajax/nuevaPersona.php?cata='+id+'&nombre='+nombre, function(data) {
							if(data!='0'){ // Funciona nuevaPersona.php
								$('body').append("<br><p>"+nombrePersona+" ha sido añadido</p><br>");
								var idPersona = data;
								var tbody = $(table).children();
								$(tbody).find('tr').each(function(index, tr) {
									var nombreCerveza = $(tr).find('td:first').children().html();
									if(typeof nombreCerveza === "undefined"){}
									else {
										$.get('ajax/nuevaCerveza.php?cata='+id+'&nombre='+nombreCerveza, function(data) {
											if(data!='0'){
												$('body').append("<br><p>Añadiendo opinión de "+nombrePersona+" sobre "+nombreCerveza+"</p><br>");
												var idCerveza = data;
												var aroma = $(tr).find('td:first').next().children().val();
												var apariencia = $(tr).find('td:first').next().next().children().val();
												var sabor = $(tr).find('td:first').next().next().next().children().val();
												var cuerpo = $(tr).find('td:first').next().next().next().next().children().val();
												var botellin = $(tr).find('td:first').next().next().next().next().next().children().val();
												$.get('ajax/nuevaOpinion.php?p='+idPersona+'&c='+idCerveza+'&ar='+aroma+'&ap='+apariencia+'&s='+sabor+'&cu='+cuerpo+'&b='+botellin+'', function(data) {});	
											} else { // Falla nuevaCerveza.php
												$('body').append("<br><p>"+nombreCerveza+" no se ha podido añadir</p><br>");
											}
										});
										
									}
								});
							} else { // Falla nuevaPersona.php
								$('body').append("<br><p>"+nombrePersona+" no se ha podido añadir</p><br>");
							}
							
						});
					});
				} else { // Falla nuevaCata.php
						$('body').append("<br><p>"+nombreCata+" no se ha podido añadir</p><br>");
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
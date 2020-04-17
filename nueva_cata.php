<?php 
	include "config.php"; 

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE idUsuario=".$idUsuario;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$idPersona = $resPersona[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva cata</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		var personas,cervezas,nP,nC,nombreCata,fechaCata;


		$(document).ready(function() {
			$("#continuar1").click(continuar1);
			$("#2").hide();
			$("#3").hide();
			$("#4").hide();
		});

		function continuar1(){
			nombreCata = $("#nombre").val();
			fechaCata = $("#fecha").val();
			nP = $("#personas").val();
			nC = $("#cervezas").val();

			if(nP<1 || nC<1){
				$("#error").text('Introduce un número positivo de personas y cervezas');
				$("#error").css('color', 'red');
				$("#error").css('font-size', '14px');
			}else{
				$("#1").hide();

				$("#2").append('<tr><td colspan="2"><p>Personas</p></td></tr>')

				for (var i = 0; i < nP; i++) {
					$("#2").append('<tr><td colspan="2"><input type="text" id="nombre_personas"><br><br></td></tr>')
				}

				$("#2").append('<tr><tr><td><button class="btn btn-secondary" id="continuar2" onclick="javascript:continuar2()">Continuar</button></td><td><button class="btn btn-link" onclick="volver1()">Volver</button></td></tr></tr>');

				$(".progress-bar").css('width', '33%');
				$(".progress-bar").children('p').text('1/3');

				$("#2").show();
			}
		}

		function volver1(){

			$(".progress-bar").css('width', '0%');
			$(".progress-bar").children('p').text('0/3');

			$("#1").show();
			$("#2").empty();
		}

		function volver2(){

			$(".progress-bar").css('width', '33%');
			$(".progress-bar").children('p').text('1/3');

			$("#2").show();
			$("#3").hide();
		}

		function continuar2(){
			personas = $("input[id='nombre_personas']")
              .map(function(){return $(this).val();}).get();

            $("#2").hide();

            $("#3").append('<tr><td colspan="2"><p>Cervezas</p></td></tr>')

            for (var i = 0; i < nC; i++) {
				$("#3").append('<tr><td colspan="2"><input type="text" id="nombre_cervezas"><br><br></td></tr>')
			}

			$("#3").append('<tr><td><p></p></td></tr>');

            $("#3").append('<tr><tr><td><button class="btn btn-secondary" id="continuar3" onclick="javascript:continuar3()">Continuar</button></td><td><button class="btn btn-link" onclick="volver2()">Volver</button></td></tr></tr>');

            $(".progress-bar").css('width', '66%');
			$(".progress-bar").children('p').text('2/3');

			$("#3").show();
		}

		function continuar3(){
			cervezas = $("input[id='nombre_cervezas']")
              .map(function(){return $(this).val();}).get();

            $("#3").hide();

            $("#4").find('p').text('Redireccionando...')
            $("#4").find('p').css('color', 'green');

            $(".progress-bar").css('width', '100%');
			$(".progress-bar").children('p').text('3/3');

			$("#4").show();

            $.get('ajax/nuevaCata.php?c='+nombreCata+'&p=<?php echo $idPersona ?>&f='+fechaCata, function(data) {
            	if(data=="0" || data=="-1"){
            		$("#4").find('p').text('Error al insertar la cata en base de datos');
            		$("#4").find('p').css('color', 'red');
            	}else {
            		var idCata = data,error1=false,error2=false;

            		personas.forEach(function(item){
            			if(!error1){
            				$.get('ajax/nuevaPersona.php?n='+item+'&c='+idCata, function(data) {
	            				if(data=="0"){
	            					$("#4").find('p').text('Error al insertar las personas en base de datos');
	            					$("#4").find('p').css('color', 'red');
	            					error1=true;
	            				}
	            			});
            			}
            		});

            		cervezas.forEach(function(item){
            			if(!error2){
            				$.get('ajax/nuevaCerveza.php?n='+item+'&c='+idCata, function(data) {
	            				if(data=="0"){
	            					$("#4").find('p').text('Error al insertar las cervezas en base de datos');
	            					$("#4").find('p').css('color', 'red');
	            					error2=true;
	            				}
	            			});
            			}
            		});

            		if(!error1 && !error2){
            			setTimeout(function () {
	       						window.location.replace("opiniones.php?id="+idCata);	
	    				},1000);
            		}
            	}
            });


		}
	</script>
</head>
<body>
	
	<h1>Nueva cata</h1><br>
		<table width="600px">
			<thead>
				<tr>
					<th colspan="2">
						<div class="progress">
		  					<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"><p>0/3</p></div>
						</div>
					</th>
				</tr>
			</thead>
			<tbody id="1">
				<tr>
					<td><p>Nombre de la cata:&nbsp;&nbsp;</p></td>
					<td><input type="text" id="nombre"></td>
				</tr>
				<tr>
					<td><p>Fecha de la cata:&nbsp;&nbsp;</p></td>
					<td><input type="date" id="fecha"></td>
				</tr>
				<tr>
					<td><p>Número de Personas:&nbsp;&nbsp;</p></td>
					<td><input type="number" id="personas" min="0"></td>
				</tr>
				<tr>
					<td><p>Número de Cervezas:&nbsp;&nbsp;</p></td>
					<td><input type="number" id="cervezas" min="0"></td>
				</tr>
				<tr>
					<td colspan="2">
						<p id="error"></p>
					</td>
				</tr>
				<tr>
					<td><button class="btn btn-secondary" id="continuar1">Continuar</button></td>
					<td><button class="btn btn-link" onclick="location.href='user.php'">Volver</button></td>
				</tr>
			</tbody>
			<tbody id="2">
			</tbody>
			<tbody id="3">
			</tbody>
			<tbody id="4">
				<tr><td><p></p></td></tr>
			</tbody>
	</table>
	<br><br>
</body>
</html>
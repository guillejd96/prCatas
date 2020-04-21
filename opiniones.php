<?php 

	include 'config.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$sqlPersona = "SELECT * FROM persona WHERE idUsuario=".$idUsuario;
	$resPersona = mysqli_query($conexion,$sqlPersona)->fetch_row();

	$idPersona = $resPersona[0];

	$idCata = $_GET['id'];

	$sqlCata = "SELECT * FROM cata WHERE id =".$idCata;
	$resCata = mysqli_query($conexion,$sqlCata)->fetch_row();

	$sqlPersonas = "SELECT idPersona FROM persona_cata WHERE idCata =".$idCata;
	$resPersonas = mysqli_query($conexion,$sqlPersonas);

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 	<title>Rellenar opiniones</title>
 	<script>
 		$(document).ready(function() {
 			$("#guardar").click(guardar);
 		});

 		function guardar(){
 			var apariencias = $("input[id='apariencia']")
              .map(function(){return $(this).val();}).get();
            var sabores = $("input[id='sabor']")
              .map(function(){return $(this).val();}).get();
            var aromas = $("input[id='aroma']")
              .map(function(){return $(this).val();}).get();
            var botellines = $("input[id='botellin']")
              .map(function(){return $(this).val();}).get();
            var cuerpos = $("input[id='cuerpo']")
              .map(function(){return $(this).val();}).get();

            var idPersonas = $(".idPersonas").map(function(index, elem) {
            	return $(elem).attr('data-id');
            }).get();

            var idCervezas = $(".idCervezas").map(function(index, elem) {
            	return $(elem).attr('data-id');
            }).get();

            var uniqueIDCervezas = [];
			$.each(idCervezas, function(i, el){
    			if($.inArray(el, uniqueIDCervezas) === -1) uniqueIDCervezas.push(el);
			});

			idCervezas = uniqueIDCervezas;

			var nCervezas = idCervezas.length;

			var error=false;

            for (var i = 0; i < idPersonas.length; i++) {
            	var idPersona = idPersonas[i];
            	
            	for (var j = 0; j < nCervezas; j++) {
            		var k = (i*2)+j;

            		var idCerveza = idCervezas[j];

            		var apariencia = apariencias[k];
            		var aroma = aromas[k];
            		var sabor = sabores[k];
            		var cuerpo = cuerpos[k];
            		var botellin = botellines[k];

            		var link = 'ajax/nuevaOpinion.php?p='+idPersona+'&c='+idCerveza+'&ar='+aroma+'&ap='+apariencia+'&s='+sabor+'&cu='+cuerpo+'&b='+botellin;

            		$.get(link, function(data) {
            			if(data!="1"){
            				error = true;
            			}
            		});
            	}
            }

            if(error){
            	$("#res").text("Error al insertar los datos");
                $("#res").css('color', 'red');
            } else {
            	$("#res").text("Se han introducido los datos correctamente. Redireccionando...");
                $("#res").css('color', 'green');
            	setTimeout(function () {
	       			window.location.replace("user.php");	
	    		},1000);
            }
 		}
 	</script>
 </head>
 <body>
 	<h1>Rellenar opiniones de <?php echo $resCata[1]?></h1>
	
 	<?php 

 		while($persona_cata = mysqli_fetch_array($resPersonas)){
 			$sqlPersonas = "SELECT * FROM persona WHERE id=".$persona_cata[0];
 			$persona = mysqli_query($conexion,$sqlPersonas)->fetch_row();

 			$sqlCervezas = "SELECT * FROM cerveza WHERE idCata =".$idCata;
			$resCervezas = mysqli_query($conexion,$sqlCervezas);

 			echo "<table id='datos'>";
 			echo "<tr>";
 			echo "<th class='idPersonas' data-id='".$persona[0]."'><p>".$persona[1]."</p></th>";
 			echo "<th><p>Apariencia</p></th>";
 			echo "<th><p>Aroma</p></th>";
 			echo "<th><p>Sabor</p></th>";
 			echo "<th><p>Cuerpo</p></th>";
 			echo "<th><p>Botellín</p></th>";
 			echo "</tr>";
 			while($cerveza = mysqli_fetch_array($resCervezas)){
 				echo "<tr>";
 				echo "<td class='idCervezas' data-id='".$cerveza[0]."'><p>".$cerveza[1]."</p></td>";
 				echo "<td><input type='number' id='apariencia' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='aroma' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='sabor' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='cuerpo' size='1' min='0' max='10'></td>";
 				echo "<td><input type='number' id='botellin' size='1' min='0' max='10'></td>";
 				echo "</tr>";
 			}
 			echo "</table>";
 		}


 	 ?>
	<table class="no_background">
        <tr><td colspan="2"><p id="res"></p></td></tr>
		<tr>
			<td><button id="guardar" class="btn btn-dark">Guardar</button></td>
			<td><button class="btn btn-link">Volver</button></td>
		</tr>
	</table>
 	<br>
 </body>
 </html>
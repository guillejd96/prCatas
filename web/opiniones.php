<?php 

	include 'config.php';
    include 'menus.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idPersona = $_SESSION["idUsuario"];

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
        var idCata;
 		$(document).ready(function() {
 			$("#guardar").click(guardar);
            idCata = <?php echo $idCata; ?>;
 		});

        function sum(input){
            var total =  0;
            for(var i=0;i<input.length;i++) {                  
                if(isNaN(input[i])){
                    continue;
                }
                total += Number(input[i]);
            }
            return total;
        }

        function volver(){
            window.location.replace("cata.php");
        }

 		function guardar(){
            $(".apariencia").css('border', '1px solid #ccc');
            $(".aroma").css('border', '1px solid #ccc');
            $(".sabor").css('border', '1px solid #ccc');
            $(".cuerpo").css('border', '1px solid #ccc');
            $(".botellin").css('border', '1px solid #ccc');
            var aux = $(".apariencia").map(function(index, elem) {
                return 1;
            })

            var nOpiniones = aux.length;

 			var apariencias = $(".apariencia")
              .map(function(index,elem){
                if($(elem).val()!="") {
                    return $(elem).val();
                }
            }).get();

            var aromas = $(".aroma")
              .map(function(index,elem){
                if($(elem).val()!="") {
                    return $(elem).val();
                }
            }).get();

            var cuerpos = $(".cuerpo")
              .map(function(index,elem){
                if($(elem).val()!="") {
                    return $(elem).val();
                }
            }).get();

            var botellines = $(".botellin")
              .map(function(index,elem){
                if($(elem).val()!="") {
                    return $(elem).val();
                }
            }).get();

            var sabores = $(".sabor")
              .map(function(index,elem){
                if($(elem).val()!="") {
                    return $(elem).val();
                }
            }).get();

            var error = false;
            $(':input[type="number"]').each(function(index, el) {
               if($(el).val()<0 || $(el).val()>10) error=true;
            }); 

            if(apariencias.length!=nOpiniones || sabores.length!=nOpiniones || aromas.length!=nOpiniones || botellines.length!=nOpiniones || cuerpos.length!=nOpiniones){
                $("#res").text("Introduce todas las opiniones");
                $("#res").css('color', 'red');
                $("#res").css('font-size', '15px');
                $(".aroma").each(function(index, el) {
                    if($(el).val()=="") $(el).css('border', '2px solid red');
                });
                $(".apariencia").each(function(index, el) {
                    if($(el).val()=="") $(el).css('border', '2px solid red');
                });
                $(".sabor").each(function(index, el) {
                    if($(el).val()=="") $(el).css('border', '2px solid red');
                });
                $(".cuerpo").each(function(index, el) {
                    if($(el).val()=="") $(el).css('border', '2px solid red');
                });
                $(".botellin").each(function(index, el) {
                    if($(el).val()=="") $(el).css('border', '2px solid red');
                });
            }else if(error){
                $("#res").text("Introduce valoraciones entre 0 y 10");
                $("#res").css('color', 'red');
                $("#res").css('font-size', '15px');
                $(".aroma").each(function(index, el) {
                    if($(el).val()<0 || $(el).val()>10) $(el).css('border', '2px solid red');
                });
                $(".apariencia").each(function(index, el) {
                    if($(el).val()<0 || $(el).val()>10) $(el).css('border', '2px solid red');
                });
                $(".sabor").each(function(index, el) {
                    if($(el).val()<0 || $(el).val()>10) $(el).css('border', '2px solid red');
                });
                $(".cuerpo").each(function(index, el) {
                    if($(el).val()<0 || $(el).val()>10) $(el).css('border', '2px solid red');
                });
                $(".botellin").each(function(index, el) {
                    if($(el).val()<0 || $(el).val()>10) $(el).css('border', '2px solid red');
                });
            }else {
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

                        $.post('ajax/nuevaOpinion.php', {idP: idPersona, idC: idCerveza, c: cuerpo, ar: aroma, ap: apariencia, s: sabor, b: botellin}, function(data, textStatus, xhr) {
                            if(data!="1"){
                                error = true;
                            }
                        });
                    }
                }

                if(error){
                    $("#res").text("Error al insertar los datos");
                    $("#res").css('color', 'red');
                    $("#res").css('font-size', '15px');
                } else {
                    $("#res").text("Se han introducido los datos correctamente. Redireccionando...");
                    $("#res").css('color', 'green');
                    $.post('ajax/calcularResultados.php', {id: idCata}, function(data, textStatus, xhr) {
                        if(data=="0"){
                            $("#res").text("Error al calcular los resultados");
                            $("#res").css('color', 'red');
                        }else {
                            setTimeout(function () {
                                window.location.replace("user.php");    
                            },1000);
                        }
                    });
                }
            }
 		}
 	</script>
 </head>
 <body>
    <?php echo banner(); ?>
    <?php echo arriba(); ?>
    <?php echo izquierda(); ?>
    <div class="main">
     	<h1>Valoraciones de <?php echo $resCata[1]?></h1>
    	
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
                    echo "<td class='idCervezas' data-id='".$cerveza[0]."'><p>".$cerveza[2]."</p></td>";
                    $resOpinion = mysqli_query($conexion,"SELECT * FROM opinion WHERE idPersona=".$persona[0]." AND idCerveza=".$cerveza[0]);
                    if(mysqli_num_rows($resOpinion)>0){
                        $row = $resOpinion->fetch_row();
                        echo "<td><input type='number' class='aroma form-control col-xs-1' size='1' min='0' max='10' value='".$row[3]."'></td>";
                        echo "<td><input type='number' class='apariencia form-control col-xs-1' size='1' min='0' max='10'  value='".$row[4]."'></td>";
                        echo "<td><input type='number' class='sabor form-control col-xs-1' size='1' min='0' max='10'  value='".$row[5]."'></td>";
                        echo "<td><input type='number' class='cuerpo form-control col-xs-1' size='1' min='0' max='10'  value='".$row[6]."'></td>";
                        echo "<td><input type='number' class='botellin form-control col-xs-1' size='1' min='0' max='10'  value='".$row[7]."'></td>";
                    }else {
                        echo "<td><input type='number' class='apariencia form-control col-xs-1' size='1' min='0' max='10'></td>";
                        echo "<td><input type='number' class='aroma form-control col-xs-1' size='1' min='0' max='10'></td>";
                        echo "<td><input type='number' class='sabor form-control col-xs-1' size='1' min='0' max='10'></td>";
                        echo "<td><input type='number' class='cuerpo form-control col-xs-1' size='1' min='0' max='10'></td>";
                        echo "<td><input type='number' class='botellin form-control col-xs-1' size='1' min='0' max='10'></td>";
                    }
     				
     				
     				echo "</tr>";
     			}
     			echo "</table><br>";
     		}


     	 ?>
    	<table class="simple">
            <tr><td colspan="2"><p id="res"></p></td></tr>
    		<tr>
    			<td><button id="guardar" class="btn btn-primary">Guardar</button></td>
    			<td><button class="btn btn-link" onclick="javascript:volver()">Volver</button></td>
    		</tr>
    	</table>
     	<br>
    </div>
 </body>
 </html>
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
	$nombrePersona = $resPersona[1];

	$sql = "SELECT idUsuario2 FROM amigos WHERE idUsuario1=".$idUsuario;
	$resAmigos = mysqli_query($conexion,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva cata</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		var personas,cervezas,nP,nC,nombreCata,fechaCata;

		function anyadirAmigo(){
			inputIndex = $('#modalAmigos').data('index');
			var aux = $("#amigos").val();
			aux = aux.split(";");
			var idAmigo = aux[0];
			var nombreAmigo = aux[1];
			var input = $(".nombre_personas").get(inputIndex);
			$(input).val(nombreAmigo);
			$(input).data('id', idAmigo);
			$(input).prop("readonly", true);
		}

		$(document).ready(function() {
			$("#continuar1").click(continuar1);
			$("#2").hide();
			$("#3").hide();
			$("#4").hide();
		});

		function showModal(i){
			$('#modalAmigos').data('index',i);
			$('#modalAmigos').modal('show');
		}

		function continuar1(){
			nombreCata = $("#nombre").val();
			fechaCata = $("#fecha").val();
			nP = $("#personas").val();
			nC = $("#cervezas").val();
			$("#nombre").css('border', '1px solid #ccc');
			$("#fecha").css('border', '1px solid #ccc');
			$("#personas").css('border', '1px solid #ccc');
			$("#cervezas").css('border', '1px solid #ccc');
			$(".error").text('');
			nP=nP-1;

			if(nombreCata==""){
				$(".error").text('Introduce un nombre para la cata');
				$(".error").css('color', 'red');
				$(".error").css('font-size', '16px');
				$("#nombre").css('border', '2px solid red');
			}else if(fechaCata==""){
				$(".error").text('Introduce la fecha de la cata');
				$(".error").css('color', 'red');
				$(".error").css('font-size', '16px');
				$("#fecha").css('border', '2px solid red');
			}else if(nP<1 || nC<1){
				$(".error").text('Introduce un número positivo de personas y cervezas');
				$(".error").css('color', 'red');
				$(".error").css('font-size', '16px');
				$("#personas").css('border', '2px solid red');
				$("#cervezas").css('border', '2px solid red');
			}else{
				$("#1").hide();

				$("#2").append('<tr><td colspan="2"><p>Personas</p></td></tr>')

				$("#2").append('<tr><td colspan="2"><p><?php echo $nombrePersona; ?></p></td></tr>')

				for (var i = 0; i < nP; i++) {
					$("#2").append('<tr><td colspan="2"><div class="input-group"><input type="text" class="nombre_personas form-control" size="75"><span class="input-group-addon" title="Añadir amigo" onclick="javascript:showModal('+i+')"><i class="fas fa-plus"></i></span></div><br></td></tr>')
				}

				$("#2").append('<tr><td colspan="2"><p class="error"></p></td></tr><tr><td><button class="btn btn-primary" id="continuar2" onclick="javascript:continuar2()">Continuar</button></td><td><button class="btn btn-link" onclick="volver1()">Volver</button></td></tr></tr>');

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
			$(".nombre_personas").each(function(index, el) {
            		if($(el).val()=="") {
            			$(el).css('border', '2px solid red');
            		} else {
            			$(el).css('border', '1px solid #ccc');
            		}
            	});
			$(".error").text("");
			$("#3").empty();
		}

		function continuar2(){
			personas = $(".nombre_personas").map(function(index, elem) {
            	if($(elem).val()!=""){
            		var toReturn=$(elem).val();
            		if($(elem).data("id")!=undefined){
            			toReturn = toReturn+";"+$(elem).data("id");
            		}
            		return toReturn;
            	}
            }).get();

            if(personas.length!=nP){
            	$(".error").text("Introduce todos los nombres de las personas");
            	$(".error").css('color', 'red');
            	$(".error").css('font-size', '14px');
            	$(".nombre_personas").each(function(index, el) {
            		if($(el).val()=="") {
            			$(el).css('border', '2px solid red');
            		} else {
            			$(el).css('border', '1px solid #ccc');
            		}
            	});
            } else {
            	$("#2").hide();

	        	$("#3").append('<tr><td colspan="2"><p>Cervezas</p></td></tr>');

	            for (var i = 0; i < nC; i++) {
					$("#3").append('<tr><td colspan="2"><input type="text" class="nombre_cervezas form-control" size="75"><br></td></tr>')
				}

				$("#3").append('<tr><td><p></p></td></tr>');

	            $("#3").append('<tr><td colspan="2"><p class="error"></p></td></tr><tr><td><button class="btn btn-primary" id="continuar3" onclick="javascript:continuar3()">Continuar</button></td><td><button class="btn btn-link" onclick="volver2()">Volver</button></td></tr></tr>');

	            $(".progress-bar").css('width', '66%');
				$(".progress-bar").children('p').text('2/3');

				$("#3").show();
            }
        }
		

		function continuar3(){
			cervezas = $(".nombre_cervezas").map(function(index, elem) {
            	if($(elem).val()!="") return $(elem).val();
            }).get();

            if(cervezas.length!=nC){
            	$(".error").text("Introduce todos los nombres de las cervezas");
            	$(".error").css('color', 'red');
            	$(".error").css('font-size', '14px');
            	$(".nombre_cervezas").each(function(index, el) {
            		if($(el).val()=="") {
            			$(el).css('border', '2px solid red');
            		} else {
            			$(el).css('border', '1px solid #ccc');
            		}
            	});
            }else {
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
	            			var aux = item.split(";");
	            			if(aux.length>1){
	            				var nombre = aux[0];
	            				var idAmigo = aux[1];
	            				if(!error1){
		            				$.get('ajax/anyadirPersona.php?&c='+idCata+'&n='+idAmigo, function(data) {
			            				if(data=="0"){
			            					$("#4").find('p').text('Error al añadir el amigo a la cata');
			            					$("#4").find('p').css('color', 'red');
			            					error1=true;
			            				}
			            			});
		            			}
	            			} else {
	            				if(!error1){
		            				$.get('ajax/nuevaPersona.php?n='+item+'&c='+idCata, function(data) {
			            				if(data=="0"){
			            					$("#4").find('p').text('Error al insertar las personas en base de datos');
			            					$("#4").find('p').css('color', 'red');
			            					error1=true;
			            				}
			            			});
		            			}
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
		}
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h2>Nueva cata</h2>
			<table width="600px">
				<thead>
					<tr>
						<th colspan="2">
							<div class="progress">
			  					<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
			  						<p>0/3</p>
			  					</div>
							</div>
						</th>
					</tr>
				</thead>
				<tbody id="1">
					<tr>
						<td><p>Nombre de la cata:&nbsp;&nbsp;</p></td>
						<td><input type="text" id="nombre" class="form-control"></td>
					</tr>
					<tr>
						<td><p>Fecha de la cata:&nbsp;&nbsp;</p></td>
						<td><input type="date" id="fecha" class="form-control"></td>
					</tr>
					<tr>
						<td><p>Número de Personas:&nbsp;&nbsp;</p></td>
						<td><input type="number" id="personas" min="0" class="form-control"></td>
					</tr>
					<tr>
						<td><p>Número de Cervezas:&nbsp;&nbsp;</p></td>
						<td><input type="number" id="cervezas" min="0" class="form-control"></td>
					</tr>
					<tr>
						<td colspan="2">
							<p class="error"></p>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button class="btn btn-primary" id="continuar1">Continuar</button></td>
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
		<div class="modal fade" id="modalAmigos" role="dialog">
    	<div class="modal-dialog modal-lg">
      		<div class="modal-content">
        		<div class="modal-header">
        			<h3 class="modal-title">Añadir amigo a la cata</h3>
        		</div>
        		<div class="modal-body">
        			
        				<?php 
        					if(mysqli_num_rows($resAmigos)>0){
        						echo '<select id="amigos" class="browser-default custom-select custom-select-lg mb-3">';
	        					while($row = mysqli_fetch_array($resAmigos)){
	        						$idAmigo = $row[0];
	        						$usuarioAmigo = mysqli_query($conexion,"SELECT usuario FROM usuario WHERE id =".$idAmigo)->fetch_row()[0];
	        						$nombreAmigo = mysqli_query($conexion,"SELECT  nombre FROM persona WHERE idUsuario=".$idAmigo)->fetch_row()[0];
	        						echo "<option value='".$idAmigo.";".$nombreAmigo."'>".$nombreAmigo." (".$usuarioAmigo.")</option>";
	        					}
        					}else{
        						echo "<p style='font-size: 20px'>Todavía no has agregado a ningún amigo</p>";
        					}

        				 ?>
        			</select>
        		</div>
        		<div class="modal-footer">
        			<button type="button" class="btn btn-primary" onclick="anyadirAmigo()" data-dismiss="modal">Añadir</button>
          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        		</div>
      		</div>
    	</div>
  	</div>
	</div>
  	
</body>
</html>
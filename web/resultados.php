<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	function getAromaList($s){
		$array = [];
		$aux = explode("/",$s);

		for($i=0;$i<count($aux);$i++){
			$cerveza = $aux[$i];

			$aux2 = explode(";",$cerveza);

			$idCerveza = $aux2[0];
			$values = $aux2[1];

			$aux3 = explode(",",$values);

			$aroma = $aux3[0];

			$array[$idCerveza]=$aroma;
		}

		arsort($array);

		return $array;
	}

	function getAparienciaList($s){
		$array = [];
		$aux = explode("/",$s);
		for($i=0;$i<count($aux);$i++){
			$cerveza = $aux[$i];
			$aux2 = explode(";",$cerveza);

			$idCerveza = $aux2[0];
			$values = $aux2[1];

			$aux3 = explode(",",$values);

			$apariencia = $aux3[1];

			$array[$idCerveza]=$apariencia;
		}

		arsort($array);

		return $array;
	}

	function getSaborList($s){
		$array = [];
		$aux = explode("/",$s);
		for($i=0;$i<count($aux);$i++){
			$cerveza = $aux[$i];
			$aux2 = explode(";",$cerveza);

			$idCerveza = $aux2[0];
			$values = $aux2[1];

			$aux3 = explode(",",$values);

			$sabor = $aux3[2];

			$array[$idCerveza]=$sabor;
		}

		arsort($array);

		return $array;
	}

	function getCuerpoList($s){
		$array = [];
		$aux = explode("/",$s);
		for($i=0;$i<count($aux);$i++){
			$cerveza = $aux[$i];
			$aux2 = explode(";",$cerveza);

			$idCerveza = $aux2[0];
			$values = $aux2[1];

			$aux3 = explode(",",$values);

			$cuerpo = $aux3[3];

			$array[$idCerveza]=$cuerpo;
		}

		arsort($array);

		return $array;
	}

	function getBotellinList($s){
		$array = [];
		$aux = explode("/",$s);
		for($i=0;$i<count($aux);$i++){
			$cerveza = $aux[$i];
			$aux2 = explode(";",$cerveza);

			$idCerveza = $aux2[0];
			$values = $aux2[1];

			$aux3 = explode(",",$values);

			$aroma = $aux3[4];

			$array[$idCerveza]=$aroma;
		}

		arsort($array);

		return $array;
	}

	function getMediaList($s){
		$array = [];
		$aux = explode("/",$s);
		for($i=0;$i<count($aux);$i++){
			$cerveza = $aux[$i];
			$aux2 = explode(";",$cerveza);

			$idCerveza = $aux2[0];
			$values = $aux2[1];

			$aux3 = explode(",",$values);

			$media = $aux3[5];

			$array[$idCerveza]=$media;
		}

		arsort($array);

		return $array;
	}

	$idUsuario = $_SESSION["idUsuario"];

	$idPersona = mysqli_query($conexion,"SELECT id FROM persona WHERE idUsuario=".$idUsuario)->fetch_row()[0];

	$idCata = $_GET['id'];

	$res = mysqli_query($conexion,"SELECT * FROM persona_cata WHERE idPersona=".$idPersona." AND idCata=".$idCata);
	if(mysqli_num_rows($res)==0){
		header('Location: index.php');
	}

	$nombreCata = mysqli_query($conexion, "SELECT nombre FROM cata WHERE id=".$idCata)->fetch_row()[0];

	$resCervezas = mysqli_query($conexion,"SELECT id FROM cerveza WHERE idCata=".$idCata);

	$s="";

	while($cerveza = mysqli_fetch_array($resCervezas)){
		$idCerveza = $cerveza[0];
		$resMedia = mysqli_query($conexion,"SELECT AVG(aroma),AVG(apariencia),AVG(sabor),AVG(cuerpo),AVG(botellin) FROM opinion WHERE idCerveza=".$idCerveza);
		$row = $resMedia->fetch_row();

		$mediaAroma = round($row[0],2);
		$mediaApariencia = round($row[1],2);
		$mediaSabor = round($row[2],2);
		$mediaCuerpo = round($row[3],2);
		$mediaBotellin = round($row[4],2);
		$media = round(($mediaAroma+$mediaApariencia+$mediaSabor+$mediaCuerpo+$mediaBotellin)/5,2);

		$s = $s.$idCerveza.";".$mediaAroma.",".$mediaApariencia.",".$mediaSabor.",".$mediaCuerpo.",".$mediaBotellin.",".$media."/";
	}

	$s=substr($s,0,-1);

	$aromaList = getAromaList($s);
	$aparienciaList = getAparienciaList($s);
	$saborList = getSaborList($s);
	$cuerpoList = getCuerpoList($s);
	$botellinList = getBotellinList($s);
	$mediaList = getMediaList($s);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Resultados</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- CANVAS JS -->
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
	<script>
	var idCata = <?php echo $idCata; ?>;

	function create_chart (container,data) {
		var chart = new CanvasJS.Chart(container,{
			data: [ 
			{ 
				type: "column", 
				toolTipContent: "{label}: {y}", 
				dataPoints: data
			} 
			] 
		});
		chart.render();
	}

	$(document).ready(function() {
		$.post('ajax/getMejoresJuecesMedia.php', {id: idCata}, function(data, textStatus, xhr) {
			var res = data.split(";");
			var dict = {};
			for(var i=0;i<res.length;i++){
				var r = res[i];
				var aux = r.split(",");
				var nombre = aux[0];
				var value = aux[1];
				dict[nombre]=value;
			}
			var items = Object.keys(dict).map(function(key) {
  				return [key, dict[key]];
			});
			items.sort(function(first, second) {
  				return first[1] - second[1];
			});
			for(var i=0;i<items.length;i++){
				var aux = items[i]+"";
				var j = aux.split(",");
				var nombre = j[0];
				var value = j[1];
				$("#Jmedia").append('<tr><td><p>'+(i+1)+'º</p></td><td><p class="nombreJuez">'+nombre+'</p></td><td><p class="value">'+value+'</p></td></tr>');
			}
			var datos = [];
			$("#Jmedia").find(".nombreJuez").each(function(index, el) {
				var nombre = el.innerText;
				var value = $("#Jmedia").find(".value").get(index).innerText;
				datos.push({label: nombre,y: parseFloat(value)});
			});
			create_chart("juez-media",datos);
		});
	 	$.post('ajax/getMejoresJuecesAroma.php', {id: idCata}, function(data, textStatus, xhr) {
	 		var res = data.split(";");
			var dict = {};
			for(var i=0;i<res.length;i++){
				var r = res[i];
				var aux = r.split(",");
				var nombre = aux[0];
				var value = aux[1];
				dict[nombre]=value;
			}
			var items = Object.keys(dict).map(function(key) {
  				return [key, dict[key]];
			});
			items.sort(function(first, second) {
  				return first[1] - second[1];
			});
			for(var i=0;i<items.length;i++){
				var aux = items[i]+"";
				var j = aux.split(",");
				var nombre = j[0];
				var value = j[1];
				$("#Jaroma").append('<tr><td><p>'+(i+1)+'º</p></td><td><p class="nombreJuez">'+nombre+'</p></td><td><p class="value">'+value+'</p></td></tr>');
			}
			var datos = [];
			$("#Jaroma").find(".nombreJuez").each(function(index, el) {
				var nombre = el.innerText;
				var value = $("#Jaroma").find(".value").get(index).innerText;
				datos.push({label: nombre,y: parseFloat(value)});
			});
			create_chart("juez-aroma",datos);
		});
		$.post('ajax/getMejoresJuecesApariencia.php', {id: idCata}, function(data, textStatus, xhr) {
			var res = data.split(";");
			var dict = {};
			for(var i=0;i<res.length;i++){
				var r = res[i];
				var aux = r.split(",");
				var nombre = aux[0];
				var value = aux[1];
				dict[nombre]=value;
			}
			var items = Object.keys(dict).map(function(key) {
  				return [key, dict[key]];
			});
			items.sort(function(first, second) {
  				return first[1] - second[1];
			});
			for(var i=0;i<items.length;i++){
				var aux = items[i]+"";
				var j = aux.split(",");
				var nombre = j[0];
				var value = j[1];
				$("#Japariencia").append('<tr><td><p>'+(i+1)+'º</p></td><td><p class="nombreJuez">'+nombre+'</p></td><td><p class="value">'+value+'</p></td></tr>');
			}
			var datos = [];
			$("#Japariencia").find(".nombreJuez").each(function(index, el) {
				var nombre = el.innerText;
				var value = $("#Japariencia").find(".value").get(index).innerText;
				datos.push({label: nombre,y: parseFloat(value)});
			});
			create_chart("juez-apariencia",datos);
		});
		$.post('ajax/getMejoresJuecesSabor.php', {id: idCata}, function(data, textStatus, xhr) {
			var res = data.split(";");
			var dict = {};
			for(var i=0;i<res.length;i++){
				var r = res[i];
				var aux = r.split(",");
				var nombre = aux[0];
				var value = aux[1];
				dict[nombre]=value;
			}
			var items = Object.keys(dict).map(function(key) {
  				return [key, dict[key]];
			});
			items.sort(function(first, second) {
  				return first[1] - second[1];
			});
			for(var i=0;i<items.length;i++){
				var aux = items[i]+"";
				var j = aux.split(",");
				var nombre = j[0];
				var value = j[1];
				$("#Jsabor").append('<tr><td><p>'+(i+1)+'º</p></td><td><p class="nombreJuez">'+nombre+'</p></td><td><p class="value">'+value+'</p></td></tr>');
			}
			var datos = [];
			$("#Jsabor").find(".nombreJuez").each(function(index, el) {
				var nombre = el.innerText;
				var value = $("#Jsabor").find(".value").get(index).innerText;
				datos.push({label: nombre,y: parseFloat(value)});
			});
			create_chart("juez-sabor",datos);
		});
		$.post('ajax/getMejoresJuecesCuerpo.php', {id: idCata}, function(data, textStatus, xhr) {
			var res = data.split(";");
			var dict = {};
			for(var i=0;i<res.length;i++){
				var r = res[i];
				var aux = r.split(",");
				var nombre = aux[0];
				var value = aux[1];
				dict[nombre]=value;
			}
			var items = Object.keys(dict).map(function(key) {
  				return [key, dict[key]];
			});
			items.sort(function(first, second) {
  				return first[1] - second[1];
			});
			for(var i=0;i<items.length;i++){
				var aux = items[i]+"";
				var j = aux.split(",");
				var nombre = j[0];
				var value = j[1];
				$("#Jcuerpo").append('<tr><td><p>'+(i+1)+'º</p></td><td><p class="nombreJuez">'+nombre+'</p></td><td><p class="value">'+value+'</p></td></tr>');
			}
			var datos = [];
			$("#Jcuerpo").find(".nombreJuez").each(function(index, el) {
				var nombre = el.innerText;
				var value = $("#Jcuerpo").find(".value").get(index).innerText;
				datos.push({label: nombre,y: parseFloat(value)});
			});
			create_chart("juez-cuerpo",datos);
		});
		$.post('ajax/getMejoresJuecesBotellin.php', {id: idCata}, function(data, textStatus, xhr) {
			var res = data.split(";");
			var dict = {};
			for(var i=0;i<res.length;i++){
				var r = res[i];
				var aux = r.split(",");
				var nombre = aux[0];
				var value = aux[1];
				dict[nombre]=value;
			}
			var items = Object.keys(dict).map(function(key) {
  				return [key, dict[key]];
			});
			items.sort(function(first, second) {
  				return first[1] - second[1];
			});
			for(var i=0;i<items.length;i++){
				var aux = items[i]+"";
				var j = aux.split(",");
				var nombre = j[0];
				var value = j[1];
				$("#Jbotellin").append('<tr><td><p>'+(i+1)+'º</p></td><td><p class="nombreJuez">'+nombre+'</p></td><td><p class="value">'+value+'</p></td></tr>');
			}
			var datos = [];
			$("#Jbotellin").find(".nombreJuez").each(function(index, el) {
				var nombre = el.innerText;
				var value = $("#Jbotellin").find(".value").get(index).innerText;
				datos.push({label: nombre,y: parseFloat(value)});
			});
			create_chart("juez-botellin",datos);
		});
	});
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<h2 align="left" style="margin-left: 2%">Los resultados de <?php echo $nombreCata; ?> son los siguientes:</h2><br>
		<table width="900" id="table1">
			<tr>
				<th colspan="3"><p>Mejores cervezas de media <a title='Ver gráfico' data-toggle="modal" data-target="#modalCervezaMedia"><i class="far fa-chart-bar"></i></a></p></th>
			</tr>
			<?php 
				$keys = array_keys($mediaList);
				$values = array_values($mediaList);
				for($i=0;$i<count($mediaList);$i++){
					echo "<tr>";
					echo "<td><p>".($i+1)."º</p></td>";

					$idCerveza = $keys[$i];
					$value = $values[$i];

					$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

					echo "<td><p class='nombreCerveza'>".$nombre."</p></td>";
					echo "<td><p class='value'>".$value."</p></td>";

					echo "</tr>";
				}
			 ?>
		</table>
		<table class="simple">
			<tr>
				<td>
					<table id='table2'>
						<tr>
							<th colspan="3"><p>Mejores cervezas por aroma <a title='Ver gráfico' data-toggle="modal" data-target="#modalCervezaAroma"><i class="far fa-chart-bar"/></a></p></th>
						</tr>
						<?php 
							$keys = array_keys($aromaList);
							$values = array_values($aromaList);
							for($i=0;$i<count($aromaList);$i++){
								echo "<tr>";
								echo "<td><p>".($i+1)."º</p></td>";

								$idCerveza = $keys[$i];
								$value = $values[$i];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<td><p class='nombreCerveza'>".$nombre."</p></td>";
								echo "<td><p class='value'>".$value."</p></td>";

								echo "</tr>";
							}
						 ?>
					</table>
					<br>
				</td>
				<td>
					<table id='table3'>
						<tr>
							<th colspan="3"><p>Mejores cervezas por apariencia <a title='Ver gráfico' data-toggle="modal" data-target="#modalCervezaApariencia"><i class="far fa-chart-bar"/></a></p></th>
						</tr>
						<?php 
							$keys = array_keys($aparienciaList);
							$values = array_values($aparienciaList);
							for($i=0;$i<count($aparienciaList);$i++){
								echo "<tr>";
								echo "<td><p>".($i+1)."º</p></td>";

								$idCerveza = $keys[$i];
								$value = $values[$i];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<td><p class='nombreCerveza'>".$nombre."</p></td>";
								echo "<td><p class='value'>".$value."</p></td>";

								echo "</tr>";
							}
						 ?>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<table id='table4'>
						<tr>
							<th colspan="3"><p>Mejores cervezas por sabor <a title='Ver gráfico' data-toggle="modal" data-target="#modalCervezaSabor"><i class="far fa-chart-bar"/></a></p></th>
						</tr>
						<?php 
							$keys = array_keys($saborList);
							$values = array_values($saborList);
							for($i=0;$i<count($saborList);$i++){
								echo "<tr>";
								echo "<td><p>".($i+1)."º</p></td>";

								$idCerveza = $keys[$i];
								$value = $values[$i];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<td><p class='nombreCerveza'>".$nombre."</p></td>";
								echo "<td><p class='value'>".$value."</p></td>";

								echo "</tr>";
							}
						 ?>
					</table>
					<br>
				</td>
				<td>
					<table id='table5'>
						<tr>
							<th colspan="3"><p>Mejores cervezas por cuerpo <a title='Ver gráfico' data-toggle="modal" data-target="#modalCervezaCuerpo"><i class="far fa-chart-bar"/></a></p></th>
						</tr>
						<?php 
							$keys = array_keys($cuerpoList);
							$values = array_values($cuerpoList);
							for($i=0;$i<count($cuerpoList);$i++){
								echo "<tr>";
								echo "<td><p>".($i+1)."º</p></td>";

								$idCerveza = $keys[$i];
								$value = $values[$i];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<td><p class='nombreCerveza'>".$nombre."</p></td>";
								echo "<td><p class='value'>".$value."</p></td>";

								echo "</tr>";
							}
						 ?>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id='table6'>
						<tr>
							<th colspan="3"><p>Mejores cervezas por botellin <a title='Ver gráfico' data-toggle="modal" data-target="#modalCervezaBotellin"><i class="far fa-chart-bar"/></a></p></th>
						</tr>
						<?php 
							$keys = array_keys($botellinList);
							$values = array_values($botellinList);
							for($i=0;$i<count($botellinList);$i++){
								echo "<tr>";
								echo "<td><p>".($i+1)."º</p></td>";

								$idCerveza = $keys[$i];
								$value = $values[$i];

								$nombre = mysqli_query($conexion,"SELECT nombre FROM cerveza WHERE id=".$idCerveza)->fetch_row()[0];

								echo "<td><p class='nombreCerveza'>".$nombre."</p></td>";
								echo "<td><p class='value'>".$value."</p></td>";

								echo "</tr>";
							}
						 ?>
					</table>
				</td>
			</tr>
		</table>
		<table class="simple">
			<tr>
				<td colspan="2">
					<table id="Jmedia">
						<tr>
							<th colspan="3"><p>Mejores jueces de media <a title='Ver gráfico' data-toggle="modal" data-target="#modalJuezMedia"><i class="far fa-chart-bar"></i></a></p></th>
						</tr>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<table id="Jaroma" class='table2'>
						<tr>
							<th colspan="3"><p>Mejores jueces por aroma <a title='Ver gráfico' data-toggle="modal" data-target="#modalJuezAroma"><i class="far fa-chart-bar"></i></a></p></th>
						</tr>
					</table>
					<br>
				</td>
				<td>
					<table id="Japariencia" class='table3'>
						<tr>
							<th colspan="3"><p>Mejores jueces por apariencia <a title='Ver gráfico' data-toggle="modal" data-target="#modalJuezApariencia"><i class="far fa-chart-bar"></i></a></p></th>
						</tr>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<table id="Jsabor" class='table4'>
						<tr>
							<th colspan="3"><p>Mejores jueces por sabor <a title='Ver gráfico' data-toggle="modal" data-target="#modalJuezSabor"><i class="far fa-chart-bar"></i></a></p></th>
						</tr>
					</table>
					<br>
				</td>
				<td>
					<table id="Jcuerpo" class='table5'>
						<tr>
							<th colspan="3"><p>Mejores jueces por cuerpo <a title='Ver gráfico' data-toggle="modal" data-target="#modalJuezCuerpo"><i class="far fa-chart-bar"></i></a></p></th>
						</tr>
					</table>
					<br>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id="Jbotellin" class='table6'>
						<tr>
							<th colspan="3"><p>Mejores jueces por botellín <a title='Ver gráfico' data-toggle="modal" data-target="#modalJuezBotellin"><i class="far fa-chart-bar"></i></a></p></th>
						</tr>
					</table>
					<br>
				</td>
			</tr>
		</table><br>
		<!-- MODAL MEJORES CERVEZAS MEDIA -->
		<div class="modal fade" id="modalCervezaMedia" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores cervezas de media</h3>
	        		</div>
	        		<div class="modal-body">
						<div id="cerveza-media" style="height: 400px; width: 400px"></div>
						<script>
							var datos = [];
							$("#table1").find(".nombreCerveza").each(function(index, el) {
								var nombre = el.innerText;
								var value = $("#table1").find(".value").get(index).innerText;
								datos.push({label: nombre,y: parseFloat(value)});
							});
							create_chart("cerveza-media",datos);
						</script>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
		<!-- MODAL MEJORES CERVEZAS AROMA -->
		<div class="modal fade" id="modalCervezaAroma" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores cervezas por aroma</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="cerveza-aroma" style="height: 360px; width: 400px"></div>
						<script>
							var datos = [];
							$("#table2").find(".nombreCerveza").each(function(index, el) {
								var nombre = el.innerText;
								var value = $("#table2").find(".value").get(index).innerText;
								datos.push({label: nombre,y: parseFloat(value)});
							});
							create_chart("cerveza-aroma",datos);
						</script>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES CERVEZAS APARIENCIA -->
		<div class="modal fade" id="modalCervezaApariencia" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores cervezas por apariencia</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="cerveza-apariencia" style="height: 360px; width: 400px"></div>
						<script>
							var datos = [];
							$("#table3").find(".nombreCerveza").each(function(index, el) {
								var nombre = el.innerText;
								var value = $("#table3").find(".value").get(index).innerText;
								datos.push({label: nombre,y: parseFloat(value)});
							});
							create_chart("cerveza-apariencia",datos);
						</script>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES CERVEZAS SABOR -->
		<div class="modal fade" id="modalCervezaSabor" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores cervezas por sabor</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="cerveza-sabor" style="height: 360px; width: 400px"></div>
						<script>
							var datos = [];
							$("#table4").find(".nombreCerveza").each(function(index, el) {
								var nombre = el.innerText;
								var value = $("#table4").find(".value").get(index).innerText;
								datos.push({label: nombre,y: parseFloat(value)});
							});
							create_chart("cerveza-sabor",datos);
						</script>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES CERVEZAS CUERPO -->
		<div class="modal fade" id="modalCervezaCuerpo" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores cervezas por cuerpo</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="cerveza-cuerpo" style="height: 360px; width: 400px"></div>
						<script>
							var datos = [];
							$("#table5").find(".nombreCerveza").each(function(index, el) {
								var nombre = el.innerText;
								var value = $("#table5").find(".value").get(index).innerText;
								datos.push({label: nombre,y: parseFloat(value)});
							});
							create_chart("cerveza-cuerpo",datos);
						</script>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES CERVEZAS BOTELLIN -->
		<div class="modal fade" id="modalCervezaBotellin" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores cervezas por botellín</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="cerveza-botellin" style="height: 360px; width: 400px"></div>
						<script>
							var datos = [];
							$("#table6").find(".nombreCerveza").each(function(index, el) {
								var nombre = el.innerText;
								var value = $("#table6").find(".value").get(index).innerText;
								datos.push({label: nombre,y: parseFloat(value)});
							});
							create_chart("cerveza-botellin",datos);
						</script>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES JUECES MEDIA -->
		<div class="modal fade" id="modalJuezMedia" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores jueces de media</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="juez-media" style="height: 360px; width: 400px"></div>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES JUECES AROMA -->
		<div class="modal fade" id="modalJuezAroma" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores jueces por aroma</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="juez-aroma" style="height: 360px; width: 400px"></div>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES JUECES APARIENCIA -->
		<div class="modal fade" id="modalJuezApariencia" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores jueces por apariencia</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="juez-apariencia" style="height: 360px; width: 400px"></div>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES JUECES SABOR -->
		<div class="modal fade" id="modalJuezSabor" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores jueces por sabor</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="juez-sabor" style="height: 360px; width: 400px"></div>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES JUECES CUERPO -->
		<div class="modal fade" id="modalJuezCuerpo" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores jueces por cuerpo</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="juez-cuerpo" style="height: 360px; width: 400px"></div>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	    <!-- MODAL MEJORES JUECES BOTELLIN -->
		<div class="modal fade" id="modalJuezBotellin" role="dialog">
	    	<div class="modal-dialog modal-lg">
	      		<div class="modal-content">
	        		<div class="modal-header">
	        			<h3>Mejores jueces por botellín</h3>
	        		</div>
	        		<div class="modal-body" style='align-content: center'>
						<div id="juez-botellin" style="height: 360px; width: 400px"></div>
	        		</div>
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	      		</div>
	    	</div>
	    </div>
	</div>
</body>
</html>
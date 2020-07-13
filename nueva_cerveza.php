<?php 

	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva cerveza</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		function guardar(){
			$("#nombre").css('border', '1px solid #ccc');
			$("#aroma").css('border', '1px solid #ccc');
			$("#apariencia").css('border', '1px solid #ccc');
			$("#sabor").css('border', '1px solid #ccc');
			$("#cuerpo").css('border', '1px solid #ccc');
			$("#botellin").css('border', '1px solid #ccc');
			var n = $("#nombre").val();
			var ar = $("#aroma").val();
			var ap = $("#apariencia").val();
			var s = $("#sabor").val();
			var c = $("#cuerpo").val();
			var b = $("#botellin").val();
			var error = false;
			if(n==""){
				error=true;
				$("#nombre").css('border', '1px solid red');
			}
			if(ar==""){
				error=true;
				$("#aroma").css('border', '1px solid red');
			}
			if(ap==""){
				error=true;
				$("#apariencia").css('border', '1px solid red');
			}
			if(s==""){
				error=true;
				$("#sabor").css('border', '1px solid red');
			}
			if(c==""){
				error=true;
				$("#cuerpo").css('border', '1px solid red');
			}
			if(b==""){
				error=true;
				$("#botellin").css('border', '1px solid red');
			}
			if (error) {
				$("#error").text("Introduce todos los campos");
				$("#error").css('font-size', '18px');
				$("#error").css('color', 'red');
			}else {
				$.post('ajax/nuevaCervezaIndividual.php', {n: n, ar: ar, ap: ap, s: s, c: c, b: b}, function(data, textStatus, xhr) {
					if(data!="1"){
						$("#error").text("Se produjo un error en la inserción");
						$("#error").css('font-size', '18px');
						$("#error").css('color', 'red');
					}else {
						$("#error").text("La operación se produjo con éxito");
						$("#error").css('font-size', '18px');
						$("#error").css('color', 'green');
						var n = $("#nombre").val("");
						var ar = $("#aroma").val("");
						var ap = $("#apariencia").val("");
						var s = $("#sabor").val("");
						var c = $("#cuerpo").val("");
						var b = $("#botellin").val("");
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
		<h2>Nueva cerveza</h2>
		<table>
			<tr>
				<th>
					<p>Nombre</p>
				</th>
				<th>
					<p>Aroma</p>
				</th>
				<th>
					<p>Apariencia</p>
				</th>
				<th>
					<p>Sabor</p>
				</th>
				<th>
					<p>Cuerpo</p>
				</th>
				<th>
					<p>Botellín</p>
				</th>
			</tr>
			<tr>
				<td><input type="text" id="nombre" class="form-control"></td>
				<td><input type="number" id="aroma" min="0" max="10" class="form-control" size="2"></td>
				<td><input type="number" id="apariencia" min="0" max="10" class="form-control" size="2"></td>
				<td><input type="number" id="sabor" min="0" max="10" class="form-control" size="2"></td>
				<td><input type="number" id="cuerpo" min="0" max="10" class="form-control" size="2"></td>
				<td><input type="number" id="botellin" min="0" max="10" class="form-control" size="2"></td>
			</tr>
		</table>
		<p id="error"></p>
		<button class="btn btn-info" onclick="javascript:guardar()">Guardar</button>
	</div>
</body>
</html>
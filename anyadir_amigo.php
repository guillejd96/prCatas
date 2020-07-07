<?php 
	include 'config.php';
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
	<title>Añadir amigos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		var amigos;

		function add(id){
			$.post('ajax/anyadirAmigo', {id: id}, function(data, textStatus, xhr) {
				if(data=="1"){
					$("#res").append("La solicitud se envió correctamente");
				}else{
					$("#res").append("No se ha podido enviar la solicitud de amistad");
				}
			});
		}

		function buscar(){
			$("#res").empty();
			var usuario = $("#usuario").val();
			if(usuario!=""){
				$.post('ajax/buscarUsuario.php', {usuario: usuario}, function(data, textStatus, xhr) {
				if(data=="null"){
					$("#res").append("<p>No se han encontrado coincidencias</p>");
				} else{
					$("#res").append("<table id='table_res' style='width: 100rem'><tr><th><p>Usuario</p></th><th><p>Nombre</p></th><th><p>Agregar</p></th></tr></table>");
					var personas = data.split(",");
					$.get('ajax/buscarAmigos.php', function(data) {
						amigos = data.split(";");
						for(var i=0;i<personas.length-1;i++){
							var p = personas[i].split(":");
							var id = p[0]
							var usuario = p[1];
							var nombre = p[2];
							if(!amigos.includes(id)){
								$("#table_res").append("<tr><td><p>"+usuario+"</p></td><td><p>"+nombre+"</p></td><td><a href='javascript:add("+id+")'><p><i class='fas fa-user-plus'></i></p></a></td></tr>");
							}
						}
					});
				}
				});
			} else {
				$("#res").append("<p>No se ha introducido ninguna búsqueda</p>");
			}
			
		}
	</script>
</head>
<body>
	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
		<table>
			<tr>
				<td><p>Introduce un usuario: </p></td>
				<td><input type="text" id="usuario" class="form-control"></td>
				<td><button class="btn btn_info" onclick="javascript:buscar()">Buscar</button></td>
			</tr>
		</table>
		<br>
		<div id="res"></div>
	</div>
</body>
</html>
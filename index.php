<?php 

session_start();

include "config.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/index.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<title>Inicio</title>
	<script>
		function entrar(){
			var user = $("#user").val();
			var pass = $("#pass").val();

			$.get('ajax/buscarUsuario.php?u='+user+'&p='+pass, function(data) {
				if(data!="error"){
					$.get('ajax/login.php?u='+data, function(data2) {
						if(data2=="1") window.location.replace("user.php?")
					});
					
				}else {
					$("#error").text("El usuario o la contraseña están equivocados")
				}
			});
		}

		$(document).ready(function() {
			$("#entrar").click(entrar);
			var input = document.getElementById("pass");
			input.addEventListener("keyup", function(event) {
  				if (event.keyCode === 13) {
   					event.preventDefault();
   					document.getElementById("entrar").click();
  				}
			});
		});
	</script>
</head>
<body>
	<table>
		<tr>
			<td><p align="right">Usuario:</p></td>
			<td><input type="text" id="user"></td>
		</tr>
		<tr>
			<td><p align="right">Contraseña:</p></td>
			<td><input type="password" id="pass"></td>
		</tr>
		<tr>
			<td colspan="2"><br></td>
		</tr>
		<tr>
			<td colspan="2">
				<button class="btn btn-info" id="entrar" onclick="javascript:entrar()">Entrar</button>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p id="error" style="margin-top: 1%"></p>
			</td>
		</tr>
		<tr>
			<td colspan="2"><a href="recuperar_contrasenya.php">¿Has olvidado la contraseña?</a></td>
		</tr>
		<tr>
			<td colspan="2"><a href="nuevo_usuario.php">¿No tienes usuario?</a></td>
		</tr>
	</table>
</body>
</html>
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

		function entrar(){
			var user = $("#user").val();
			var pass = $("#pass").val();

			$.post('ajax/login.php', {user: user,pass:pass}, function(data, textStatus, xhr) {
				if(data=="1"){
					window.location.replace("user.php");
				}
				else{
					$("#error").text("El usuario o la contraseña están equivocados");
					$("#error").css('color', 'red');
				}
			});
		}


	</script>
</head>
<body>
	<img src="images/DE-CATAS-ORIGINAL-PNG.png" alt="DeCatas">
	<table>
		<tr>
			<td><p align="right">Usuario:</p></td>
			<td><input type="text" name="user" id="user" class="form-control"></td>
		</tr>
		<tr>
			<td><p align="right">Contraseña:</p></td>
			<td><input type="password" name="pass" id="pass" class="form-control"></td>
		</tr>
		<tr>
			<td colspan="2"><br></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="button" class="btn btn-info" id="entrar" onclick="javascript:entrar" value="Entrar">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p id="error" style="margin-top: 1%"></p>
			</td>
		</tr>
		<tr>
			<td colspan="2"><a href="nuevo_usuario.php">¿No tienes usuario?</a></td>
		</tr>
	</table>
</body>
</html>
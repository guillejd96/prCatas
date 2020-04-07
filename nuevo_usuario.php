<?php 
	include 'config.php';
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
 	<title>Nuevo usuario</title>
 	<script>
		function checkUsuario(u){
			$.get('ajax/existeUsuario.php?u='+u, function(data) {
				if(data=="0"){
					return true;
				}else {
					$("#error").val("El usuario ya existe");
					return false;
				}	
			});
		}

		function checkPassword(p){

		}

		function check(u,n,p1,p2){
			if(checkUsuario(u) == false) return false;
			if(p1!=p2) {
				$("#error").val("Las contraseñas no son iguales");
				return false;
			}
			//if(checkPassword(p1) == false) return false;
			return true;
		}

		function guardar(){
			var newUsuario = $("#usuario").val();
			var newNombre = $("#nombre").val();
			var newPass1 = $("#pass1").val();
			var newPass2 = $("#pass2").val();

			var bool = check(newUsuario,newNombre,newPass1,newPass2);
			alert(bool);
		}

 		function volver(){
 			window.location.replace("index.php");
 		}

 		$(document).ready(function() {
 			$("#volver").click(volver);
 			$("#guardar").click(guardar);
 		});
 	</script>
 </head>
 <body>
 	<h1>Nuevo usuario</h1>
 	<table id="form">
 		<tr>
			<td><p class="form">Usuario:</p></td>
			<td><input type="text" id="usuario"></td>
		</tr>
		<tr>
			<td><p class="form">Nombre:</p></td>
			<td><input type="text" id="nombre"></td>
		</tr>
		<tr>
			<td><p class="form">Contraseña:</p></td>
			<td><input type="password" id="pass1"></td>
		</tr>
		<tr>
			<td><p class="form">Repita su contraseña:</p></td>
			<td><input type="password" id="pass2"></td>
		</tr>
		<tr><td colspan="2"><p class="error"></p></td></tr>
		<tr>
			<td><button class="btn btn-info" id="guardar">Guardar</button></td>
			<td><button class="btn btn-link" id="volver">Cancelar</button></td>
		</tr>
 	</table>
 </body>
 </html>
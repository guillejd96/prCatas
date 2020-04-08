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
			// Minimo 4 caracteres
			if(u.length<4) {
				$(".error").text("El usuario debe tener 4 o más caracteres");
				return false;
			}
			else {
				$.get('ajax/existeUsuario.php?u='+u, function(data) {
					if(data=="0"){
						return true;
					}else {
						$(".error").text("El usuario ya existe");
						return false;
					}	
				});				
			}
		}

		function checkEqualPasswords(p1,p2){
			if(p1!=p2) {
				$(".error").text("Las contraseñas no son iguales");
				return false;
			}
			else return true;
		}

		function checkPassword(p){
			//  Password between 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter
			var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
			if(p.match(decimal)) return true;
			else {
				$(".error").text("Las contraseña no cumple los requisitos");
				return false
			}
		}

		function check(u,n,p1,p2){
			if(checkUsuario(u) == false) return false;
			if(checkEqualPasswords(p1,p2) == false ) return false;
			if(checkPassword(p1) == false) return false;
			return true;
		}

		function guardar(){
			var newUsuario = $("#usuario").val();
			var newNombre = $("#nombre").val();
			var newPass1 = $("#pass1").val();
			var newPass2 = $("#pass2").val();

			var bool = check(newUsuario,newNombre,newPass1,newPass2);
			if(bool==true){
				$.get('ajax/nuevoUsuario.php?u='+newUsuario+'&n='+newNombre+'&p='+newPass1, function(data) {
					if(data=="1"){
						$(".error").css('color', 'green');
						$(".error").text("Usuario insertado con éxito. Redireccionando...");
						setTimeout(function () {
       						window.location.replace("index.php");	
    					},2000);
					} else {
						$(".error").text("Error al insertar");
					}
				});
			} else {

			}
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
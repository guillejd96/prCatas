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
	<script src="http://malsup.github.com/jquery.form.js"></script> 
 	<title>Nuevo usuario</title>
 	<script>
		function checkUsuario(u){
			// Minimo 4 caracteres
			if(u.length<4) {
				$(".error").text("El usuario debe tener 4 o más caracteres");
				return false;
			}
			else {
				$.post('ajax/existeUsuario.php', {u: u}, function(data, textStatus, xhr) {
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
				$(".error").text("La contraseña no cumple los requisitos");
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
				$.post('ajax/nuevoUsuario.php',
					{
						nombre: newNombre,
						usuario: newUsuario,
						contrasenya: newPass1
					}, function(data, textStatus) {
						if(data=="1"){
							$(".error").css('color', 'green');
							$(".error").text("Usuario insertado con éxito. Redireccionando...");
							setTimeout(function () {
       							window.location.replace("index.php");	
    						},2000);
						} else if(data=="-1"){
							$(".error").text("Error al insertar el usuario");
						} else {
							$(".error").text("Error al insertar la persona");
						}
				});
			} else {

			}
		}
 	</script>
 </head>
 <body>
 	<h1>Nuevo usuario</h1>
 	<table>
 		<tr>
 			<td>
 				<table class="no_border" width="500px" heigth="500px">
 					<tbody>
 						<tr>
				 			<td><p align="justify">- No tardes más en crear tu cuenta parapoder disfrutar de todo lo que ofrecemos.</p></td>
						</tr>
						<tr>
							<td><p align="justify">- Con este servidor de catas podrás visualizar tus datos y resultados de las catas de cervezas que hagas con tus amigos desde la aplicación móvil.</p></td>
						</tr>
						<tr>
							<td>
								<p align="justify">- Acceso a las valoraciones de todas las cervezas que has registrado.</p>
							</td>
						</tr>
						<tr>
							<td>
								<p align="justify">- Acceso a los resultados estadísticos de las catas que has registrado.</p>
							</td>
						</tr>
 					</tbody>
			 	</table>
 			</td>
 			<td>
				 <table id="form" width="500px" heigth="500px">
					<tr>
						<td><p class="form">Usuario:</p></td>
						<td><input type="text" name="user" id="usuario"></td>
					</tr>
					<tr>
						<td><p class="form">Nombre:</p></td>
						<td><input type="text" name="name" id="nombre"></td>
					</tr>
					<tr>
						<td><p class="form">Contraseña:</p></td>
						<td><input type="password" name="pass1" id="pass1"></td>
					</tr>
					<tr>
						<td><p class="form">Repita su contraseña:</p></td>
						<td><input type="password" name="pass2" id="pass2"></td>
					</tr>
					<tr><td colspan="2"><p class="error"></p></td></tr>
				 	</table>
 			</td>
 		</tr>
 		<tr></tr>
 		<tr>
 			<td><input type="button" class="btn btn-info" onclick="javascript:guardar()" value="Guardar"></td>
			<td><input type="button" class="btn btn-link" onclick="location.href='index.php'" value="Cancelar"></button></td>
 		</tr>
 	</table>
 </body>
 </html>
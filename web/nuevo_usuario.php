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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 	<title>Nuevo usuario</title>
 	<script>
		$(document).ready(function(){
  			$("#guardar").click(guardar);
  			var input = document.getElementById("pass2");
			input.addEventListener("keyup", function(event) {
  				if (event.keyCode === 13) {
   					event.preventDefault();
   					document.getElementById("guardar").click();
  				}
			}); 
		});

		function checkUsuario(u){
			// Minimo 4 caracteres
			if(u.length<4) {
				$(".error").text("El usuario debe tener 4 o más caracteres");
				$("#usuario").css('border', '2px solid red');
				return false;
			}
			else {
				$.post('ajax/existeUsuario.php', {u: u}, function(data, textStatus, xhr) {
					if(data=="0"){
						$(".error").text("El usuario ya existe");
						$("#usuario").css('border', '2px solid red');
						return false;
					}else {
						return true;
						
					}	
				});	
			}
		}

		function checkName(n){
			if(n==""){
				$(".error").text("El campo nombre está vacío");
				$("#nombre").css('border', '2px solid red');
				return false;
			}else {
				return true;
			}
		}

		function checkEqualPasswords(p1,p2){
			if(p1!=p2) {
				$(".error").text("Las contraseñas no son iguales");
				$("#pass1").css('border', '2px solid red');
				$("#pass2").css('border', '2px solid red');
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
				$("#pass1").css('border', '2px solid red');
				return false
			}
		}

		function check(u,n,p1,p2){
			$("#usuario").css('border', 'initial');
			$("#pass1").css('border', 'initial');
			$("#pass2").css('border', 'initial');
			$("#nombre").css('border', 'initial');
			if(checkUsuario(u) == false) return false;
			if(checkName(n)== false) return false;
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
 	<h1>DeCatas</h1>
 	<table>
 		<tr>
 			<td>
 				<table class="no_border" width="500px" heigth="500px">
 					<tbody>
 						<tr>
				 			<td><p align="justify">- No tardes más en crear tu cuenta para poder disfrutar de todo lo que ofrecemos.</p></td>
						</tr>
						<tr>
							<td><p align="justify">- Con este servidor de catas podrás visualizar tus datos y resultados de las catas de cervezas que hagas con tus amigos desde la aplicación móvil.</p></td>
						</tr>
						<tr>
							<td>
								<p align="justify">- También podrás registar la valoración de todas las cervezas que pruebes</p>
							</td>
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
						<td><input type="text" name="user" id="usuario" class="form-control"></td>
					</tr>
					<tr>
						<td>
							<p></p>
						</td>
					</tr>
					<tr>
						<td><p class="form">Nombre:</p></td>
						<td><input type="text" name="name" id="nombre" class="form-control"></td>
					</tr>
					<tr>
						<td>
							<p></p>
						</td>
					</tr>
					<tr>
						<td><p class="form"><a href="#" id="help" data-toggle="tooltip" data-placement="top" 
							title="La contraseña debe:
- Tener entre 6 y 20 caracteres
- Tener mínimo un número
- Tener mínimo una letra minúscula
- Tener mínimo una letra mayúscula"><i class="fas fa-question-circle"></i></a>&nbspContraseña:</p></td>
						<td><input type="password" name="pass1" id="pass1" class="form-control"></td>
					</tr>
					<tr>
						<td>
							<p></p>
						</td>
					</tr>
					<tr>
						<td><p class="form">Repita su contraseña:</p></td>
						<td><input type="password" name="pass2" id="pass2" class="form-control"></td>
					</tr>
					<tr><td colspan="2"><p class="error"></p></td></tr>
					<tr>
			 			<td><input type="button" class="btn btn-info" id="guardar" onclick="javascript:guardar" value="Guardar"></td>
						<td><input type="button" class="btn btn-link" onclick="location.href='index.php'" value="Cancelar"></button>
					</td>
 		</tr>
				 	</table>
 			</td>
 		</tr>
 		<tr></tr>
 	</table>
 </body>
 </html>
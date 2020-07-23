<?php 
	include 'config.php';
	include 'menus.php';
	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$idUsuario = $_SESSION["idUsuario"];

	$idPersona = mysqli_query($conexion,"SELECT id FROM persona WHERE idUsuario=".$idUsuario)->fetch_row()[0];

	$sql = "SELECT * FROM opinion WHERE idPersona=".$idPersona;
	$resOpiniones = mysqli_query($conexion,$sql);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Mis cervezas</title>
	<script>
		var sortMedia=true,sortApariencia=true,sortAroma=true,sortSabor=true,sortCuerpo=true,sortBotellin=true;

		function sortTableByMedia() {
			var table, rows, switching, i, x, y, shouldSwitch;
			table = document.getElementById("content");
			switching = true;
			while (switching) {
				switching = false;
				rows = table.rows;
				for (i = 1; i < (rows.length - 1); i++) {
				   	shouldSwitch = false;
				   	x = $(rows[i]).find('#media');
				   	y = $(rows[i+1]).find('#media');
				   	if(sortMedia){
				   		if (Number($(x).html()) < Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					} else {
					   	if (Number($(x).html()) > Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					}
			 	}
				if (shouldSwitch) {
				 	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
				}
			}
			if(sortMedia) {
				sortMedia=false;
				$("#titleMedia").empty();
				$("#titleMedia").append("<p>Media <i class='fas fa-sort-down'></i></p>");
			}else {
				sortMedia=true;
				$("#titleMedia").empty();
				$("#titleMedia").append("<p>Media <i class='fas fa-sort-up'></i></p>");
			}
			$("#titleAroma").empty();
			$("#titleAroma").append("<p>Aroma <i class='fas fa-sort'></i></p>");
			$("#titleApariencia").empty();
			$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort'></i></p>");
			$("#titleSabor").empty();
			$("#titleSabor").append("<p>Sabor <i class='fas fa-sort'></i></p>");
			$("#titleCuerpo").empty();
			$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort'></i></p>");
			$("#titleBotellin").empty();
			$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort'></i></p>");
		}

		function sortTableByAroma() {
			var table, rows, switching, i, x, y, shouldSwitch;
			table = document.getElementById("content");
			switching = true;
			while (switching) {
			    switching = false;
			    rows = table.rows;
			    for (i = 1; i < (rows.length - 1); i++) {
			    	shouldSwitch = false;
			      	x = $(rows[i]).find('#aroma');
			      	y = $(rows[i+1]).find('#aroma');
			      	if(sortAroma){
				   		if (Number($(x).html()) < Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					} else {
					   	if (Number($(x).html()) > Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					}
			    }
			    if (shouldSwitch) {
			     	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			    	switching = true;
			    }
			}
			if(sortAroma) {
				sortAroma=false;
				$("#titleAroma").empty();
				$("#titleAroma").append("<p>Aroma <i class='fas fa-sort-down'></i></p>");
			}else {
				sortAroma=true;
				$("#titleAroma").empty();
				$("#titleAroma").append("<p>Aroma <i class='fas fa-sort-up'></i></p>");
			}
			$("#titleBotellin").empty();
			$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort'></i></p>");
			$("#titleApariencia").empty();
			$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort'></i></p>");
			$("#titleSabor").empty();
			$("#titleSabor").append("<p>Sabor <i class='fas fa-sort'></i></p>");
			$("#titleCuerpo").empty();
			$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort'></i></p>");
			$("#titleMedia").empty();
			$("#titleMedia").append("<p>Media <i class='fas fa-sort'></i></p>");
		}

		function sortTableByApariencia() {
			var table, rows, switching, i, x, y, shouldSwitch;
			table = document.getElementById("content");
			switching = true;
			while (switching) {
			    switching = false;
			    rows = table.rows;
			    for (i = 1; i < (rows.length - 1); i++) {
			    	shouldSwitch = false;
			      	x = $(rows[i]).find('#apariencia');
			      	y = $(rows[i+1]).find('#apariencia');
			      	if(sortApariencia){
				   		if (Number($(x).html()) < Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					} else {
					   	if (Number($(x).html()) > Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					}
			    }
			    if (shouldSwitch) {
			     	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			    	switching = true;
			    }
			}
			if(sortApariencia) {
				sortApariencia=false;
				$("#titleApariencia").empty();
				$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort-down'></i></p>");
			}else {
				sortApariencia=true;
				$("#titleApariencia").empty();
				$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort-up'></i></p>");
			}
			$("#titleAroma").empty();
			$("#titleAroma").append("<p>Aroma <i class='fas fa-sort'></i></p>");
			$("#titleBotellin").empty();
			$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort'></i></p>");
			$("#titleSabor").empty();
			$("#titleSabor").append("<p>Sabor <i class='fas fa-sort'></i></p>");
			$("#titleCuerpo").empty();
			$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort'></i></p>");
			$("#titleMedia").empty();
			$("#titleMedia").append("<p>Media <i class='fas fa-sort'></i></p>");
		}

		function sortTableBySabor() {
			var table, rows, switching, i, x, y, shouldSwitch;
			table = document.getElementById("content");
			switching = true;
			while (switching) {
			    switching = false;
			    rows = table.rows;
			    for (i = 1; i < (rows.length - 1); i++) {
			    	shouldSwitch = false;
			      	x = $(rows[i]).find('#sabor');
			      	y = $(rows[i+1]).find('#sabor');
			      	if(sortSabor){
				   		if (Number($(x).html()) < Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					} else {
					   	if (Number($(x).html()) > Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					}
			    }
			    if (shouldSwitch) {
			     	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			    	switching = true;
			    }
			}
			if(sortSabor) {
				sortSabor=false;
				$("#titleSabor").empty();
				$("#titleSabor").append("<p>Sabor <i class='fas fa-sort-down'></i></p>");
			}else {
				sortSabor=true;
				$("#titleSabor").empty();
				$("#titleSabor").append("<p>Sabor <i class='fas fa-sort-up'></i></p>");
			}
			$("#titleAroma").empty();
			$("#titleAroma").append("<p>Aroma <i class='fas fa-sort'></i></p>");
			$("#titleApariencia").empty();
			$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort'></i></p>");
			$("#titleBotellin").empty();
			$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort'></i></p>");
			$("#titleCuerpo").empty();
			$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort'></i></p>");
			$("#titleMedia").empty();
			$("#titleMedia").append("<p>Media <i class='fas fa-sort'></i></p>");
		}

		function sortTableByCuerpo() {
			var table, rows, switching, i, x, y, shouldSwitch;
			table = document.getElementById("content");
			switching = true;
			while (switching) {
			    switching = false;
			    rows = table.rows;
			    for (i = 1; i < (rows.length - 1); i++) {
			    	shouldSwitch = false;
			      	x = $(rows[i]).find('#cuerpo');
			      	y = $(rows[i+1]).find('#cuerpo');
			      	if(sortCuerpo){
				   		if (Number($(x).html()) < Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					} else {
					   	if (Number($(x).html()) > Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					}
			    }
			    if (shouldSwitch) {
			     	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			    	switching = true;
			    }
			}
			if(sortCuerpo) {
				sortCuerpo=false;
				$("#titleCuerpo").empty();
				$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort-down'></i></p>");
			}else {
				sortCuerpo=true;
				$("#titleCuerpo").empty();
				$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort-up'></i></p>");
			}
			$("#titleAroma").empty();
			$("#titleAroma").append("<p>Aroma <i class='fas fa-sort'></i></p>");
			$("#titleApariencia").empty();
			$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort'></i></p>");
			$("#titleSabor").empty();
			$("#titleSabor").append("<p>Sabor <i class='fas fa-sort'></i></p>");
			$("#titleBotellin").empty();
			$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort'></i></p>");
			$("#titleMedia").empty();
			$("#titleMedia").append("<p>Media <i class='fas fa-sort'></i></p>");
		}

		function sortTableByBotellin() {
			var table, rows, switching, i, x, y, shouldSwitch;
			table = document.getElementById("content");
			switching = true;
			while (switching) {
			    switching = false;
			    rows = table.rows;
			    for (i = 1; i < (rows.length - 1); i++) {
			    	shouldSwitch = false;
			      	x = $(rows[i]).find('#botellin');
			      	y = $(rows[i+1]).find('#botellin');
			      	if(sortBotellin){
				   		if (Number($(x).html()) < Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					} else {
					   	if (Number($(x).html()) > Number($(y).html())) {
					     	shouldSwitch = true;
					       	break;
					   	}
					}
			    }
			    if (shouldSwitch) {
			     	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			    	switching = true;
			    }
			}
			if(sortBotellin) {
				sortBotellin=false;
				$("#titleBotellin").empty();
				$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort-down'></i></p>");
			}else {
				sortBotellin=true;
				$("#titleBotellin").empty();
				$("#titleBotellin").append("<p>Botellín <i class='fas fa-sort-up'></i></p>");
			}
			$("#titleAroma").empty();
			$("#titleAroma").append("<p>Aroma <i class='fas fa-sort'></i></p>");
			$("#titleApariencia").empty();
			$("#titleApariencia").append("<p>Apariencia <i class='fas fa-sort'></i></p>");
			$("#titleSabor").empty();
			$("#titleSabor").append("<p>Sabor <i class='fas fa-sort'></i></p>");
			$("#titleCuerpo").empty();
			$("#titleCuerpo").append("<p>Cuerpo <i class='fas fa-sort'></i></p>");
			$("#titleMedia").empty();
			$("#titleMedia").append("<p>Media <i class='fas fa-sort'></i></p>");
		}

		function borrar(id){
			b = confirm("¿Quiere borrar la cerveza seleccionada?");
			if(b){
				$("#error").remove();
				$.post('ajax/borrarCerveza.php', {id: id}, function(data, textStatus, xhr) {
					if(data=="1"){
						window.location.reload();
					}else {
						$(".main").append('<p id="error">Error al borrar la cerveza</p>');
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
		<h2>Mis cervezas</h2>
		<table class="display" id="content">
			<?php if(mysqli_num_rows($resOpiniones)>0){
				echo "<tr>
			 			<th>
			 				<p>Cerveza</p>
			 			</th>
			 			<th title='Ordenar' onclick='javascript:sortTableByAroma()' id='titleAroma'>
			 				<p>Aroma <i class='fas fa-sort'></i></p>
			 			</th>
			 			<th title='Ordenar'  onclick='javascript:sortTableByApariencia()' id='titleApariencia'>
			 				<p>Apariencia <i class='fas fa-sort'></i></p>
			 			</th>
			 			<th title='Ordenar'  onclick='javascript:sortTableBySabor()'  id='titleSabor'>
			 				<p>Sabor <i class='fas fa-sort'></i></p>
			 			</th>
			 			<th title='Ordenar' onclick='javascript:sortTableByCuerpo()' id='titleCuerpo'>
			 				<p>Cuerpo <i class='fas fa-sort'></i></p>
			 			</th>
			 			<th title='Ordenar' onclick='javascript:sortTableByBotellin	()' id='titleBotellin'>
			 				<p>Botellín <i class='fas fa-sort'></i></p>
			 			</th>
			 			<th title='Ordenar' onclick='javascript:sortTableByMedia()' id='titleMedia'>
			 				<p>Media <i class='fas fa-sort'></i></p>
			 			</th>
			 			<th></th>
			 		</tr>";
			 		if($resOpiniones->num_rows>0){
	 					while($row = mysqli_fetch_assoc($resOpiniones)){
	 						$idCerveza = $row['idCerveza'];
	 						$sqlCerveza = "SELECT nombre,idCata FROM cerveza WHERE id=".$idCerveza.";";
		 					$res = mysqli_query($conexion,$sqlCerveza)->fetch_row();
		 					$cerveza = $res[0];
		 					$idCata = $res[1];
		 					echo "<tr>";
		 					echo "<td><p>".$cerveza."</p></td>";
		 					echo "<td><p id='aroma'>".$row['aroma']."</p></td>";
		 					echo "<td><p id='apariencia'>".$row['apariencia']."</p></td>";
		 					echo "<td><p id='sabor'>".$row['sabor']."</p></td>";
		 					echo "<td><p id='cuerpo'>".$row['cuerpo']."</p></td>";
		 					echo "<td><p id='botellin'>".$row['botellin']."</p></td>";
		 					$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']+$row['botellin']) / 5;
		 					echo "<td><p id='media'>".$media."</p></td>";
		 					if($idCata==""){
		 						echo "<td><p title='Borrar'><a onclick='javascript:borrar(".$idCerveza.")'><i class='far fa-trash-alt' style='font-size: 25px'></i></a></p></td>";
		 					} else {
		 						echo "<td><p title='No puedes borrar esta cerveza al pertenecer a una cata'><a href='#'><i class='fas fa-question-circle'></i></a></p></td>";
		 					}
		 					echo "</tr>";
	 					}
	 				} else {
	 				echo "<tr><td colspan='6'><p>No hay resultados disponibles</p></td></tr>";
	 				}

			} else {
				echo "<tr><td>";
				echo "<p>No has registrado ninguna cerveza</p>";
				echo "</td></tr>";
				echo "<tr><td>";
				echo "<p>Para registrar tu primera cata pulsa <a href='nueva_cata.php'>aquí</a></p>";
				echo "<p>Para registrar tu primera cerveza pulsa <a href='nueva_cerveza.php'>aquí</a></p>";
				echo "</td></tr>";
			} 
			?>
		</table><br>
	</div>
</body>
</html>

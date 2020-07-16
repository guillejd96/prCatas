<?php 
	include "config.php";
	include 'menus.php';

	session_start();
	if(!isset($_SESSION["idUsuario"])){
		header('Location: index.php');
	}

	$id = $_GET["id"];

	$idCata = $_GET["c"];

	$sql = "SELECT nombre FROM persona WHERE id=".$id;
	$nombrePersona = mysqli_query($conexion,$sql)->fetch_row()[0];


	$sql = "SELECT * FROM opinion WHERE idPersona=".$id;
	$resOpiniones = mysqli_query($conexion,$sql);
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title><?php echo $nombrePersona; ?></title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
	</script>
 </head>
 <body>
 	<?php echo banner(); ?>
	<?php echo arriba(); ?>
	<?php echo izquierda(); ?>
	<div class="main">
	 	<h1>Información de <?php echo $nombrePersona; ?></h1>
	 	<br>
	 	<table id="content">
	 		<tr>
	 			<th>
	 				<p>Cerveza</p>
	 			</th>
	 			<th id="titleAroma" title="Ordenar" onclick="javascript:sortTableByAroma()">
	 				<p>Aroma <i class='fas fa-sort'></i></p>
	 			</th>
	 			<th id="titleApariencia" title="Ordenar" onclick="javascript:sortTableByApariencia()">
	 				<p>Apariencia <i class='fas fa-sort'></i></p>
	 			</th>
	 			<th id="titleSabor" title="Ordenar" onclick="javascript:sortTableBySabor()">
	 				<p>Sabor <i class='fas fa-sort'></i></p>
	 			</th>
	 			<th id="titleCuerpo" title="Ordenar" onclick="javascript:sortTableByCuerpo()">
	 				<p>Cuerpo <i class='fas fa-sort'></i></p>
	 			</th>
	 			<th id="titleBotellin" title="Ordenar"  onclick="javascript:sortTableByBotellin()">
	 				<p>Botellín <i class='fas fa-sort'></i></p>
	 			</th>
	 			<th id="titleMedia" title="Ordenar"  onclick="javascript:sortTableByMedia()">
	 				<p>Media <i class='fas fa-sort'></i></p>
	 			</th>
	 		</tr>
	 		<?php 
	 			if($resOpiniones->num_rows>0){

	 				$sqlCervezas = "SELECT id FROM cerveza WHERE idCata=".$idCata;
	 				$resCervezas = mysqli_query($conexion,$sqlCervezas);
	 				$idCervezas = array();
	 				while($row = mysqli_fetch_array($resCervezas)){
	 					array_push($idCervezas, $row[0]);
	 				}

	 				while($row = mysqli_fetch_assoc($resOpiniones)){
	 					if(in_array($row['idCerveza'], $idCervezas)){
	 						$sqlCerveza = "SELECT nombre FROM cerveza WHERE id=".$row['idCerveza'].";";
		 					$cerveza = mysqli_query($conexion,$sqlCerveza)->fetch_row()[0];

		 					echo "<tr>";
		 					echo "<td><p>".$cerveza."</p></td>";
		 					echo "<td><p id='aroma'>".$row['aroma']."</p></td>";
		 					echo "<td><p id='apariencia'>".$row['apariencia']."</p></td>";
		 					echo "<td><p id='sabor'>".$row['sabor']."</p></td>";
		 					echo "<td><p id='cuerpo'>".$row['cuerpo']."</p></td>";
		 					echo "<td><p id='botellin'>".$row['botellin']."</p></td>";
		 					$media = ($row['cuerpo']+$row['aroma']+$row['apariencia']+$row['sabor']+$row['botellin']) / 5;
		 					echo "<td><p id='media'>".$media."</p></td>";
		 				}
		 				echo "</tr>";
	 				}
	 			} else {
	 				echo "<tr><td colspan='7'><p>No hay resultados disponibles</p></td></tr>";
	 			}
	 		 ?>
	 	</table>
	 	<br>
	 	<button class="btn btn-link" onclick="location.href='info_cata.php?id=<?php echo $idCata; ?>'">Volver</button>
	</div>
 </body>
 </html>
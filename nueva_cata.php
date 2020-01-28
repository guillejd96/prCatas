<?php include "config.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva cata</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/init.css">
</head>
<body>
	<h1>Nueva cata</h1><br>
	<table>
		<tr>
			<td><p>Nombre:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="nombre"></td>
		</tr>
		<tr>
			<td><p>Fecha:&nbsp;&nbsp;</p></td>
			<td><input type="date" id="fecha"></td>
		</tr>
		<tr>
			<td><p>Personas:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="cervezas"></td>
		</tr>
		<tr>
			<td><p>Cervezas:&nbsp;&nbsp;</p></td>
			<td><input type="text" id="cervezas"></td>
		</tr>
		<tr><td colspan="2"><br></td></tr>
		<tr>
			<td><button class="btn btn-secondary">Continuar</button></td>
			<td><button class="btn btn-link" onclick="location.href='index.php'">Volver</button></td>
		</tr>
	</table>
</body>
</html>
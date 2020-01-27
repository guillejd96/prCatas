<?php 

$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "servidor_cata";

$conexion = mysqli_connect ($host, $usuario, $contrasena, $basedatos)
or die ("No se puede conectar con la base de datos");

mysqli_set_charset($conexion,'utf8');

 ?>
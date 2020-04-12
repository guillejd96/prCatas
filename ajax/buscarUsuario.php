<?php 

include '../config.php';

$u = $_GET['u'];
$p = $_GET['p'];

$sql = "SELECT id FROM usuario WHERE usuario='".$u."' AND password='".$p."';";

$res = mysqli_query($conexion,$sql);

if(mysqli_num_rows($res)>0){
	echo $res->fetch_row()[0];
}else{
	echo "error";
}
 
?>

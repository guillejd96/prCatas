<?php 

include '../config.php';

$u = $_GET['u'];

$sql = "SELECT id FROM persona WHERE usuario='".$u."';";

$res = mysqli_query($conexion,$sql);

if(mysqli_num_rows($res)>0){
	echo "1";
}else{
	echo "0";
}
 
?>

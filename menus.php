<style>
	/* Fixed sidenav, full height */
	.sidenav {
	  height: 100%;
	  width: 200px;
	  position: fixed;
	  left: 0;
	  z-index: 1;
	  top: 252px;
	  background-color: #503522;
	  overflow-x: hidden;
	  padding-top: 20px;
	}
	#menu_izq a {
		display: flex;
  		align-items: center;
		color: white;
		display: block;
		text-decoration: none;
		height: 60px;
	}
	#menu_izq a:hover{
		text-decoration: none;
		color: black;
		background-color: #784e2f;
	}
	#menu_arriba{
		background-color: #503522;
	}
	#menu_arriba a {
		width: 17rem;
		text-decoration: none;
		color: white;
	}
	#menu_arriba a:hover{
		background-color: #784e2f;
		color: black;
	}
</style>

<?php function izquierda() { ?>


<nav id="menu_izq" class="sidenav">
	<a href="nueva_cata.php">
			<p>Nueva Cata</p>
	</a>
	<a href="nueva_cerveza.php">
			<p>Nueva Cerveza</p>
	</a>
	<a href="cata.php">
			<p>Mis catas</p>
	</a>
	<a href="mis_cervezas.php">
			<p>Mis cervezas</p>
	</a>
	<a href="mis_amigos.php">
			<p>Mis amigos</p>
	</a>
</nav>

<?php } ?>

<?php function arriba() { ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu_arriba">
	<div class="navbar-brand" style="width: 200px;"></div>
	<a href="user.php" class="navbar-brand"><p>Inicio</p></a>
	<a href="instrucciones.php" class="navbar-brand"><p>Instrucciones</p></a>
	<a href="contacto.php" class="navbar-brand"><p>Contacto</p></a>
	<a href="faq.php" class="navbar-brand"><p>FaQ</p></a>
	<a href="ajax/logout.php" class="navbar-brand"><p><i class="fas fa-sign-out-alt"></i> Salir</p></a>
</nav>

<?php } ?>

<?php function banner() { ?>

<nav id="banner" style="height: 180px; background-color: white">
		<h1>DeCatas</h1>
</nav>

<?php } ?>
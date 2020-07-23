<style>
	/* Fixed sidenav, full height */
	#menu_izq {
	  height: 100%;
	  width: 200px;
	  position: fixed;
	  left: 0;
	  top: 252px;
	  z-index: 3;
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
		width: 100%;
		z-index: 1;
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
	#banner {
		z-index: 2;
	}

	#space {
		height: 252px;
	}
</style>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
	$(window).scroll(function(){
		var elementPosition = $('#menu_arriba').offset();

        if($(window).scrollTop() >= elementPosition.top){
            $('#menu_arriba').css('position','fixed').css('top','0');
            $("#menu_izq").css('position','fixed').css('top', '35');
        } else {
        	$('#menu_arriba').css('position','initial');
        }

        if(elementPosition.top <= 200){
        	$('#menu_arriba').css('position','initial').css('top', '200');
        	$("#menu_izq").css('top', '250');
        }
	});
</script>

<?php function izquierda() { ?>


<nav id="menu_izq" class="sidenav">
	<div></div>
	<a href="nueva_cata.php"><p>Nueva Cata</p></a>
	<a href="nueva_cerveza.php"><p>Nueva Cerveza</p></a>
	<a href="cata.php"><p>Mis catas</p></a>
	<a href="mis_cervezas.php"><p>Mis cervezas</p></a>
	<a href="mis_amigos.php"><p>Mis amigos</p></a>
</nav>

<?php } ?>

<?php function arriba() { ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu_arriba">
	<div class="navbar-brand" style="width: 200px;"></div>
	<a href="user.php" class="navbar-brand"><p>Inicio</p></a>
	<a href="top.php" class="navbar-brand"><p>Top 10</p></a>
	<a href="instrucciones.php" class="navbar-brand"><p>Instrucciones</p></a>
	<a href="contacto.php" class="navbar-brand"><p>Contacto</p></a>
	<a href="faq.php" class="navbar-brand"><p>FaQ</p></a>
	<div class="navbar-brand" style="width: 300px;"></div>
	<a href="ajax/logout.php" class="navbar-brand"><p><i class="fas fa-sign-out-alt"></i> Salir</p></a>
</nav>


<?php } ?>

<?php function banner() { ?>

<nav id="banner" style="height: 200; background-image: url(images/untitled.png); background-size:cover">
	<p>DeCatas</p>
</nav>

<?php } ?>
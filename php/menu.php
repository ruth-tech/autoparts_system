<?php
// session_start();


// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
// if (!isset($_SESSION["logueado"])) {
// 	header("location: ../index.php?error=debe_loguearse");
// 	exit;
// }

?>
<head> 

    <!-- Iconos de fontawesome -->
    <link rel="stylesheet" href="/autoparts_system/fontawesome-free/css/all.min.css">


	<!-- css -->
	<link rel="stylesheet" type="text/css" href="/autoparts_system/css/menuStyle.css">

	
	

</head>
<body>
	<div class="container-fluid " ><!-- -->
		<div class="row">
			<div class="col-12">
				<div class="wrapper">
					
					<div class="top_navbar">
						
						<div>
							<a class="logo">
								<img src="/autoparts_system/img/Logo.png" width= "150%" height="140%">
							</a>
							
						</div>

						
			
						<div class="top_menu justify-content-end">
						
							<ul>
								<li>
									<span class="btn time">
										<?php 
										date_default_timezone_set('America/Argentina/Buenos_Aires');
										$date = date('m-d-Y h:i:s a', time());
										echo $date;
										?>
									</span>
								</li>
								
								<li >
									<span class="btn user"><?php echo $_SESSION['usuario'];?></span>
								</li>
								
								<li > 
									<a class="btn" title="Cerrar sesión" href="/autoparts_system/php\logout.php"><i class="fas fa-power-off"></i></a>
								</li>
							</ul>
							
						</div>

					</div>
				</div>

			</div>
		</div>
		<br><br><br>
		<div class="row" >
			<div class="col-12">
				<div class="top-nav " style="position: -webkit-sticky, position: sticky;" >
				<header class="header" >
		
					<input class="menu-btn" type="checkbox" id="menu-btn" />
					<label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
					<ul class="menu">
						<li ><a  href="\autoparts_system\dashboard.php"><i class='fas fa-home'></i>HOME</a></li>
						<?php foreach ($_SESSION['modulos'] as $modulo): ?>
						<li ><a  href="/autoparts_system/modulos/<?php  echo $modulo['directorio']; ?>/index.php">
							<?php switch($modulo['directorio']){
								case "compras":
									print "<i class='fas fa-store'></i> ";
								break;
								case "pedidos":
									print "<i class='fas fa-book-reader'></i> ";
								break;
								case "ventas":
									print "<i class='fas fa-cash-register'></i> ";
								break;
								case "productos":
									print "<i class='fas fa-store'></i> ";
								break;
								case "devoluciones":
									print "<i class='fas fa-arrow-circle-down'></i>";
								break;
								case "proveedores":
									print "<i class='fas fa-store'></i> ";
								break;
								case "clientes":
									print "<i class='far fa-address-book'></i> ";
								break;
								case "empleados":
									print "<i class='fas fa-address-book'></i> ";
								break;
								case "seguridad":
									print "<i class='fas fa-user-lock'></i>";
								break;
							};?>
							<?php echo utf8_encode($modulo['descripcion']); ?> <span class="sr-only"></span></a>
						</li>  					
						<?php endforeach;  ?>				
					</ul>
				</header>

				</div>
				
			</div>
		</div>
			

							
	</div>

		

<script src="/autoparts_system/js/menu.js"></script>
</body>
</html>


		

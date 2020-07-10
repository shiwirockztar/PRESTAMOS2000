<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include "./vistas/inc/Link.php"; ?>
</head>
<body>
	<?php
		$peticionAjax=false;
		require_once "./controladores/controladorVistas.php";
		$IV = new ControladorVistas();

		$vistas=$IV->obtener_vistas_controlador();

		if($vistas=="login" || $vistas=="404"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		

		}else{
			session_start(['name'=>'SPM']);
			require_once "./controladores/controlaLogin.php";
			$lc= new ControLogin();
			// los datos $_SESSION['token_spm'], $_SESSION['us_spm'], $_SESSION['pr_spm'] y todos los demas son publicos ya que se solicitaron por contrologin  
			if (!isset($_SESSION['token_spm']) || !isset($_SESSION['us_spm']) || !isset($_SESSION['pr_spm']) || !isset($_SESSION['id_spm'])) {
				echo $lc->cerrar_sesion_controlador();
				exit();
			}
			
	?>
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<?php include "./vistas/inc/NavLateral.php"; ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<?php 
				include "./vistas/inc/NavBar.php";

				include  $vistas;
			?>
		</section>
	</main>
	<?php
		// include "./vistas/inc/logOut.php"; 
		}
		include "./vistas/inc/Script.php"; 
		include "./vistas/inc/logOut.php";
	?>
</body>
</html>
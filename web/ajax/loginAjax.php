<?php 

	$peticionAjax=true;
	require_once "../config/APP.php";
	
	


	if(isset($_POST['token']) && isset($_POST['usuario']) ){
		require_once "../controladores/controlaLogin.php";
		$ins_login = new controLogin();
		echo $ins_login->shutdown();		
	}

	else{
		session_start(['name'=>'SPM']);
		session_unset();
		session_destroy();
		header("Location: ".SERVERURL."login/");
		exit();
	}

?>
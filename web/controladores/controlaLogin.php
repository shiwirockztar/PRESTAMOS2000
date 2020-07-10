<?php 

	if($peticionAjax){
		require_once "../modelos/modeLogin.php";
	}else{
		require_once "./modelos/modeLogin.php";
	}

	class ControLogin extends ModeLogin{
		public function iniciar_sesion_controlador(){
			$usuario=modelConexion::limpiar($_POST['usuario_log']);
			$clave=modelConexion::limpiar($_POST['clave_log']);

			if($usuario=="" && $clave==""){
				echo '
				<script>
				Swal.fire({
				title: "ocurrio un error inesperado",
				text: "no has llenado todo los campos requeridos",
				type: "error",
				confirmButtonText: "Aceptar"
				});
				</script>';
				exit();
			}

			
			if(modelConexion::verificar("[a-zA-Z0-9]{1,35}",$usuario)){
				echo '
				<script>
				Swal.fire({
				title: "ocurrio un error inesperado",
				text: "El NOMBRE DE USUARIO no coincide con el formato solicitado",
				type: "error",
				confirmButtonText: "Aceptar"
				});
				</script>';
				exit();
			}

			if(modelConexion::verificar("[a-zA-Z0-9$@.-]{7,100}",$clave)){
				echo '
				<script>
				Swal.fire({
				title: "ocurrio un error inesperado",
				text: "El NOMBRE DE USUARIO no coincide con el formato solicitado",
				type: "error",
				confirmButtonText: "Aceptar"
				});
				</script>';
				exit();
			}

			$clave=modelConexion::encryption($clave);

			$datos_login=[
				"Usuario"=>$usuario,
				"Clave"=>$clave
			];

			$datos_cuenta=ModeLogin::iniciar_sesion_modelo($datos_login);
			if ($datos_cuenta->rowCount()==1){

				$row=$datos_cuenta->fetch();
				session_start(['name'=>'SPM']);

				$_SESSION['id_spm']=$row['usuario_id'];
				$_SESSION['no_spm']=$row['usuario_nombre'];
				$_SESSION['ap_spm']=$row['usuario_apellido'];
				$_SESSION['us_spm']=$row['usuario_usuario'];
				$_SESSION['pr_spm']=$row['usuario_privilegio'];
				$_SESSION['token_spm']=md5(uniqid(mt_rand(),true));
				// $_SESSION['k']=$row['usuario_clave'];

				return header("Location: ".SERVERURL."home/");
			}

			else{
				echo 
				'<script>
				Swal.fire({
				title: "ocurrio un error inesperado",
				text: "El usuario no se encuentra registrado",
				type: "error",
				confirmButtonText: "Aceptar"
				});
				</script>';
			}
		}

		public function cerrar_sesion_controlador(){
			session_unset();
			session_destroy();

			if(headers_sent()){
			// if(true){
				// redireccionamiento JAVA
				return "<script> window.location.href='".SERVERURL."login/'; </script>";
			}
			else{
				// redireccionamiento PHP
				return header("Location: ".SERVERURL."login/");
				exit();	
			}
		
		}

		public function shutdown(){
			session_start(['name'=>'SPM']);
			$token=modelConexion::decryption($_POST['token']);
			$usuario=modelConexion::decryption($_POST['usuario']);
			// echo "<script>alert($token);</script>"; 
			if ($token==$_SESSION['token_spm'] && $usuario==$_SESSION['us_spm']) {
				session_unset();
				session_destroy();
				$alerta=[
				"Alerta"=>"redireccionar",
				"URL"=>SERVERURL."login/"
				];
			}
			else{

				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado ",
					"Texto"=>"No se pudo cerrar la sesion",
					"Tipo"=>"error"
				];
				
			}
			echo json_encode($alerta);
			exit();
		}

	}
?>

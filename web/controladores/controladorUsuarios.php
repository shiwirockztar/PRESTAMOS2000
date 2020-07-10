
<?php  

	
	/**

    controladorUsuarios:        
    - Si  falla el filtro de la vista(codigo html  publico del usuario)
    - El Filtro del controlador permite control de datos a recibir ya que se implementa la verificacion interna de datos
    - Ejecuta funciones del modelo principal(modelConexion) 
    - Advierte al usuario de fallas frente al programa

 	*/
	

	if($peticionAjax){
		require_once "../modelos/modeloUsuario.php";
	}else{
		require_once "./modelos/modeloUsuario.php";
	}


	// ejecutamos validaciones por el lado del servidor
	// ya que las validaciones por el lado del cliente estaen en las vistas
	
	class controladorUsuarios extends usuarioModelo{

		/*--------- Controlador agregar usuario ---------*/
		public function agregar_usuario_controlador(){
			$dni=modelConexion::limpiar($_POST['usuario_dni_reg']);
			$nombre=modelConexion::limpiar($_POST['usuario_nombre_reg']);
			$apellido=modelConexion::limpiar($_POST['usuario_apellido_reg']);
			$telefono=modelConexion::limpiar($_POST['usuario_telefono_reg']);
			$direccion=modelConexion::limpiar($_POST['usuario_direccion_reg']);

			$usuario=modelConexion::limpiar($_POST['usuario_usuario_reg']);
			$email=modelConexion::limpiar($_POST['usuario_email_reg']);
			$clave1=modelConexion::limpiar($_POST['usuario_clave_1_reg']);
			$clave2=modelConexion::limpiar($_POST['usuario_clave_2_reg']);


			$privilegio=modelConexion::limpiar($_POST['usuario_privilegio_reg']);


			/*== comprobar campos vacios ==*/
			if($dni=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado 'campos vacios' ",
					"Texto"=>"No has llenado todos los campos que son obligatorios",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			/*== Verificando integridad de los datos ==*/
			if(modelConexion::verificar("[0-9-]{10,20}",$dni)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El DNI no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(modelConexion::verificar("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(modelConexion::verificar("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$apellido)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El APELLIDO no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if($telefono!=""){
				if(modelConexion::verificar("[0-9()+]{8,20}",$telefono)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El TELEFONO no coincide con el formato solicitado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			if($direccion!=""){
				if(modelConexion::verificar("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$direccion)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La DIRECCION no coincide con el formato solicitado",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
				}
			}

			if(modelConexion::verificar("[a-zA-Z0-9]{1,35}",$usuario)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El NOMBRE DE USUARIO no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(modelConexion::verificar("[a-zA-Z0-9$@.-]{7,100}",$clave1) || modelConexion::verificar("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las CLAVES no coinciden con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			/*== Comprobando DNI ==*/
			$check_dni=modelConexion::consultarSimple("SELECT usuario_dni FROM usuario WHERE usuario_dni='$dni'");
			if ($check_dni->rowCount()>0) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"EL DNI ingresado ya se encuentra registado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando USUARIO ==*/
			$check_user=modelConexion::consultarSimple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			if ($check_user->rowCount()>0) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"EL NOMBRE DE USUARIO ingresado ya se encuentra registado en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			/*== Comprobando EMAIL ==*/
			if ($email!="") {
				if (filter_var($email,FILTER_VALIDATE_EMAIL)) {

						$check_email=modelConexion::consultarSimple("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
						if ($check_email->rowCount()>0) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"EL CORREO ingresado ya se encuentra registado en el sistema",
								"Tipo"=>"error"
							];
							echo json_encode($alerta);
							exit();
						}

				}else{
					$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Ha ingresado un correo no valido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
				}
			}/*Fin Condicion/


			/*== Comprobando CLAVES ==*/
			if ($clave1!=$clave2) {
				 
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Las claves que acaba de ingresar no coinciden",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			else{
				$clave=modelConexion::encryption($clave1);
			}


			/*== Comprobando PRIVILEGIO ==*/
			if ($privilegio<1 || $privilegio>3){


				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El privilegio ingresado no esta permitido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}


			$datos_usuario_reg=[
				"DNI"=>$dni,
				"Nombre"=>$nombre,
				"Apellido"=>$apellido,
				"Telefono"=>$telefono,
				"Direccion"=>$direccion,
				"Email"=>$email,
				"Usuario"=>$usuario,
				"Clave"=>$clave,
				"Estado"=>"Activa",
				"Privilegio"=>$privilegio
				
			];
			$agregar_usuario=usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

			
			if ($agregar_usuario->rowCount()==1) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"usuario registrado",
					"Texto"=>"Ingreso exitoso",
					"Tipo"=>"succes"
				];
				echo json_encode($alerta);
				// exit();
			}
			else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Fallo al registrar el usuario",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				// exit();
			}
			// echo json_encode($alerta);

	}/*Fin funcion agregar_usuario_controlador*/		
	}/*Fin ControladorUsuarios*/


?>
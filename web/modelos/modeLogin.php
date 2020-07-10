<?php  


	require_once "modelConexion.php";

	class ModeLogin extends modelConexion{

		/*--------- Modelo iniciar usuario ---------*/
		protected static function iniciar_sesion_modelo($datos){
			$stmt=modelConexion::conectar()->prepare("SELECT * FROM usuario WHERE usuario_usuario=:Usuario AND usuario_clave=:Clave AND usuario_estado='Activa'");
			
			$stmt->bindParam(":Usuario",$datos['Usuario']);
			$stmt->bindParam(":Clave",$datos['Clave']);
			$stmt->execute();
			return $stmt;
		}
	}
?>
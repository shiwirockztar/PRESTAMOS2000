<?php  
		require_once "modelConexion.php";
	
		class usuarioModelo extends modelConexion{

		/*--------- Modelo agregar usuario ---------*/
		protected static function agregar_usuario_modelo($datos){
			$stmt=modelConexion::conectar()->prepare("INSERT INTO usuario(usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio) VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Email,:Usuario,:Clave,:Estado,:Privilegio)");

			$stmt->bindParam(":DNI",$datos['DNI']);
			$stmt->bindParam(":Nombre",$datos['Nombre']);
			$stmt->bindParam(":Apellido",$datos['Apellido']);
			$stmt->bindParam(":Telefono",$datos['Telefono']);
			$stmt->bindParam(":Direccion",$datos['Direccion']);
			$stmt->bindParam(":Email",$datos['Email']);
			$stmt->bindParam(":Usuario",$datos['Usuario']);
			$stmt->bindParam(":Clave",$datos['Clave']);
			$stmt->bindParam(":Estado",$datos['Estado']);
			$stmt->bindParam(":Privilegio",$datos['Privilegio']);
			$stmt->execute();

			return $stmt;
		}

	}
?>
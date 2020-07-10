<?php  

	require_once "./modelos/modeloVistas.php";

	class ControladorVistas extends modeloVistas{

		/*--------- Controlador obtener plantilla ---------*/
		public function obtener_plantilla_controlador(){
			return require_once "./vistas/plantilla.php";
		}

		/*--------- Controlador obtener vistas ---------*/
		public function obtener_vistas_controlador(){
			if(isset($_GET['l'])){
				$ruta=explode("/", $_GET['l']);
				$respuesta=modeloVistas::obtener_vistas_modelo($ruta[0]);
			}else{
				$respuesta="login";
			}
			return $respuesta;
		}
	}
?>
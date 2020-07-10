<?php  
// require_once"vistas/css/estilos.css";
// require_once "controladores/controlador-Plantilla.php";
// require_once "controladores/controlador-Formulario.php";

// require_once "modelos/formModelos.php";


/* creacion de objeto */
// $plantilla =new controladorP();
/* ejecutamos su metodo */
// $plantilla->invocaPlantilla();
 
 require_once "./config/APP.php";
 require_once "./controladores/controladorVistas.php";

 $plantilla =new ControladorVistas();
 $plantilla->obtener_plantilla_controlador();

		
		

?>	
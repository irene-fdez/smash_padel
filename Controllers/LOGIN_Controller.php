
<?php

session_start();

$_SESSION['ErrorPass'] = FALSE;
//Comprueba que si es un POST proveniente de Form de Login
if(!isset($_REQUEST['login']) && !(isset($_REQUEST['password']))){

	include '../Functions/Authentication.php';

	if(!IsAuthenticated()){

		//Devuelve el el formulario para loguearse
		include '../Views/core/Login.php';
	//	$login = new Login();
		$msg = NULL;
		if(isset($_REQUEST['resp']) && $_REQUEST['resp'] == false){
			$msg["text_message"]='Error al registrar el usuario';
            $msg["type_message"]=false;
		}
		$login = new Login($msg);
	}
	else {
		//comprobar campeonatos pasados (si llega al minimo de parejas generar los grupos, si no llega al minimo eliminar el campeonato)
		include '../Models/CAMPEONATO_Model.php';
		include '../Entities/Campeonato.php';
		$campeonato = new Campeonato('','','','');
		$model_camp = new CAMPEONATO_Model($campeonato);
		$comprobar = $model_camp->Comprobar_camp_pasados();
		

		$_SESSION['currentEntity']="";
		//muestra la vista de bienvenida
		include '../Views/core/Index_View.php';
		//TODO: Redirigir a vista de inicio
		$login = new Index();
	}
}
else{

	include '../Entities/Usuario.php';
	include '../Entities/Rol.php';
	include '../Entities/Campeonato.php';
	include '../Entities/Reserva.php';
	include '../Models/USUARIO_Model.php';
	include '../Models/ROL_Model.php';
	include '../Models/CAMPEONATO_Model.php';
	include '../Models/RESERVA_Model.php';

	$user = new Usuario($_REQUEST['login'],$_REQUEST['password'],'','','','','','');

	$user->checkLogin();

	$user_model = new USUARIO_Model($user);

	//Comprueba si el usuario existe y coincide con la contraseña
	if ($user_model->login() == true) {
		
		$user_data = $user_model->getDataByLogin();
		$_SESSION['ErrorPass'] = FALSE;
		$_SESSION['login'] = $user_data['login'];
		$_SESSION['nombre'] = $user_data['nombre'];
		$_SESSION['currentEntity']= "";
		$_SESSION['rol'] = $user_model->getDataRoleNameUser()->fetch_assoc();
		$_SESSION['reserva'] = 0;

		if($_SESSION["reserva"] == 0){ 
			$model = new RESERVA_Model(new Reserva('','','','',''));
            $respuesta = $model->Reserva_franja(2) ; //reserva de la franja horaria 
        }

		//comprobar campeonatos pasados (si llega al minimo de parejas generar los grupos, si no llega al minimo eliminar el campeonato)
		$campeonato = new Campeonato('','','','');
		$model_camp = new CAMPEONATO_Model($campeonato);
		$comprobar = $model_camp->Comprobar_camp_pasados();

		header('Location:../Controllers/LOGIN_Controller.php');
	}
	else{

		$_SESSION['ErrorPass'] = TRUE;

		include '../Views/core/Login.php';
		new Login();
	}

}

?>

<?php

	include_once '../Models/ROL_Model.php';

	function IsAuthenticated(){

		if (!isset($_SESSION['login'])){
			//header('Location:../Controller/USUARIO_Controller.php');	

			return false;
		}
		else{
			/*if (!HavePermissions($controller, $_REQUEST['accion']))
				new Mensaje('No tiene permisos para ejecutar esta acción','index.php');	
			*/
			//header('Location:USUARIO_Controller.php');
			
			return true;
		}
	} 

	function checkPermission($function, $action, $id) {

		$Permi = new ROL_Model('');
		
		if ($Permi->check($function,$action, $id)) {
			return true;
		} else {
			$_SESSION['currentEntity'] = '';
			include '../Views/MESSAGE.php';
            new MESSAGE('No tienes permiso','../Controllers/LOGIN_Controller.php');
			//header('Location:../Controllers/LOGIN_Controller.php');
			die();
		}

	}

/*	function checkPermissionAsignatura($id, $asignatura) {

		$toret = false;

		$Permi = new ROL_Model('');
		
		if(!$_SESSION['rol']['res_centro'] && !$_SESSION['rol']['res_universidad'] && !$_SESSION['rol']['res_titulacion']
			&& !$_SESSION['rol']['res_asignatura']) {
			return true;
		} else if ($Permi->checkAsignatura($id, $asignatura)) {
			return true;
		} else {
			$_SESSION['currentEntity'] = '';
			include '../Views/MESSAGE.php';
            new MESSAGE('No tienes permiso','../Controllers/LOGIN_Controller.php');
			//header('Location:../Controllers/LOGIN_Controller.php');
			die();
		}

	}
	function checkPermissionDepartamento($idDepartamento, $idUser) {

		$Permi = new ROL_Model('');
		
		if(!$_SESSION['rol']['res_centro'] && !$_SESSION['rol']['res_universidad'] && !$_SESSION['rol']['res_titulacion']
			&& !$_SESSION['rol']['res_asignatura']) {
			return true;
		} else if ($Permi->checkDepartamento($idDepartamento, $idUser)) {
			return true;
		} else {
			$_SESSION['currentEntity'] = '';
			include '../Views/MESSAGE.php';
            new MESSAGE('No tienes permiso','../Controllers/LOGIN_Controller.php');
			//header('Location:../Controllers/LOGIN_Controller.php');
			die();
		}

	}*/
?>


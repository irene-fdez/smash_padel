
<?php

class ROL_Model {

	
	var $mysqli; 

    function __construct($rol){
        
        $this->rol = $rol;
        
        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }


    
    function Add()
    {   
		$RoleName= $this->rol->getNombreRole();
		$ResCentro= $this->rol->getResCentro();
		$ResTitulacion= $this->rol->getResTitulacion();
		$ResAsignatura= $this->rol->getResAsignatura();

        $sql = "INSERT INTO ROL (`nombre`, `res_centro`,`res_titulacion`,`res_asignatura`) 
        VALUES ('$RoleName',$ResCentro,$ResTitulacion,$ResAsignatura);";
        
        if (!$this->mysqli->query($sql)) { 
            
            return 'Unknowed Error';
        }
		else{ 
			$this->rol->setIdRole(mysqli_insert_id($this->mysqli));
			
            return 'Success insert'; 
        }

    } 


	function AllData(){

		$sql = "SELECT * FROM ROL";
		if (!($resultado = $this->mysqli->query($sql))){
			return 'It does not exist in DB'; 
		}
		else{ 
			$result = $resultado;
			return $result;
		}
	}


	function Delete()
	{	

		$id_rol = $this->rol->getIdRole();

	    $sql = "SELECT * FROM ROL WHERE (id = '$id_rol')";
	    
	    $result = $this->mysqli->query($sql); 
	    
	    if ($result->num_rows >= 1) {
			
			$sql = "DELETE FROM ROL WHERE  id = '$id_rol' ";
			
			$this->mysqli->query($sql);
			return "Correctly delete";

	    } else {
			return "It does not exist";
		}
	} 


	function getData()
	{	
		
		$id_rol = $this->role->getIdRole();
		
		$sql = "SELECT * FROM ROL WHERE  id = '$id_rol' ";
	    
	    if (!($resultado = $this->mysqli->query($sql))){
			return 'It does not exist in DB'; 
		}
	    else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 


	function Edit()
	{
		$id_rol = $this->role->getIdRole();
		$name_rol= $this->role->getNombreRole();
		
	    $sql = "SELECT * FROM ROL WHERE  id = '$id_rol' ";
	    
	    $result = $this->mysqli->query($sql); 
		
	    if ($result->num_rows == 1) 
	    {	
			$sql = "UPDATE ROL SET nombre = '$name_rol' WHERE id = '$id_rol' ";
			
	        if (!($resultado = $this->mysqli->query($sql))){ 
					return 'Unknowed Error';
			}
			else{ 
				return 'Success Modify';
			}
	    }
	    else 
	    	return 'It does not exist in DB';
	} 

	function getActionFunctionality()
	{		
		$id_rol = $this->role->getIdRole();
		
		$sql = "SELECT nombre, id FROM ACCION ";
		$sql2 = "SELECT nombre, id FROM FUNCIONALIDAD";
		$sql3 = "SELECT * FROM ROL_PERMISOS WHERE id_ROL = '$id_rol'";
		
		if (!($resultado = $this->mysqli->query($sql)) 
			|| !($resultado2 = $this->mysqli->query($sql2)) 
			|| !($resultado3 = $this->mysqli->query($sql3))) { 

			return 'It does not exist in DB'; 
		}
		else{ 

			$return = array($resultado, $resultado2, $resultado3);
			return $return;
		}

	} 

	function DeletePermission(){

		$id_rol = $this->role->getIdRole();

		$sql = "DELETE FROM ROL_PERMISOS WHERE id_ROL = '$id_rol' ";
		
		if($this->mysqli->query($sql)){
			return "Correctly modify";
		}
		/*
		if($this->mysqli->query($sql)){ // se ejecuta la query
			$sql2 = "DELETE FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '$functionalityId')";

			if($this->mysqli->query($sql2)){ // se ejecuta la query
				return "Correctly delete";
			}
		}*/

		return "Not delete"; 
	
	}

	function setRolePermission($function,$action){

		$id_rol = $this->role->getIdRole();

		$sql = "INSERT INTO ROL_PERMISOS (id_ROL, id_FUNCIONALIDAD, id_ACCION) VALUES ('$id_rol','$function','$action')";
		
		if($this->mysqli->query($sql)){
			return "Correctly inserted";
		}
		/*
		if($this->mysqli->query($sql)){ // se ejecuta la query
			$sql2 = "DELETE FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '$functionalityId')";

			if($this->mysqli->query($sql2)){ // se ejecuta la query
				return "Correctly delete";
			}
		}*/
		
		return "Not inserted"; 

	}

	function check($function, $action, $user){

		$sql = "SELECT * FROM USUARIO U INNER JOIN ROL_PERMISOS RP ON RP.ROL_id = U.ROL_id 
					where RP.ACCION_id = (SELECT A.id FROM ACCION A WHERE A.nombre = '$action')
					AND RP.FUNCIONALIDAD_id = (SELECT F.id FROM FUNCIONALIDAD F WHERE F.nombre = '$function')
					AND U.LOGIN = '$user'";

		/*$sql = "SELECT * FROM `usuario_rol` INNER JOIN rol_permiso ON rol_permiso.id_ROL=usuario_rol.id_ROL 
					WHERE rol_permiso.id_ACCION = (SELECT accion.id FROM accion WHERE accion.nombre = '$action') 
					AND rol_permiso.id_FUNCIONALIDAD = (SELECT funcionalidad.id FROM funcionalidad WHERE funcionalidad.nombre = '$function') 
					AND usuario_rol.id_USUARIO = '$user'";*/

		$resultado = $this->mysqli->query($sql);
		if($resultado->num_rows == 1) {
			return true;
		} else {
			echo $this->mysqli->error; //exit;

			return false;
		}

	}

	function __destruct()
	{

	} 

}

?> 

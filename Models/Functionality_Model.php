
<?php

class Functionality_Model {
	
	var $mysqli;

	function __construct($functionality){
		
		$this->functionality = $functionality;
		
		include '../Models/DB/BdAdmin.php';
		
		$this->mysqli = ConnectDB();

	}

	function Add()
	{   
		$functionalityName= $this->functionality->getNombreFuncionalidad();
		$functionalityDesc= $this->functionality->getDescripFuncionalidad();

		$sql = "INSERT INTO `funcionalidad` (`nombre`, `descripcion`) 
		VALUES ('".$functionalityName."', '".$functionalityDesc."');";
		
		if (!$this->mysqli->query($sql)) { 
			
			return 'Unknowed Error';
		
		}
		else{ 
			return 'Inserción correcta';
		}

	}

	function __destruct()
	{

	} 


	function AllData(){

		$sql = "SELECT * FROM `funcionalidad` WHERE borrado = 0";
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

		$functionalityId = $this->functionality->getIdFuncionalidad();

	    $sql = "SELECT * FROM `funcionalidad` WHERE (id = '".$functionalityId."')";
	    
	    $result = $this->mysqli->query($sql); 
	    
	    if ($result->num_rows == 1) 
	    {

	        $sql = "UPDATE `funcionalidad` SET 
						borrado = 1
						WHERE ( id = '".$functionalityId."'
					)";
			
			if($this->mysqli->query($sql)){
				return "Correctly delete";
			}
	        
	    	return "Not delete"; 
	    } 
	    else 
	        return "It does not exist";
	} 


	function getData()
	{	
		
		$functionalityId = $this->functionality->getIdFuncionalidad();
		
		$sql = "SELECT * FROM `funcionalidad` WHERE id = '".$functionalityId."' AND (borrado = 0)";
	    
	    if (!($resultado = $this->mysqli->query($sql))){ 
			return 'It does not exist in DB'; 
		}
	    else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 

	function EDIT()
	{
		$functionalityId = $this->functionality->getIdFuncionalidad();
		$functionalityName= $this->functionality->getNombreFuncionalidad();
		$functionalityDesc= $this->functionality->getDescripFuncionalidad();


	    $sql = "SELECT * FROM `funcionalidad` WHERE (id = '".$functionalityId."')";
	    
	    $result = $this->mysqli->query($sql);
		
	    if ($result->num_rows == 1) 
	    {	
	        
			$sql = "UPDATE `funcionalidad` SET 
						nombre = '".$functionalityName."',
						descripcion = '".$functionalityDesc."'
					WHERE ( id = '".$functionalityId."'
					)";
			
	        if (!($resultado = $this->mysqli->query($sql))){ 
					return 'Unknowed Error';
			}
			else { 
				
				return 'Success Modify';
			}
	    }
	    else 
	    	return 'It does not exist in DB';
	} 


	function fetchAcciones(){

		$sql = "SELECT * FROM `accion` ";

		if (!($resultado = $this->mysqli->query($sql))){
			return 'It does not exist in DB'; 
		}
		else { 
			$result = $resultado;
			return $result;
		}
	}


	function fetchAccionesUsu(){

		$sql = "SELECT IdAccion FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."')";
		
		if (!($resultado = $this->mysqli->query($sql))){ 
			return 'It does not exist in DB';
		}
		else{ 
			$result = $resultado;
			return $result;
		}
	}



	function delAccionFun(){

		$sql = "DELETE FROM `FUNC_ACCION` WHERE (IdFuncionalidad = '".$this->IdFuncionalidad."') ";
		
		if ($result = $this->mysqli->query($sql)) { 
			return 'Success delete'; 
		}else{ 
			return 'Unknowed Error'; 
		}
	}


	function setAccion($id){

		$sql = "INSERT INTO `FUNC_ACCION` (`IdAccion`,`IdFuncionalidad`) VALUES ('".$id."','".$this->IdFuncionalidad."');";
		
		if ($result = $this->mysqli->query($sql)) {
			return 'Success insert'; 
		} else{ 
			return 'Unknowed Error'; 
		}
		
	}

}

?> 

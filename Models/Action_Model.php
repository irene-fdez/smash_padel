
<?php

class Action_Model { 

    var $mysqli;


    function __construct($action){

        $this->action = $action;
        
        include '../Models/DB/BdAdmin.php';
        
        $this->mysqli = ConnectDB();

    } 



    function Add()
    {
       
        $actionName= $this->action->getNombreAccion();
        $actionDesc= $this->action->getDescripAccion();
        
        $sql = "INSERT INTO `accion` (`nombre`, `descripcion`) 
            VALUES ('".$actionName."', '".$actionDesc."');";

        if (!$this->mysqli->query($sql)) {
            return 'Unknowed Error';

        }
        else{ 
            return 'Success insert'; 
        }

    } 


    function __destruct()
    {

    } 

    function AllData(){

        $sql = "SELECT * FROM `accion` WHERE borrado = 0";
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
        $actionId= $this->action->getIdAccion();
        
        $sql = "SELECT * FROM `accion` WHERE (id = '".$actionId."')";
       
        $result = $this->mysqli->query($sql);
        
        if ($result->num_rows == 1)
        {

            $sql2 = "DELETE FROM `rol_permiso` WHERE (id_ACCION = '".$actionId."')";

            $this->mysqli->query($sql2);
            
            $sql = "UPDATE `accion` SET borrado = 1 WHERE ( id = '".$actionId."')";
            
            $this->mysqli->query($sql);
            
            return 'Correctly delete';
        } 
        else

            return 'It does not exist in DB';
    } 

    function getData()
    {
        
        $actionId= $this->action->getIdAccion();

        print_r($actionId);
        
        $sql = "SELECT * FROM `accion` WHERE id = '".$actionId."'";

        
        if (!($resultado = $this->mysqli->query($sql))){
            return 'It does not exist in DB'; //
        }
        else {
            $result = $resultado->fetch_array();
            return $result;
        }
    }


    function Edit()
    {
        $actionId= $this->action->getIdAccion();
        $actionName= $this->action->getNombreAccion();
        $actionDesc= $this->action->getDescripAccion();

        $sql = "SELECT * FROM `accion` WHERE (id = '".$actionId."')";
     
        $result = $this->mysqli->query($sql);
     

        if ($result->num_rows == 1)
        {
            $sql = "UPDATE `accion` SET 
					nombre = '".$actionName."',
					descripcion = '".$actionDesc."'
				WHERE ( id = '".$actionId."'
				)";
        
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
}

?>
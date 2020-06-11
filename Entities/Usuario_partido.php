<?php

class Usuario_partido {

    var $login_user;
	var $fecha_partido; 
   
    function __construct($login_user, $id_partido){
		$this->login_user = $login_user;
		$this->id_partido = $id_partido;
    } 


    function getLogin_user(){
        return $this->login_user;
    }

    function setLogin_user($login_user){
        $this->login_user = $login_user;
    }

    
    function getId_partido(){
        return $this->id_partido;
    }

    function setId_partido($id_partido){
        $this->id_partido = $id_partido;
    }
    
    function check() {
        $error = false;


        if (strlen($this->login_user) < 2) {
            $error = true;
        }

        if (strlen($this->id_partido)  < 2) {
            $error = true;
        }

        return $error;
    }

}

?>

<?php

class Rol {

    var $id_rol; 
	var $nombre_rol; 
    
    function __construct($id_rol,$nombre_rol){
		$this->id_rol = $id_rol;
        $this->nombre_rol = $nombre_rol;
    } 
    
    function setId_rol($id_rol){
        $this->id_rol = $id_rol;
    }

    function getId_rol(){
        return $this->id_rol;
    }

    function setNombre_rol($nombre_rol){
        $this->nombre_rol = $nombre_rol;
    }

    function getNombre_rol(){
        return $this->nombre_rol;
    }

    function check() {
        $error = false;

        if (strlen($this->nombre_rol) < 2) {
            $error = true;
        }

        return $error;
    }


}

?>
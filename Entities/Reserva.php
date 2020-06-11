<?php

class Reserva {

    var $id; 
	var $fecha; 
	var $login_user; 
    var $id_horario;
    var $nombre_pista;
    
    function __construct($id, $fecha, $login_user, $id_horario, $nombre_pista){
		$this->id = $id;
		$this->fecha = $fecha;
		$this->login_user = $login_user;
        $this->id_horario = $id_horario;
        $this->nombre_pista = $nombre_pista;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getFecha(){
        return $this->fecha;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }
    

    function getLogin_user(){
        return $this->login_user;
    }

    function setLogin_user($login_user){
        $this->login_user = $login_user;
    }

    function getId_horario(){
        return $this->id_horario;
    }

    function setId_horario($id_horario){
        $this->id_horario = $id_horario;
    }

    function getNombre_pista(){
        return $this->nombre_pista;
    }

    function setNombre_pista($nombre_pista){
        $this->nombre_pista = $nombre_pista;
    }

  /*  function checkSearch() {
        $error = true;

        if (strlen($this->fecha) <= 9) {
            $error = false;
        }else if (strlen($this->login_user) < 255) {
            $error = false;
        }else if (strlen($this->id_horario) < 255) {
            $error = false;
        }else if (strlen($this->nombre_pista) < 255) {
            $error = true;
        }

        return $error;
    }*/


    function check() {
        $error = false;


        if (strlen($this->fecha) < 2) {
            $error = true;
        }

        if (strlen($this->login_user)  < 2) {
            $error = true;
        }
        
        if (strlen($this->id_horario)  < 2) {
            $error = true;
        }

        if (strlen($this->nombre_pista)  < 2) {
            $error = true;
        }

        return $error;
    }

}

?>

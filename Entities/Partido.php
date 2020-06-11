<?php

class Partido {

	var $id; 
	var $fecha; 
	var $inscripciones; 
    var $login_user;
    var $id_reserva; 
    var $id_horario;
   

    
    function __construct($id, $fecha, $inscripciones, $login_user, $id_reserva, $id_horario){
		$this->id = $id;
		$this->fecha = $fecha;
		$this->inscripciones = $inscripciones;
		$this->login_user = $login_user;
        $this->id_reserva = $id_reserva;
        $this->id_horario = $id_horario;
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

    function getInscripciones(){
        return $this->inscripciones;
    }

    function setInscripciones($inscripciones){
        $this->inscripciones = $inscripciones;
    }

    function getLogin_user(){
        return $this->login_user;
    }

    function setLogin_user($login_user){
        $this->login_user = $login_user;
    }

    function getId_reserva(){
        return $this->id_reserva;
    }

    function setId_reserva($id_reserva){
        $this->id_reserva = $id_reserva;
    }

    function getId_horario(){
        return $this->id_horario;
    }

    function setId_horario($id_horario){
        $this->id_horario = $id_horario;
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
        
        if (strlen($this->id_reserva)  < 2) {
            $error = true;
        }

        if (strlen($this->id_horario)  < 2) {
            $error = true;
        }

        return $error;
    }

}

?>

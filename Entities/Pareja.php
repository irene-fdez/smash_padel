<?php

class Pareja {

    var $id;
    var $capitan;
    var $jugador_2;

    
    function __construct($id, $capitan, $jugador_2){
        $this->id = $id;
        $this->capitan= $capitan;
        $this->jugador_2 = $jugador_2;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getCapitan(){
        return $this->capitan;
    }

    function setCapitan($capitan){
        $this->capitan = $capitan;
    }

    function getJugador_2(){
        return $this->jugador_2;
    }


    function setJugador_2($jugador_2){
        $this->jugador_2 = $jugador_2;
    }

}

?>